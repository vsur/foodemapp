/* 
    Heatmap file for evaluation
    Mode: MAP 
*/

var heatmap;

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
    latField: 'x',
    // which field name in your data represents the longitude - default "lng"
    lngField: 'y',
    // which field name in your data represents the data value - default "value"
    valueField: 'value'
};

var heatmapLayer = new HeatmapOverlay(heatmapLayerCfg);

$(document).ready(function() {
    $("#heatmapShow-mMove").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.mMoveMap();
    });

    $("#heatmapShow-mClick").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.mClickMap(); 
    });
});