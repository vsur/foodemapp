// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('ypoisMap').setView([49.01, 8.40806], 13);
var myIcon = L.divIcon({
    iconSize: [32, 32],
    iconAnchor: [16, 16],
    popupAnchor: [0, -35],
});
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);
ypois.forEach(function(ypoi, i) {
    var newIcon = myIcon;
    newIcon.options.className = 'ypoiIcon';
    newIcon.options.html = '<div><span>' + ypoi.name + '</span></div>';
    var marker = L.marker([ypoi.lat, ypoi.lng], {icon: newIcon}).addTo(mymap);
    var popupOptions = {
        className: "infoPopup",
        maxWidth: 150,
        minWidth: 150,
        closeButton: false, 
        closeOnClick: false, 
        closeOnEscapeKey: false,
        autoClose: false, 
    };
    var popupContentFromRankedSelcetion = buildRankedSelectionPopupContent();
    marker.bindPopup(popupContentFromRankedSelcetion, popupOptions).openPopup();
});
mymap.setView([49.01, 8.40806], 13);

function buildRankedSelectionPopupContent() {
    let contentString = '<ul class="list-unstyled">';

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
        for (let rankedBinary in ratedComponents.binaryComponents) {
            ratingString += '<li class="binaryComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<span class="componentNameBinarySlider' +  (rankedBinary.display_name != '' ? '' : ' text-muted') + '">' + (rankedBinary.display_name != '' ? rankedBinary.display_name : rankedBinary.name) + '</span><label class="switch pull-right"><input type="checkbox"' +  (rankedBinary.binaryComponentState == 'checked' ? 'checked' : '') + ' disabled><span class="slider round"></span></label>';

            ratingString += '</li>';
        }

        // Iterate over nominal attributes
        for ( let rankedNominal in ratedComponents.nominalAttributes ) {
            ratingString += '<li class="nominalComponentContainer clearfix">';
console.log(rankedNominal);

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' + (rankedNominal.icon_path != '' ? rankedNominal.icon_path : 'iconPlaceholder') + '"></figure></div>';
            ratingString +=    '<span class="componentNameNominalComponent' + (rankedNominal.nominal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedNominal.nominal_component.display_name != '' ? (rankedNominal.nominal_component.display_name) : rankedNominal.nominal_component.name) + '</span> <br><span class="attributeNameNominalAttribute ' + (rankedNominal.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (rankedNominal.display_name != '' ? rankedNominal.display_name : rankedNominal.name) + '</span>';

            ratingString += '</li>';
        }

        // Iteratre over ordinal attributes
        for (let rankedOrdinal in ratedComponents.ordinalAttributes) {
            ratingString += '<li class="ordinalComponentContainer clearfix">';

            ratingString +=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' + N_StarRating + '</span></span>';
            ratingString +=    '<span class="componentNameOrdinalComponent' + (rankedOrdinal.ordinal_component.display_name != '' ? '' : ' text-muted') + '">' + (rankedOrdinal.ordinal_component.display_name != '' ? ( rankedOrdinal.ordinal_component.display_name) :  rankedOrdinal.ordinal_component.name) + '</span> <span class="attributeNameOrdinalAttribute ' + (rankedOrdinal.display_name != '' ? 'textURcolor' : 'text-muted') + '">' + (rankedOrdinal.display_name != '' ? rankedOrdinal.display_name : rankedOrdinal.name) + '</span> <br>';

            let minRange = rankedOrdinal.ordinal_component.ordinal_attributes.meter.slice(1)[0];
            let maxRange = rankedOrdinal.ordinal_component.ordinal_attributes.meter.slice(-1)[0];

            ratingString +=    '<input type="range" min="' + minRange + '" max="' + maxRange + '" step="1" value="' + rankedOrdinal.meter + '" disabled>';


            ratingString += '</li>';
        }

        return ratingString;
}