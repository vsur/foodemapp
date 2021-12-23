/* 
    Heatmap file for evaluation
    Mode: STD 
*/

var heatmap;

$(document).ready(function() {

    // Init Heatmap
    fmApp.heatmap.init();

    // Listener for all mouse movements
    $('.container').mousemove(function(mouseEvent) {
        // mouseEvent.preventDefault();
        let dataPoint = {
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.mMove.data.push(dataPoint);
    });
    // Listener for all mouse clicks
    $('.container').click(function(mouseEvent) {
        let dataPoint = {
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.mClick.data.push(dataPoint);
    });

    $("#heatmapShow-mMove").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mMove();
    });

    $("#heatmapShow-mClick").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mClick();
    });

});