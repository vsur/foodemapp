// Put here Stuff for Leaflet

// Static user position 
// console.log("Coming from MAP: ");
// console.log(fmApp.geoLocation);
var staticUserPosition =  L.latLng(49.01, 8.40806);
var userPositionLayer = L.layerGroup();
var pulsingIcon = L.icon.pulse({
    iconSize: [18,18],
    fillColor: '#2196F3',
    color: '#2196F3',
    heartbeat: 3,
});

// Initalize LMap
var mymap = L.map('ypoisMap');
// var markers = L.layerGroup([]);
var markers = L.markerClusterGroup();
var connectionLines = L.layerGroup();

L.tileLayer.provider('OpenStreetMap.HOT').addTo(mymap);

ypois.forEach(function(ypoi, i) {
    var newIcon = L.divIcon({
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -35],
    });;
    
    newIcon.options.className = 'ypoiIcon';
    newIcon.options.html = '<div><span>' + ypoi.name + '</span></div>';
    
    var marker = L.marker([ypoi.lat, ypoi.lng], {
        icon: newIcon,
        poiName: ypoi.name,
        poiDistance: (ypoi.distance ? ( ( Math.round( ypoi.distance * 1000) / 1000 )+ ' km').replace('.', ',') : 'Nicht verfügbar, da keine GEO Position gesetzt') ,
        binaryComponents: ypoi.binary_components,
        nominalAttributes: ypoi.nominal_attributes,
        ordinalAttributes: ypoi.ordinal_attributes
    });
    
    var popupOptions = {
        className: "infoPopup",
        maxWidth: 150,
        minWidth: 150,
        closeButton: false,
        closeOnClick: false,
        closeOnEscapeKey: false,
        autoClose: false,
        autoPan: false,
        hasConnectionLine: false
    };
    var popupContent = "Keine Inhalte gesetzt";
    
    // marker.addTo(markers).bindPopup(popupContent, popupOptions).openPopup();
    markers.addLayer(
        marker.bindPopup(popupContent, popupOptions).openPopup()
    );
    marker.on('remove', (e) => {
        deleteDrawnLine(e.sourceTarget._popup);
    });
    marker.getPopup().on('remove', function(e) {
        deleteDrawnLine(e.sourceTarget);
    });
    marker.on('add', (e) => {
        e.sourceTarget.openPopup();
    });
});

markers.on('animationend', function (e) {
    reopenLastSelectedPopupcontent();
});

mymap.addLayer(markers);
// mymap.setView([49.01, 8.40806], 13);
mymap.fitBounds(markers.getBounds());
// Prepare layer for connection lines between popups and markers
mymap.addLayer(connectionLines);

// Update popup content
updateMarkersContent(markers, "chosen");

// Open all popups
if(!!configuredSelection) openAllMarkersPopups(markers);

mymap.on('zoomstart', (e) => connectionLines.clearLayers() );

// Handling user position
function onLocationFound(e) {
    var radius = e.accuracy / 2;
    console.log("User position detected by device", e);
    // showUserPosition(e.latLng, radius); // For evaluation the position musst be set by static properties
    showUserPosition(staticUserPosition, 50);
}

function onLocationError(e) {
    console.log(e);
    showUserPosition(staticUserPosition, 50);
}

mymap.on('locationfound', onLocationFound);
mymap.on('locationerror', onLocationError);

mymap.locate({setView: false, maxZoom: 16});

mymap.addLayer(userPositionLayer);


function showUserPosition(latLng, radius) {
    
    var userMarker = L.marker(latLng,{icon: pulsingIcon});

    var userAccuracyArea = L.circle(latLng, {
        radius: radius,
        color: '#ffffff',
        weight: 3,
        opacity: 0.75,
        fillColor: '#2196F3' 
    });

    userPositionLayer.addLayer(userMarker);
    userPositionLayer.addLayer(userAccuracyArea);

    let animationDuration = 3;
    setTimeout( () => {
            mymap.flyTo(latLng, 13, {
                animate: true,
                duration: animationDuration
            });
        }, 1250
    );
}

