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
        saveQuantityData(event);
    });

    // Chord
    $("#answer612158X16X23").on('change', function(event) {
        saveQuantityData(event);
    });

    // Map
    $("#answer612158X17X26").on('change', function(event) {
        saveQuantityData(event);
    });

});

function saveQuantityData(event) {
    let iFrameContext = document.getElementById('fmAppFrame').contentWindow;
    console.log(iFrameContext.fmApp.mouseData);
}