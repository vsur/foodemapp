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
            // mClicl Data Textarea ID: answer612158X5X94
            $("#answer612158X5X94").val(JSON.stringify(mouseData.mClick.data));
            // aoi.list.pois Data Textarea ID: answer612158X5X93
            $("#answer612158X5X95").val(JSON.stringify(mouseData.aoi.list.pois));
            break;

        default:
            break;
    }
    console.log("Data pasted");
}