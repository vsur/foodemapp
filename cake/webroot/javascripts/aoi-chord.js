// Listener for AOI mouse moves
$(document).ready(function () {
    
    $('.aoi-poi').on('mouseover', function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            name: $(this).attr("data-name"),
            arc: "poi",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.chord.pois.push(dataPoint);
    });

    $('.aoi-choosenComponent').on('mouseover', function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            name: $(this).attr("data-name"),
            arc: "choosenComponent",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.chord.choosenComponents.push(dataPoint);
    });

    $('.aoi-otherComponent').on('mouseover', function (mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            name: $(this).attr("data-name"),
            arc: "otherComponent",
            x: mouseEvent.pageX,
            y: mouseEvent.pageY,
            value: 1
        };
        fmApp.mouseData.aoi.chord.otherComponents.push(dataPoint);
    });
    
     $("#dataShow-aoiChord").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiChord();
    });
});