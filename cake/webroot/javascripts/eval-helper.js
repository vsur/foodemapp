$(document).ready(function() {
    // Restart survey
    $("#javatbd612158X2X4AO01 .button-item").click(function(event) {
        let currentUrl = window.location.href;
        let hasParams = false;
        let goToUrl = "";
        if (currentUrl.indexOf("?") > -1) hasParams = true;
        if (hasParams) {
            goToUrl = currentUrl + "&newtest=Y";
        } else {
            goToUrl = currentUrl + "?newtest=Y";
        }
        window.location.href = goToUrl;
    });

    // List
    $("#answer612158X5X16").on('change', function(event) {
        saveQuantityData(event, "list");
    });

    // Chord
    $("#answer612158X16X23").on('change', function(event) {
        saveQuantityData(event, "chord");
    });

    // Map
    $("#answer612158X17X26").on('change', function(event) {
        saveQuantityData(event, "map");
    });

});

function saveQuantityData(event, view) {
    let iFrameContext = document.getElementById('fmAppFrame').contentWindow;
    let mouseData = iFrameContext.fmApp.mouseData;
    console.log(mouseData);
    switch (view) {
        case "list":
            // mMove Data Textarea ID: answer612158X5X93
            $("#answer612158X5X93").val(JSON.stringify(mouseData.mMove.data));
            // mClick Data Textarea ID: answer612158X5X94
            $("#answer612158X5X94").val(JSON.stringify(mouseData.mClick.data));
            // aoi.list.pois Data Textarea ID: answer612158X5X95
            $("#answer612158X5X95").val(JSON.stringify(mouseData.aoi.list.pois));
            break;

        case "chord":
            // mMove Data Textarea ID: answer612158X16X96
            $("#answer612158X16X96").val(JSON.stringify(mouseData.mMove.data));
            // mClick Data Textarea ID: answer612158X16X97
            $("#answer612158X16X97").val(JSON.stringify(mouseData.mClick.data));
            // aoi.chord.pois Data Textarea ID: answer612158X16X98
            $("#answer612158X16X98").val(JSON.stringify(mouseData.aoi.chord.pois));
            // aoi.chord.choosenComponents Data Textarea ID: answer612158X16X99
            $("#answer612158X16X99").val(JSON.stringify(mouseData.aoi.chord.choosenComponents));
            // aoi.chord.otherComponents Data Textarea ID: answer612158X16X100
            $("#answer612158X16X100").val(JSON.stringify(mouseData.aoi.chord.otherComponents));
            break;

        case "map":
            // mMove Data Textarea ID: answer612158X17X101
            $("#answer612158X17X101").val(JSON.stringify(mouseData.mMove.data));
            // mClick Data Textarea ID: answer612158X17X102
            $("#answer612158X17X102").val(JSON.stringify(mouseData.mClick.data));
            // aoi.map.mapComponentsChoice Data Textarea ID: answer612158X17X103
            $("#answer612158X17X103").val(JSON.stringify(mouseData.aoi.map.mapComponentsChoice));
            // aoi.map.pois Data Textarea ID: answer612158X17X104
            $("#answer612158X17X104").val(JSON.stringify(mouseData.aoi.map.pois));
            // aoi.map.dragMap Data Textarea ID: answer612158X17X105
            $("#answer612158X17X105").val(JSON.stringify(mouseData.aoi.map.dragMap));
            // aoi.map.dragPopup Data Textarea ID: answer612158X17X106
            $("#answer612158X17X106").val(JSON.stringify(mouseData.aoi.map.dragPopup));
            // aoi.map.zoomMap Data Textarea ID: answer612158X17X107
            $("#answer612158X17X107").val(JSON.stringify(mouseData.aoi.map.zoomMap));
            break;

        default:
            break;
    }
    console.log("Data pasted");
}