function updateMarkersContent(markers, newContentType) {
    connectionLines.clearLayers();
    for (var markerProperty in markers._featureGroup._layers) {
        marker = markers._featureGroup._layers[markerProperty];
        
        if(marker.hasOwnProperty("_popup")) {

            let popupContent = "";

            switch (newContentType) {
                case "chosen":
                    popupContent = buildRankedSelectionPopupContent();
                    break;

                case "distance":
                    popupContent = buildDistancePopupContent(marker);
                    break;

                case "none":
                    popupContent = "Kein Inhalt gesetzt";
                    break;
                
                case "other":
                    popupContent = buildOtherComponentsPopupContent(marker, 'all');
                    break;
                
                case "justBinary":
                    popupContent = buildOtherComponentsPopupContent(marker, newContentType);
                    break;

                case "justNominal":
                    popupContent = buildOtherComponentsPopupContent(marker, newContentType);
                    break;

                case "justOrdinal":
                    popupContent = buildOtherComponentsPopupContent(marker, newContentType);
                    break;
            }
            marker._popup.setContent(popupContent);
        }
    }
}

function openAllMarkersPopups(markers) {
    for (var markerProperty in markers._featureGroup._layers) {
        markers._featureGroup._layers[markerProperty].openPopup();
        let popup = markers._featureGroup._layers[markerProperty]._popup;
        if(popup  !== undefined) {
            popup.update(makePopupDraggable(popup));
        }
    }
}

function closeAllMarkersPopups(markers) {
    for (var markerProperty in markers._featureGroup._layers) {
        markers._featureGroup._layers[markerProperty].closePopup();
    }
}
function reopenLastSelectedPopupcontent() {
    let lastSelectedPopupContent = "";
    $("#mapComponentsChoice li").each(function() {
        if( $( this ).hasClass('active') ) {
            lastSelectedPopupContent = $(this).children("a").attr('data-component-presentation');
        }
    }); 
    updateMarkersContent(markers, lastSelectedPopupContent);
    if(lastSelectedPopupContent != "none") {
        openAllMarkersPopups(markers);
    }
}

function makePopupDraggable(popup) {
    var pos = mymap.latLngToLayerPoint(popup.getLatLng());
    L.DomUtil.setPosition(popup._wrapper.parentNode, pos);
    var draggable = new L.Draggable(popup._container, popup._wrapper);
    draggable.enable();
    draggable.on('dragstart', function() {
        deleteDrawnLine(popup);
    });
    draggable.on('dragend', function() {
        let pixelXYValueOfMarkerCenter = mymap.latLngToLayerPoint(popup._source._latlng);
        
        // Standard-Offset -2 < X < 2 | 32 < Y < 34 
        let xPosCorrection = 0; // Popup-X-Mitte
        let yPosCorrection = 0; // Popup-Y-Unten

        let popupToMarkerPosDelta = {
            x:  pixelXYValueOfMarkerCenter.x - this._newPos.x,
            y:  pixelXYValueOfMarkerCenter.y -this._newPos.y
        }

        // Set Offset based on Position
        if (popupToMarkerPosDelta.x < -500 || (popupToMarkerPosDelta.x < -125 && popupToMarkerPosDelta.y < -75 ) ) xPosCorrection = -15 - (this._element.offsetWidth/2); // Popup-X-Links
        if (popupToMarkerPosDelta.x > 75) xPosCorrection = +15 + (this._element.offsetWidth/2); // Popup-X-Rechts
        if (popupToMarkerPosDelta.y < -180 || popupToMarkerPosDelta.x > 500) yPosCorrection = -15 - (this._element.offsetHeight/2); // Popup-Y-Mitte
        if (popupToMarkerPosDelta.y < -250) yPosCorrection = -30 - (this._element.offsetHeight); // Popup-Y-Oben

        let newStartPos = {
            x:  this._newPos.x + xPosCorrection,
            y:  this._newPos.y + yPosCorrection
        }

        let connectionLinePositions = {
            start: mymap.layerPointToLatLng(newStartPos),
            end: mymap.layerPointToLatLng(pixelXYValueOfMarkerCenter)
        };

        drawConncetionLine(connectionLinePositions, popup);
    });
}

function drawConncetionLine(path, popup) {
    
    let options = {
        color: 'rgba(125, 0, 60)',
        opacity: 0.75,
        weight: '5',
        lineCap: 'round',
        iconTravelLength: 1, //How far icon should go. 0.5 = 50%
        iconMaxWidth: 25,
        iconMaxHeight: 25,
        fullAnimatedTime: 1500, // animation time in ms
        className: 'poiPopUpConnectionLine',
        connectedPopup: popup._leaflet_id
    };
    let iconPathString = window.location.origin;
    var pathname = window.location.pathname;
    var cutIndex = pathname.indexOf("ypois/find-matches/map");
    iconPathString += pathname.substring(0, cutIndex);
    iconPathString += "img/chevron-up-ur.svg";
    var connectionLine = L.bezier({
        path: [
            [
                {lat: path.start.lat, lng: path.start.lng},
                {lat: path.end.lat, lng: path.end.lng},
            ]
        ],
    
        icon: {
            path: iconPathString
        }
    }, options);

    connectionLines.addLayer(connectionLine);
    popup.options.hasConnectionLine = true;
}

