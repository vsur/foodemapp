// Listener for AOI mouse moves
$(document).ready(function () {
     $("#dataShow-aoiList").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.aoiList();
    });
});