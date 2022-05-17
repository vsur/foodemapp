$(document).ready(function() {
    $("#dataShow-aoiMap").click(function(mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.aoiMap();
    });
});
