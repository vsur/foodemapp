// Listener for AOI mouse moves
$(document).ready(function () {
    
    $('#mouseTrackListZwiebel').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        console.log("Zwiebel: ", dataPoint);
        fmApp.mouseData.aoi.list.zwiebel.push(dataPoint);
    });
    
    $('#mouseTrackListVapiano').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        console.log("Vapiano: ", dataPoint);
        fmApp.mouseData.aoi.list.vapiano.push(dataPoint);
    });
    
    $('#mouseTrackListOishii').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        console.log("Oishii: ", dataPoint);
        fmApp.mouseData.aoi.list.oishii.push(dataPoint);
    });
    $('#mouseTrackListDiner').click(function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        console.log("Diner: ", dataPoint);
        fmApp.mouseData.aoi.list.diner.push(dataPoint);
    });
    
     $("#dataShow-aoiList").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiList();
    });
});