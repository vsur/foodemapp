$(document).ready(function() {
    $("#dataShow-aoiMap").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.aoiMap();
    });
});

function aoiMapTrackPopupDragEvent(mouseEvent, popupSourceName) {
    // Event name needed function only required in real View
}
