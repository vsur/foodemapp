// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('ypoisMap');
// var markers = L.layerGroup([]);
var markers = L.markerClusterGroup({
    // spiderfyOnMaxZoom: false, 
    // showCoverageOnHover: false, 
    // zoomToBoundsOnClick: false,
    // animate: false
});

L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);

ypois.forEach(function(ypoi, i) {
    var newIcon = L.divIcon({
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -35],
    });;
    
    newIcon.options.className = 'ypoiIcon';
    newIcon.options.html = '<div><span>' + ypoi.name + ' ' + i +'</span></div>';
    
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
    };
    var popupContent = "Keine Inhalte gesetzt";
    
    marker.addTo(markers).bindPopup(popupContent, popupOptions).openPopup();
    
});

markers.on('animationend', function (a) {
    reopenLastSelectedPopupcontent();
});


markers.addTo(mymap);
// mymap.setView([49.01, 8.40806], 13);
mymap.fitBounds(markers.getBounds());

// Update popup content
updateMarkersContent(markers, "chosen");

// Open all popups
openAllMarkersPopups(markers);

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
            ratingString +=    '<span class="componentNameBinarySlider' +  (rankedBinary.display_name != '' ? '' : ' text-muted') + '">' + (rankedBinary.display_name != '' ? rankedBinary.display_name : rankedBinary.name) + '</span><label class="switch pull-right"><input type="checkbox"' +  (rankedBinary.binaryComponentState == true ? 'checked' : '') + ' disabled><span class="slider round"></span></label>';
            
            ratingString += '</li>';
        });

        // Iterate over nominal attributes
        ratedComponents.nominalAttributes.forEach(function(rankedNominal, index) {
            ratingString += '<li class="nominalComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' + (rankedNominal.icon_path != '' ? rankedNominal.icon_path : 'iconPlaceholder') + '"></figure></div>';
            ratingString +=    '<span class="nominalNameCombo"><span class="componentNameNominalComponent' + (rankedNominal.nominal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedNominal.nominal_component.display_name != '' ? (rankedNominal.nominal_component.display_name) : rankedNominal.nominal_component.name) + '</span> <span class="attributeNameNominalAttribute ' + (rankedNominal.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (rankedNominal.display_name != '' ? rankedNominal.display_name : rankedNominal.name) + '</span></span>';

            ratingString += '</li>';
        });

        // Iteratre over ordinal attributes
        ratedComponents.ordinalAttributes.forEach(function(rankedOrdinal, index) {
            ratingString += '<li class="ordinalComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<span class="componentNameOrdinalComponent' + (rankedOrdinal.ordinal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedOrdinal.ordinal_component.display_name != '' ? ( rankedOrdinal.ordinal_component.display_name) :  rankedOrdinal.ordinal_component.name) + '</span> <span class="attributeNameOrdinalAttribute ' + (rankedOrdinal.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (rankedOrdinal.display_name != '' ? rankedOrdinal.display_name : rankedOrdinal.name) + '</span> <br>';

            let minRange = rankedOrdinal.ordinal_component.ordinal_attributes.slice(0)[0].meter;
            let maxRange = rankedOrdinal.ordinal_component.ordinal_attributes.slice(-1)[0].meter;

            ratingString +=    '<input type="range" min="' + minRange + '" max="' + maxRange + '" step="1" value="' + rankedOrdinal.meter + '" disabled>';

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

        binaryComponentString +=    '<span class="componentNameBinarySlider' +  (binaryComponent.display_name != '' ? '' : ' text-muted') + '">' + (binaryComponent.display_name != '' ? binaryComponent.display_name : binaryComponent.name) + '</span><label class="switch pull-right"><input type="checkbox"' +  (binaryComponent.binaryComponentState == true ? 'checked' : '') + ' disabled><span class="slider round"></span></label>';
            
        binaryComponentString += '</li>';
    });
    return binaryComponentString;
}
function buildNominalComponents(nominalAttributes) {
    var nominalComponentString = '';
    nominalAttributes.forEach(function(nominalAttribute, index) {
        nominalComponentString += '<li class="nominalComponentContainer clearfix">';

        nominalComponentString +=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' + (nominalAttribute.icon_path != '' ? nominalAttribute.icon_path : 'iconPlaceholder') + '"></figure></div>';
        nominalComponentString +=    '<span class="nominalNameCombo"><span class="componentNameNominalComponent' + (nominalAttribute.nominal_component.display_name != '' ? '' : ' text-muted') + '">' + (nominalAttribute.nominal_component.display_name != '' ? (nominalAttribute.nominal_component.display_name) : nominalAttribute.nominal_component.name) + '</span> <span class="attributeNameNominalAttribute ' + (nominalAttribute.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (nominalAttribute.display_name != '' ? nominalAttribute.display_name : nominalAttribute.name) + '</span></span>';

        nominalComponentString += '</li>';
    });
    return nominalComponentString;
}
function buildOrdinalComponents(ordinalAttributes) {
    var ordinalComponentString = '';
    ordinalAttributes.forEach(function(ordinalAttribute, index) {
        ordinalComponentString += '<li class="ordinalComponentContainer clearfix">';

        ordinalComponentString +=    '<span class="componentNameOrdinalComponent' + (ordinalAttribute.ordinal_component.display_name != '' ? '' : ' text-muted') + '">' + (ordinalAttribute.ordinal_component.display_name != '' ? ( ordinalAttribute.ordinal_component.display_name) :  ordinalAttribute.ordinal_component.name) + '</span> <span class="attributeNameOrdinalAttribute ' + (ordinalAttribute.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (ordinalAttribute.display_name != '' ? ordinalAttribute.display_name : ordinalAttribute.name) + '</span> <br>';

        let minRange = ordinalAttribute.ordinal_component.ordinal_attributes.slice(0)[0].meter;
        let maxRange = ordinalAttribute.ordinal_component.ordinal_attributes.slice(-1)[0].meter;

        ordinalComponentString +=    '<input type="range" min="' + minRange + '" max="' + maxRange + '" step="1" value="' + ordinalAttribute.meter + '" disabled>';

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