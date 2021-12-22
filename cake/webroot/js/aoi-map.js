// Listener for AOI mouse moves

var zoomType = "zoomIn";
var zoomEventType = "startZoom";

$(document).ready(function() {

    $("#mapComponentsChoice a").click(function(mouseEvent) {
        var componentType = $(this).attr('data-component-presentation');
        fmApp.mouseData.aoi.map.mapComponentsChoice.push(addMapComponentsChoiceEvent(componentType, mouseEvent));
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

    $(".leaflet-control-zoom-in").click(function(mouseEvent) {
        zoomEventType = "mapControl";
        zoomType = "zoomIn";
    });

    $(".leaflet-control-zoom-out").click(function(mouseEvent) {
        zoomEventType = "mapControl";
        zoomType = "zoomOut";
    });

    mymap.on('zoomend', function(mouseEvent) {
        let dataPoint = {
            time: Date.now(),
            event: zoomEventType,
            zoom: zoomType,
            x: mouseLat,
            y: mouseLng,
            value: 1
        };
        fmApp.mouseData.aoi.map.zoomMap.push(dataPoint);
        zoomType = undefined;
        zoomEventType = undefined;
    });

    mymap.on('movestart', function(mouseEvent) {
        fmApp.mouseData.aoi.map.dragMap.push(addMapMoveEvent(mouseEvent));
    });
    mymap.on('moveend', function(mouseEvent) {
        fmApp.mouseData.aoi.map.dragMap.push(addMapMoveEvent(mouseEvent));
    });

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

function addMapMoveEvent(mouseEvent) {
    let dataPoint = {
        time: Date.now(),
        event: mouseEvent.type,
        x: mymap.getCenter().lat,
        y: mymap.getCenter().lng,
        value: 1
    };
    return dataPoint;
}


function aoiMapTrackPopupDragEvent(mouseEvent, popupSourceName) {
    let eventLatLng = mymap.layerPointToLatLng(L.point(mouseEvent.sourceTarget._startPoint.x, mouseEvent.sourceTarget._startPoint.y));
    let dataPoint = {
        time: Date.now(),
        event: mouseEvent.type,
        poi: popupSourceName,
        distance: mouseEvent.distance ? mouseEvent.distance : undefined,
        x: eventLatLng.lat,
        y: eventLatLng.lng,
        value: 1
    };
    fmApp.mouseData.aoi.map.dragPopup.push(dataPoint);
}