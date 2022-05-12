/* 
    Heatmap file for evaluation
    Mode: STD 
*/

var heatmap;

$(document).ready(function() {

    $("#heatmapShow-mMove").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.mMove(displayVariant);
    });

    $("#heatmapShow-mClick").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.mClick(displayVariant);
    });

});