function deleteDrawnLine(connectedPopup) {
    let layerIndexToDelete = -1;
    for (const [layerIndex, layer] of Object.entries(connectionLines._layers)) {
        if(layer._layers[Object.keys(layer._layers)[0]].options.connectedPopup == connectedPopup._leaflet_id) {
            layerIndexToDelete = layerIndex;
        }
    }
    if(layerIndexToDelete >= 0) connectionLines.removeLayer(layerIndexToDelete);
}

function buildRankedSelectionPopupContent() {
    let contentString = '<ul class="list-unstyled popUpComponentList">';

    // Iterate over rated components
    contentString += buildNStarRatingListItems(rankedSelection.rating5, 5);
    contentString += buildNStarRatingListItems(rankedSelection.rating4, 4);
    contentString += buildNStarRatingListItems(rankedSelection.rating3, 3);
    contentString += buildNStarRatingListItems(rankedSelection.rating2, 2);
    contentString += buildNStarRatingListItems(rankedSelection.rating1, 1);

    contentString += '</ul>';
    return contentString;
}

function buildNStarRatingListItems(ratedComponents, N_StarRating) {
    var ratingString = '';

        // Iterate over binary components
        ratedComponents.binaryComponents.forEach(function(rankedBinary, index) {
            ratingString += '<li class="binaryComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<span class="binaryComponentInfo">'
            ratingString +=    '    <span>' + ( rankedBinary.display_name != '' ? rankedBinary.display_name : rankedBinary.name ) + '</span>'
            ratingString +=    '    <span class="pull-right"><span class="glyphicon ' + ( rankedBinary.binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ) + ' ' + ( rankedBinary.binaryComponentState ? 'text-success' : 'text-danger' ) + '" aria-hidden="true"></span></span>'
            ratingString +=    '</span>'
            
            ratingString += '</li>';
        });

        // Iterate over nominal attributes
        ratedComponents.nominalAttributes.forEach(function(rankedNominal, index) {
            ratingString += '<li class="nominalComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' + (rankedNominal.icon_path != '' ? rankedNominal.icon_path : 'iconPlaceholder') + '"></figure></div>';
            ratingString +=    '<span class="nominalNameCombo"><span class="componentNameNominalComponent' + (rankedNominal.nominal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedNominal.nominal_component.display_name != '' ? (rankedNominal.nominal_component.display_name) : rankedNominal.nominal_component.name) + '</span> <span class="attributeNameNominalAttribute ' + (rankedNominal.display_name != '' ? 'textURcolorSuperLight' : 'text-muted') + '">' + (rankedNominal.display_name != '' ? rankedNominal.display_name : rankedNominal.name) + '</span></span>';

            ratingString += '</li>';
        });

        // Iteratre over ordinal attributes
        ratedComponents.ordinalAttributes.forEach(function(rankedOrdinal, index) {
            ratingString += '<li class="ordinalComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<span class="ordinalComponentInfo">';
            ratingString +=         '<span class="componentNameOrdinalComponent' + (rankedOrdinal.ordinal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedOrdinal.ordinal_component.display_name != '' ? ( rankedOrdinal.ordinal_component.display_name) :  rankedOrdinal.ordinal_component.name) + '</span>';
            ratingString +=         '<span class="attributeNameOrdinalAttribute pull-right ' + (rankedOrdinal.display_name != '' ? 'textURcolorSuperLight' : 'text-muted') + '">' + (rankedOrdinal.display_name != '' ? rankedOrdinal.display_name : rankedOrdinal.name) + '</span>';
            ratingString +=    '</span>'

            ratingString += '</li>';
        });

        return ratingString;
}
function buildDistancePopupContent(marker) {
    
    let contentString = '<ul class="list-unstyled popUpComponentList">';
    
    contentString += '<li class="distanceInfo clearfix">';

    contentString +=    '<strong>';
    contentString +=        '&#10132; Entfernung: ';
    contentString +=        marker.options.poiDistance;
    contentString +=    '</strong>';
            
    contentString += '</li>';

    contentString += '</ul>';

    return contentString;
}

