/* 
    Heatmap file for evaluation
    Mode: MAP 
*/

var heatmap;


var testData = {
    max: 8,
    data: [{
        lat: 49.11, 
        lng: 8.40706,
        count: 1
    }, {
        lat: 49.21, 
        lng: 8.40806,
        count: 2
    }, {
        lat: 49.013, 
        lng: 8.40706,
        count: 3
    }, {
        lat: 49.015, 
        lng: 8.40856,
        count: 4
    }, {
        lat: 49.025, 
        lng: 8.40676,
        count: 5
    }, {
        lat: 49.011, 
        lng: 8.4045,
        count: 6
    }, {
        lat: 49.0195, 
        lng: 8.40808,
        count: 7
    }, {
        lat: 49.011, 
        lng: 8.40809,
        count: 8
    }]
};

var heatmapLayerCfg = {
    // radius should be small ONLY if scaleRadius is true (or small radius is intended)
    // if scaleRadius is false it will be the constant radius used in pixels
    "radius": 25,
    "maxOpacity": 0.8,
    // scales the radius based on map zoom
    "scaleRadius": false,
    // if set to false the heatmap uses the global maximum for colorization
    // if activated: uses the data maximum within the current map boundaries
    //   (there will always be a red spot with useLocalExtremas true)
    "useLocalExtrema": false,
    // which field name in your data represents the latitude - default "lat"
    latField: 'lat',
    // which field name in your data represents the longitude - default "lng"
    lngField: 'lng',
    // which field name in your data represents the data value - default "value"
    valueField: 'count'
};

var heatmapLayer = new HeatmapOverlay(heatmapLayerCfg);

$(document).ready(function () {
    mymap.addLayer(heatmapLayer);
    setTimeout(function () {
        heatmapLayer.setData(testData);
    }, 3000);
});
