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
    /*
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
    */
    // Submit Button
    $("#ls-button-submit").on('click', function(event) {
        // Check Group-ID and set view var 
        // list || chord || map
        let view = "";
        let listGroupID = document.getElementById("taskTypeList");
        let chordGroupID = document.getElementById("taskTypeChord");
        let mapGroupID = document.getElementById("taskTypeMap");
        if(listGroupID) {
            view = "list";
        }
        if(chordGroupID) {
            view = "chord";
        }
        if(mapGroupID) {
            view = "map";
        }
        console.log("View detected: ", listGroupID);
        if (validateAnswers(event, view)) {
            if (saveQuantityData(event, view)) {
                console.log("Form Should Submit");
            } else {
                alert("Fehler bei der Datenübernahme. Bitte probieren Sie es erneut.");
            }
        } else {
            event.preventDefault();
            console.log("Form could not been sent, cause of missing answers.");
        }
    });

});

var errorText = `<div class="ls-question-mandatory ls-question-mandatory-initial text-danger " role="alert">
    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
    Diese Frage muss beantwortet werden.
</div>`;

function saveQuantityData(event, view) {
    let iFrameContext = document.getElementById('fmAppFrame').contentWindow;
    let mouseData = iFrameContext.fmApp.mouseData;
    let pasteAccomplished = false;
    switch (view) {
        case "list":
            // mMove Data Textarea ID: answer612158X5X93
            $("#answer612158X5X93").val(JSON.stringify(mouseData.mMove.data));
            // mClick Data Textarea ID: answer612158X5X94
            $("#answer612158X5X94").val(JSON.stringify(mouseData.mClick.data));
            // aoi.list.pois Data Textarea ID: answer612158X5X95
            $("#answer612158X5X95").val(JSON.stringify(mouseData.aoi.list.pois));
            pasteAccomplished = true;
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
            pasteAccomplished = true;
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
            pasteAccomplished = true;
            break;

        default:
            break;
    }
    console.log("Data pasted");
    return pasteAccomplished;
}

function validateAnswers(event, view)  {
    let validation = {
        dropDown: false,
        decisionEasiness: false,
        decisionAccuracy: false
    };
    switch (view) {
        case "list":
            validation.dropDown = checkDropDownInput("list");
            validation.decisionEasiness = checkDecisionEasiness("list");
            validation.decisionAccuracy = checkDecisionAccuracy("list");
            if (
                validation.dropDown &&
                validation.decisionEasiness &&
                validation.decisionAccuracy
            ) {
                return true;
            } else {
                console.log("Answer validation failed!");
                return false;
            }
            break;

        case "chord":
            return true;
            // break;

        case "map":
            return true;
            // break;

        default:
            return false;
            // break;
    }
}

function checkDropDownInput(view) {
    let dropDownId = "";
    let questionID = "";
    switch (view) {
        case "list":
            dropDownId = "answer612158X5X16";
            questionID = "question16";
            break;

        case "chord":
            break;

        case "map":
            break;

        default:
            break;
    }

    let selectedDropDownOption = $('#' + dropDownId + ' option:selected').val();
    if (selectedDropDownOption == "") {
        if (!$("#" + questionID).hasClass("input-error")) {
            // Highlight Box
            $("#" + questionID).addClass("input-error");
            // Add Error Text
            $("#" + questionID + " > div.question-valid-container.text-info.col-xs-12").append(errorText);
        }
        return false;
    } else {
        return true;
    }
}

function checkDecisionEasiness(view) {
    let radioId = "";
    let questionID = "";
    switch (view) {
        case "list":
            radioId = "612158X5X17";
            questionID = "question17";
            break;

        case "chord":
            break;

        case "map":
            break;

        default:
            break;
    }

    let selectedRadioOption = $("input[type='radio'][name='" + radioId + "']:checked").val();
    if (selectedRadioOption == undefined) {
        if (!$("#" + questionID).hasClass("input-error")) {
            // Highlight Box
            $("#" + questionID).addClass("input-error");
            // Add Error Text
            $("#" + questionID + " > div.question-valid-container.text-info.col-xs-12").append(errorText);
        }
        return false;
    } else {
        return true;
    }
}

function checkDecisionAccuracy(view) {
    let radioId = "";
    let questionID = "";
    switch (view) {
        case "list":
            radioId = "612158X5X18";
            questionID = "question18";
            break;

        case "chord":
            break;

        case "map":
            break;

        default:
            break;
    }

    let selectedRadioOption = $("input[type='radio'][name='" + radioId + "']:checked").val();
    if (selectedRadioOption == undefined) {
        if (!$("#" + questionID).hasClass("input-error")) {
            // Highlight Box
            $("#" + questionID).addClass("input-error");
            // Add Error Text
            $("#" + questionID + " > div.question-valid-container.text-info.col-xs-12").append(errorText);
        }
        return false;
    } else {
        return true;
    }
}