function buildOtherComponentsPopupContent(marker, componentTypes) {
    let contentString = '<ul class="list-unstyled popUpComponentList">';

    // Iterate over all components of ypoi
    if(componentTypes == 'all' || componentTypes == 'justBinary') contentString += buildBinaryComponents(marker.options.binaryComponents);
    if(componentTypes == 'all' || componentTypes == 'justNominal') contentString += buildNominalComponents(marker.options.nominalAttributes);
    if(componentTypes == 'all' || componentTypes == 'justOrdinal') contentString += buildOrdinalComponents(marker.options.ordinalAttributes);

    contentString += '</ul>';
    return contentString;
}

function buildBinaryComponents(binaryComponents) {
    var binaryComponentString = '';
    binaryComponents.forEach(function(binaryComponent) {
        binaryComponentString += '<li class="binaryComponentContainer clearfix">';
        binaryComponentString +=    '<span class="binaryComponentInfo">';
        binaryComponentString +=    '    <span>' + ( binaryComponent.display_name != '' ? binaryComponent.display_name : binaryComponent.name ) + '</span>'
        binaryComponentString +=    '    <span class="pull-right"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>';
        binaryComponentString +=    '</span>';

        // binaryComponentString +=    '<span class="componentNameBinarySlider' +  (binaryComponent.display_name != '' ? '' : ' text-muted') + '">' + (binaryComponent.display_name != '' ? binaryComponent.display_name : binaryComponent.name) + '</span><label class="switch pull-right"><input type="checkbox"' +  (binaryComponent.binaryComponentState == true ? 'checked' : '') + ' disabled><span class="slider round"></span></label>';
            
        binaryComponentString += '</li>';
    });
    return binaryComponentString;
}
function buildNominalComponents(nominalAttributes) {
    var nominalComponentString = '';
    nominalAttributes.forEach(function(nominalAttribute, index) {
        nominalComponentString += '<li class="nominalComponentContainer clearfix">';

        nominalComponentString +=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' + (nominalAttribute.icon_path != '' ? nominalAttribute.icon_path : 'iconPlaceholder') + '"></figure></div>';
        nominalComponentString +=    '<span class="nominalNameCombo"><span class="componentNameNominalComponent' + (nominalAttribute.nominal_component.display_name != '' ? '' : ' text-muted') + '">' + (nominalAttribute.nominal_component.display_name != '' ? (nominalAttribute.nominal_component.display_name) : nominalAttribute.nominal_component.name) + '</span> <span class="attributeNameNominalAttribute ' + (nominalAttribute.display_name != '' ? 'textURcolorSuperLight' : 'text-muted') + '">' + (nominalAttribute.display_name != '' ? nominalAttribute.display_name : nominalAttribute.name) + '</span></span>';

        nominalComponentString += '</li>';
    });
    return nominalComponentString;
}
function buildOrdinalComponents(ordinalAttributes) {
    var ordinalComponentString = '';
    ordinalAttributes.forEach(function(ordinalAttribute, index) {
        ordinalComponentString += '<li class="ordinalComponentContainer clearfix">';

        ordinalComponentString +=    '<span class="componentNameOrdinalComponent' + (ordinalAttribute.ordinal_component.display_name != '' ? '' : ' text-muted') + '">' + (ordinalAttribute.ordinal_component.display_name != '' ? ( ordinalAttribute.ordinal_component.display_name) :  ordinalAttribute.ordinal_component.name) + '</span>';
        ordinalComponentString +=    '<span class="attributeNameOrdinalAttribute pull-right ' + (ordinalAttribute.display_name != '' ? 'textURcolorSuperLight' : 'text-muted') + '">' + (ordinalAttribute.display_name != '' ? ordinalAttribute.display_name : ordinalAttribute.name) + '</span>';

        ordinalComponentString += '</li>';
    });
    return ordinalComponentString;
}

function  updateShownComponents(componentsToPresent, clickedAncher) {
    console.log("Kategorien die anzuzeigen sind: " +  componentsToPresent );
    updateMarkersContent(markers, componentsToPresent);
    if(componentsToPresent == "none") {
        closeAllMarkersPopups(markers);
    } else {
        openAllMarkersPopups(markers);
    }
    $(clickedAncher).parent("li").addClass('active');
} 


$(document).ready(function() { 
    $("#mapComponentsChoice a").click(function (event) {
        var componentsToPresent = $(this).attr('data-component-presentation');
        $("#mapComponentsChoice li").removeClass('active');
        updateShownComponents(componentsToPresent, this);
        $('#collapse-mapComponentsChoice').collapse("hide");
    });
});