// Listener for AOI mouse moves
$(document).ready(function () {
    
    $('#mouseTrackListZwiebel').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            poi: "Zwiebel",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.list.zwiebel.push(dataPoint);
    });
    
    $('#mouseTrackListVapiano').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            poi: "Vapiano",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.list.vapiano.push(dataPoint);
    });
    
    $('#mouseTrackListOishii').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            poi: "Oishii",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.list.oishii.push(dataPoint);
    });
    $('#mouseTrackListDiner').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            poi: "American Diner Durlach",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.list.diner.push(dataPoint);
    });
    
     $("#dataShow-aoiList").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiList();
    });
});