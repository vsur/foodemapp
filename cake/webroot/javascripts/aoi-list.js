// Listener for AOI mouse moves
$(document).ready(function () {
    
    $('.mouseTrackList').click(function (mouseEvent) {
        let poiName = $(this).attr("data-name");
        let dataPoint = {
            time: Date.now(),
            poi: poiName,
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.list.pois.push(dataPoint);
    });
    
     $("#dataShow-aoiList").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiList();
    });
});