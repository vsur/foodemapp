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

var mouseLat, mouseLng;

mymap.addEventListener('mousemove', function(e) {
    mouseLat = e.latlng.lat;
    mouseLng = e.latlng.lng;
    let dataPoint = {
        x: mouseLat,
        y: mouseLng,
        value: 1
    };
    fmApp.mouseData.mMove.data.push(dataPoint);
});

$(document).ready(function() {
    $("#ypoisMap").on('click', function(mouseEvent) {
        let dataPoint = {
            x: mouseLat,
            y: mouseLng,
            value: 1
        };
        fmApp.mouseData.mClick.data.push(dataPoint);
    });

    $("#heatmapShow-mMove").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mMoveMap();
    });

    $("#heatmapShow-mClick").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mClickMap();
    });
});