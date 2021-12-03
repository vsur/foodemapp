/* 
    Heatmap file for evaluation
    Mode: STD 
*/

var heatmap;

$(document).ready(function () {

    // Init Heatmap
    fmApp.heatmap.init();

    // Listener for all mouse movements
    $('.container').mousemove(function (mouseEvent) {
        // mouseEvent.preventDefault();
        let dataPoint = {
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.mMove.data.push(dataPoint);
    });
    // Listener for all mouse clicks
    $('.container').click(function (mouseEvent) {
        let dataPoint = {
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.mClick.data.push(dataPoint);
    });
    // Listener for AOI mouse moves
    $('.aoi-move').each(function (index) {
        $(this).mousemove(function (mouseEvent) {
            // mouseEvent.preventDefault();

            let elemToCenter = fmApp.heatmap.getCenteredCoordinates($(this).get(0));
            // console.log(item);
            let dataPoint = {
                x: elemToCenter.centerX,
                y: elemToCenter.centerY,
                value: 1
            };
            fmApp.mouseData.aoiMove.data.push(dataPoint);
            console.log(dataPoint);
        });
    });

    // Listener for AOI mouse clicks
    $('.aoi-click').each(function (index) {
        $(this).click(function (mouseEvent) {
            // mouseEvent.preventDefault();

            let elemToCenter = fmApp.heatmap.getCenteredCoordinates($(this).get(0), "click");

            let dataPoint = {
                x: elemToCenter.centerX,
                y: elemToCenter.centerY,
                value: 1
            };
            fmApp.mouseData.aoiClick.data.push(dataPoint);
        });
    });

    $("#heatmapBar").hover(function (mouseEvent) {
        $(this).toggleClass("showHeatmapBar");
    });

    /*****************************
     * // DEBUG SHOW FOR HEATMAP *
     *****************************/
    $("#heatmapShow-mMove").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mMove();
    });

    $("#heatmapShow-mClick").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.mClick();
    });

    $("#heatmapShow-aoiMove").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiMove();
    });

    $("#heatmapShow-aoiClick").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiClick();
    });

});
