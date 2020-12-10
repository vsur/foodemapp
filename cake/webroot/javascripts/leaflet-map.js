// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);

// Static user position when no device values are available
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
    };
    var popupContent = "Keine Inhalte gesetzt";
    
    // marker.addTo(markers).bindPopup(popupContent, popupOptions).openPopup();
    markers.addLayer(
        marker.bindPopup(popupContent, popupOptions).openPopup()
    );
    
});

markers.on('animationend', function (a) {
    reopenLastSelectedPopupcontent();
});


mymap.addLayer(markers);
// mymap.setView([49.01, 8.40806], 13);
mymap.fitBounds(markers.getBounds());

// Update popup content
updateMarkersContent(markers, "chosen");

// Open all popups
openAllMarkersPopups(markers);

// Handling user position
function onLocationFound(e) {
    var radius = e.accuracy / 2;
    console.log("User position detected by device");
    showUserPosition(e.latLng, radius);
}

function onLocationError(e) {
    console.log(e);
    showUserPosition(staticUserPosition, 50);
}

mymap.on('locationfound', onLocationFound);
mymap.on('locationerror', onLocationError);

mymap.locate({setView: true, maxZoom: 16});

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
    setTimeout( () => 
        mymap.flyTo(latLng, 13, {
            animate: true,
            duration: animationDuration
        }), 1250
    );
}

function updateMarkersContent(markers, newContentType) {
    
    for (var markerProperty in markers._featureGroup._layers) {
        marker = markers._featureGroup._layers[markerProperty];
        
        if(marker.hasOwnProperty("_popup")) {

            let popupContent = "";

            switch (newContentType) {
                case "chosen":
                    popupContent = buildRankedSelectionPopupContent();
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
        openAllMarkersPopups(markers) ;
    }
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
    console.log("Komponenten die anzuzeigen sind: " +  componentsToPresent );
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
    });
});