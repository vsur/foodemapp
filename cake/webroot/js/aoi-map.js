// Listener for AOI mouse moves

var zoomType;
var zoomEventType;

$(document).ready(function() {

    $("#mapComponentsChoice a").click(function(mouseEvent) {
        var componentType = $(this).attr('data-component-presentation');
        fmApp.mouseData.aoi.map.mapComponentsChoice.push(addMapComponentsChoiceEvent(componentType, mouseEvent));
        console.log(componentType);
    });

    markers.on('click', function(mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            poi: mouseEvent.sourceTarget.options.poiName,
            x: mouseLat,
            y: mouseLng,
            value: 1
        };
        fmApp.mouseData.aoi.map.pois.push(dataPoint);
    });

    L.DomEvent.on(mymap.getContainer(), 'mousewheel', function(event) {
        zoomEventType = "mouseWheel";
        if (event.deltaY < 0) {
            zoomType = "zoomOut";
        } else if (event.deltaY > 0) {
            zoomType = "zoomIn";
        }
    });

    // TODO ZOOM Type ETC Set By Controls +/-

    // TODO ZOOM Type ETC Set By Double Click

    mymap.on('zoomend', function(event) {
        console.log("zoomEventType", zoomEventType);
        console.log("zoomType", zoomType);

        // TODO ADD To Track Array

        zoomType = undefined;
        zoomEventType = undefined;
    });

    // $('.leaflet-marker-icon').click(function(mouseEvent) {
    //     let dataPoint = {
    //         time: Date.now(),
    //         poi: $(this).children("div").children("span").html(),
    //         // x: mouseEvent.pageX,
    //         // y: mouseEvent.pageY,
    //         value: 1
    //     };
    //     fmApp.mouseData.aoi.map.pois.push(dataPoint);

    // });
    // $('#mouseTrackListZwiebel').click(function (mouseEvent) {
    //     let dataPoint = {
    //         time: Date.now(),
    //         x: mouseEvent.pageX,
    //         y: mouseEvent.pageY,
    //         value: 1
    //     };
    //     console.log("Zwiebel: ", dataPoint);
    //     fmApp.mouseData.aoi.list.zwiebel.push(dataPoint);
    // });

    // $('#mouseTrackListVapiano').click(function (mouseEvent) {
    //     let dataPoint = {
    //         time: Date.now(),
    //         x: mouseEvent.pageX,
    //         y: mouseEvent.pageY,
    //         value: 1
    //     };
    //     console.log("Vapiano: ", dataPoint);
    //     fmApp.mouseData.aoi.list.vapiano.push(dataPoint);
    // });

    // $('#mouseTrackListOishii').click(function (mouseEvent) {
    //     let dataPoint = {
    //         time: Date.now(),
    //         x: mouseEvent.pageX,
    //         y: mouseEvent.pageY,
    //         value: 1
    //     };
    //     console.log("Oishii: ", dataPoint);
    //     fmApp.mouseData.aoi.list.oishii.push(dataPoint);
    // });
    // $('#mouseTrackListDiner').click(function (mouseEvent) {
    //     let dataPoint = {
    //         time: Date.now(),
    //         x: mouseEvent.pageX,
    //         y: mouseEvent.pageY,
    //         value: 1
    //     };
    //     console.log("Diner: ", dataPoint);
    //     fmApp.mouseData.aoi.list.diner.push(dataPoint);
    // });

    $("#dataShow-aoiMap").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.debugShow.aoiMap();
    });
});

function addMapComponentsChoiceEvent(componentType, mouseEvent)  {
    let dataPoint = {
        time: Date.now(),
        componentType: componentType,
        x: mouseEvent.pageX,
        y: mouseEvent.pageY,
        value: 1
    };
    return dataPoint;
}