// Listener for AOI mouse moves
$(document).ready(function () {
     $("#dataShow-aoiChord").click(function (mouseEvent) {
        mouseEvent.preventDefault();
        fmApp.heatmap.analyzeShow.aoiChord();
        console.log("JA richtig!");
    });
});