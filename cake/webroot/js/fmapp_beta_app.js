/*
 * This is fmapp beta data script
 */

var fmApp = {
    init: function(params) {
        // … do something
    },
    standardRating: 3, // Out of 3
    componentModelTypePrefix: '_C-MODEL_',
    componentIdPrefix: '_C-ID_',
    nominalAttributeIdPrefix: '_NCATTR-ID_',
    ordinnalAttributeIdPrefix: '_OCATTR-ID_',
    combinedCriteriaArrayIndex: '_ALLC-ID_',
    currentComponent: "",
    chosenSelection: [],
    callTest: function() {
        console.log("I got called");
    },
    checkInput: function() {
        var inputValue = $("#criteriaInput").val();
        if (inputValue !== "") {
            this.addComponent();
        } else {
            this.showInputError();
        }

    },
    showInputError: function() {
        $("#criteriaInput").attr('placeholder', 'Kategorie wählen!').toggleClass("noChoice");
        setTimeout(function() {
            $("#criteriaInput").toggleClass("noChoice");
        }, 2000);
    },
    addComponent: function() {
        var inputValue = $("#criteriaInput").val();
        var chosenComponent;
        var selectedCriterion = {
            type: inputValue.slice(0, 2),
            // Slice ID between prefixes out of string
            id: inputValue.slice( inputValue.indexOf(this.componentIdPrefix) + this.componentIdPrefix.length,  inputValue.indexOf(this.combinedCriteriaArrayIndex) ) ,
            // Slice Index position in Array after last prefix out of string
            index: inputValue.slice( inputValue.indexOf(this.combinedCriteriaArrayIndex) + this.combinedCriteriaArrayIndex.length )
        };
        if (this.checkDataMatching(selectedCriterion)) {
            chosenComponent = criteria[selectedCriterion.index];
        } else {
            this.alertMessage("Fehler bei der Datenzuordnung Ihrer Auswahl", "alert-danger");
            console.log("Matching-Error \nAuswahl: " + criterionNames[selectedCriterion.index][0] + "\n" + "Zuordnung: " + criteria[selectedCriterion.index].display_name + "\nAus Input kommend: " + inputValue + "\n" + "Index: " + selectedCriterion.index + "\n" + "Typ: " + selectedCriterion.type + "\n" + "Model-ID: " + selectedCriterion.id);
        }
        // Reset input-fied
        $("#criteriaInput").val("").attr('placeholder', '').toggleClass("chosen");
        setTimeout(function() {
            $("#criteriaInput").attr('placeholder', 'Weitere wählen').toggleClass("chosen");
        }, 2000);
        // Add Component to selection
        this.chosenSelection.push({
            'componentName': chosenComponent.display_name,
            'componentType': chosenComponent.modelType,
            'componentId': chosenComponent.id,
            'rating': this.standardRating,
            'binaryState': true,
            'nominalAttribute': null,
            'ordinalAttribute': null
        });
        // Prepend choosen component
        this.currentComponent = '<p id="criteriaList' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '">' + chosenComponent.display_name + ' <a title="Diese Kategorie löschen" class="throwComponent"><span class="glyphicon glyphicon-minus-sign text-danger" aria-hidden="true"></span></a></p>';
        $("#criteriaChoice").append(this.currentComponent);
        $(".throwComponent").click(function() {
            var componentToDelete = $(this).parent().attr("id");
            $(this).parent().remove();
            fmApp.deleteComponent(componentToDelete);
        });
        var labelRow = "";
        if (this.chosenSelection.length <= 1) {
            // Add labels to areas

            labelRow += '<div class="row hidden-sm hidden-xs">';
            labelRow += '<div class="col-md-6">';
            labelRow += '<label class="text-info">Kategorien einstellen</label>';
            labelRow += '</div>';
            labelRow += '<div class="col-md-6">';
            labelRow += '<label class="text-info">Gewichtung einstellen</label>';
            labelRow += '</div>';
            labelRow += '</div>';
        }

        var chosenComponentToPaste = "";
        chosenComponentToPaste += '<div id="criteriaOptions' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="row">';
        chosenComponentToPaste += '<div class="col-md-6">';
        chosenComponentToPaste += '<p class="componentNameHeader">' + chosenComponent.display_name + '</p>';
        if(chosenComponent.modelType == 'BinaryComponents') {
            chosenComponentToPaste += this.pasteBinarySwitch(chosenComponent);
        }
        if(chosenComponent.modelType == 'NominalComponents') {
            chosenComponentToPaste += this.pasteNominalAttributes(chosenComponent);
        }
        if(chosenComponent.modelType == 'OrdinalComponents') {
            chosenComponentToPaste += this.pasteOrdinalAttributes(chosenComponent);
        }
        /*
         * ✓ Binary selection
         * ✓ Dann Paste Nominal selection
         * Dann Ordinal Selection
         */

        chosenComponentToPaste += '</div>';

        var chosenComponentToPasteRating = "";
        chosenComponentToPasteRating += '<div class="col-md-6">';
        chosenComponentToPasteRating += this.buildRatingRadio(chosenComponent.modelType, chosenComponent.id);
        chosenComponentToPasteRating += '</div>';
        chosenComponentToPasteRating += '</div>';

        $("#criteriaOutput").append(labelRow + chosenComponentToPaste + chosenComponentToPasteRating);
        this.setCurrent_ordinalAttributeChoice_String(chosenComponent.modelType, chosenComponent.id);
    },
    checkDataMatching: function(criterionToCheck) {
        var machtingCorrect = true;
        // Check names
        if (criterionNames[criterionToCheck.index][0].search(criteria[criterionToCheck.index].display_name) < 0) {
            machtingCorrect = false;
        }
        // Check types
        var typeToCheck = "";
        switch (criterionToCheck.type) {
            case 'BC':
                typeToCheck = "BinaryComponents";
                break;

            case 'NC':
                typeToCheck = "NominalComponents";
                break;

            case 'OC':
                typeToCheck = "OrdinalComponents";
                break;
        }
        if (typeToCheck != criteria[criterionToCheck.index].modelType) {
            machtingCorrect = false;
        }
        // Check ids
        if (criterionToCheck.id != criteria[criterionToCheck.index].id) {
            machtingCorrect = false;
        }
        return machtingCorrect;
    },
    pasteBinarySwitch: function(chosenComponent) {
        var switchString = '';
        switchString += '<p>';
        switchString += '<span class="componentNameBinarySlider">' + chosenComponent.display_name + '</span>';
        // Switch an simple HTML checkbox: https://www.w3schools.com/howto/howto_css_switch.asp
        switchString += '<label class="switch">';
        switchString +=     '<input type="checkbox" checked>';
        switchString +=     '<span class="slider round"></span>';
        switchString += '</label>';
        switchString += '</p>';
        return switchString;
    },
    pasteNominalAttributes: function(chosenComponent) {
        var nominalAttributes = '';
        // Differentiate cols for Attributes based on amount
        if(chosenComponent.nominal_attributes.length % 3 == 0) {
            nominalAttributes += '<div id="criteriaAttributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="nominalAttributesContainer triple">';
        } else {
            nominalAttributes += '<div id="criteriaAttributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="nominalAttributesContainer fourfold">';
        }
        chosenComponent.nominal_attributes.forEach(function(nominalAttribute, index) {
            nominalAttributes += fmApp.buildSingleNominalAttribute(nominalAttribute, chosenComponent);
        });
        nominalAttributes += '</div>';

        return nominalAttributes;
    },
    pasteOrdinalAttributes: function(chosenComponent) {
        var meterMin = chosenComponent.ordinal_attributes.slice()[0].meter;
        var meterMax = chosenComponent.ordinal_attributes.slice(-1)[0].meter;
        var rangeSteps = meterMax / chosenComponent.ordinal_attributes.length;
        var ordinalAttributes = '';
        ordinalAttributes += '<div id="criteriaAttributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="ordinalAttributesContainer">';
        ordinalAttributes += '<p class="ordinalAttributeChoice text-primary">Dynamisch Setzen</p>';
        ordinalAttributes += '<input type="range" min="1" max="5" step="1" list="attributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id +  '">';
        ordinalAttributes += '<datalist id="attributesDataList' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id +  '">';
        chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
            ordinalAttributes += '<option id="ordinalAttribute' + this.ordinnalAttributeIdPrefix + ordinalAttribute.id + '" value="' + ordinalAttribute.meter + '">';
        });
        ordinalAttributes += '</datalist>';
        ordinalAttributes += '<table id="attributesList' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id +  '" class="table table-hover">';
        ordinalAttributes += '<tr>';
        ordinalAttributes += '<th>#</th>';
        ordinalAttributes += '<th>Label</th>';
        ordinalAttributes += '</tr>';
        chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
            ordinalAttributes +=    '<tr>';
            ordinalAttributes +=    '<td>' +  ordinalAttribute.meter  + '</td>';
            ordinalAttributes +=    '<td>' +  ordinalAttribute.display_name  + '</td>';
            ordinalAttributes +=    '</tr>';
        });
        ordinalAttributes += '</table>';
        ordinalAttributes += '</div>';
        return ordinalAttributes;
    },
    buildSingleNominalAttribute: function(nominalAttribute, chosenComponent) {
        var nominalAttributeToPaste = '';
        nominalAttributeToPaste += '<div class="nominalAttribute">';
        nominalAttributeToPaste +=      '<input type="radio" id="nominalAttribute' + this.nominalAttributeIdPrefix + nominalAttribute.id + '" name="attribues' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" value="' + nominalAttribute.id + '" />';
        nominalAttributeToPaste +=      '<label for="nominalAttribute' + this.nominalAttributeIdPrefix + nominalAttribute.id + '" title="text">';
        nominalAttributeToPaste +=          '<figure class="attrIcons ' + nominalAttribute.icon_path + '"></figure>';
        nominalAttributeToPaste +=          '<figcaption>' + nominalAttribute.display_name + '</figcaption>';
        nominalAttributeToPaste +=      '</label>';
        nominalAttributeToPaste += '</div>';

        return nominalAttributeToPaste;
    },
    setCurrent_ordinalAttributeChoice_String: function(modelType, id) {
        console.log("Kommt an");
        var cssSelector = '#criteriaAttributes' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id;
        console.log("selektor: " + cssSelector);
        console.log($("#criteriaOptions_C-MODEL_OrdinalComponents_C-ID_2"));
    },
    findIndexOfChosenComponent: function(modelType, id) {
        var foundIndex = null;
        this.chosenSelection.forEach(function(component, index) {
            // Check if type machtes
            if (component.componentType == modelType) {
                // Check if ID matches
                if (component.componentId == id)  {
                    foundIndex = index;
                }
            }
        });
        return foundIndex;
    },
    deleteComponent: function(delName) {
        $("#" + delName).remove();
        $("#" + delName + "Gauge").remove();
        var i = this.chosenSelection.indexOf(delName);
        this.chosenSelection.splice(i, 1);
        console.log("Eintrag aus Array gelöscht");
        console.log("Noch Einträge:  " + this.chosenSelection.length);
        console.log(this.chosenSelection);

    },
    getRating: function(modelType, id) {
        var selectionIndex;
        for (var i = 0; i < this.chosenSelection.length; i++) {
            if (this.chosenSelection[i].componentType == modelType && this.chosenSelection[i].componentId == id) {
                selectionIndex = i;
            } else {
                selectionIndex = undefined;
            }
        }
        var rating = this.chosenSelection[selectionIndex].rating;
        return rating;
    },
    setRating: function(indexOfChosenSelection, newRating) {
        var componentToSetRating = this.chosenSelection[indexOfChosenSelection];
        componentToSetRating.rating = newRating;
        // debug
        this.chosenSelection.forEach(function(component, index) {
            console.log(component.componentName + ': ' + component.rating);
        });
    },
    buildRatingRadio: function(modelType, id) {
        var ratingRadio;
        ratingRadioStart = '<div class="rate">';
        radiostar5 = '<input type="radio" id="star5#' + modelType + '.' + id + '" name="rate#' + modelType + '.' + id + '" value="5" ' + (this.getRating(modelType, id) == 5 ? 'checked' : '') + '/><label for="star5#' + modelType + '.' + id + '" title="text">5 stars</label>';
        radiostar4 = '<input type="radio" id="star4#' + modelType + '.' + id + '" name="rate#' + modelType + '.' + id + '" value="4" ' + (this.getRating(modelType, id) == 4 ? 'checked' : '') + '/><label for="star4#' + modelType + '.' + id + '" title="text">4 stars</label>';
        radiostar3 = '<input type="radio" id="star3#' + modelType + '.' + id + '" name="rate#' + modelType + '.' + id + '" value="3" ' + (this.getRating(modelType, id) == 3 ? 'checked' : '') + '/><label for="star3#' + modelType + '.' + id + '" title="text">3 stars</label>';
        radiostar2 = '<input type="radio" id="star2#' + modelType + '.' + id + '" name="rate#' + modelType + '.' + id + '" value="2" ' + (this.getRating(modelType, id) == 2 ? 'checked' : '') + '/><label for="star2#' + modelType + '.' + id + '" title="text">2 stars</label>';
        radiostar1 = '<input type="radio" id="star1#' + modelType + '.' + id + '" name="rate#' + modelType + '.' + id + '" value="1" ' + (this.getRating(modelType, id) == 1 ? 'checked' : '') + '/><label for="star1#' + modelType + '.' + id + '" title="text">1 star</label>';
        ratingRadioEnd = '</div>';
        ratingRadio = ratingRadioStart + radiostar5 + radiostar4 + radiostar3 + radiostar2 + radiostar1 + ratingRadioEnd;
        return ratingRadio;
    },
    updateGauge: function(clickedGauge) {
        var j;
        for (var i = 0; i < this.chosenSelection.length; i++) {
            j = this.chosenSelection[i].componentName == clickedGauge ? i : undefined;
        }
        var gaugeObj = this.chosenSelection[j];
        gaugeObj.gauge.update(50);
    },
    comparePois: function() {
        var paramString = "?";
        for (var i = 0; i < this.chosenSelection.length; i++) {
            paramString += this.chosenSelection[i].componentName + "=" + this.chosenSelection[i].weight;
            paramString += i < (this.chosenSelection.length - 1) ? "&" : "";
        }
        window.location = '../pois/matchesPie/' + paramString;
    },
    /*
     * There are three different alert state by Bootstrap
     * sucess | info | warning | danger
     */
    alertMessage: function(alertText, alertState) {
        if (alertState === undefined) {
            alertState = "alert-info";
        }
        // Clean alertState from former message
        if (alertText === undefined) {
            alertText = "Vorsicht!";
        }
        var alertBoxString =
            '<div id="alertBox" class="alert ' + alertState + ' alert-dismissible" role="alert">\n\t' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\t' +
            '<span id="alertBoxText">' + alertText + '</span>\n\t' +
            '</div>';
        $("#criteriaOutput").prepend(alertBoxString);
        $("#alertBox").fadeIn("fast").delay(5000).fadeOut("slow");
    }
};

$(document).ready(function() {
    // Function for selection
    window.addEventListener("awesomplete-select", function(e) {
        // User types something and a select is made.
        // Therefor action button shall apear,
        $("#chooseAction").slideDown("fast");
    }, false);
    // Function for adding a component
    window.addEventListener("awesomplete-selectcomplete", function(e) {
        // User made a selection from dropdown.
        // This is fired after the selection is applied
        fmApp.addComponent();
    }, false);
    // Handler for compare button
    $("#showAction").click(function() {
        fmApp.comparePois();
    });
    $("#showBars").click(function() {
        window.location = '../matchesBar/' + window.location.search;
    });

    $(".addFromList").click(function() {
        // alert( $(this).attr("name") );
        $("#criteriaInput").val($(this).attr("name"));
        fmApp.addComponent();
    });

    var listDisplayState = true;
    // Cosy Show Criteria
    $("#showAllCriteria").css("cursor", "pointer").click(function() {
        $("#criteriaListView").fadeToggle(1500, function() {
            $("#compnentListDisplayState").fadeOut(500, function() {
                if (listDisplayState) {
                    $(this).text("ausblenden ↑").fadeIn(500);
                } else {
                    $(this).text("einblenden ↓").fadeIn(500);
                }
                listDisplayState = !listDisplayState;
            });
        });
    });

    $("#criteriaOutput").on("click", ".rate>input", function() {
        // Get component string of clicked rating element
        var componentIdentifierName = $(this).attr("name");
        // Extract ModelType of component
        var componentModelType = componentIdentifierName.slice(componentIdentifierName.indexOf("#") + 1, componentIdentifierName.indexOf("."));
        // Ectract Id of component
        var componentId = componentIdentifierName.slice(componentIdentifierName.indexOf(".") + 1);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.findIndexOfChosenComponent(componentModelType, componentId);
        // Actual clicked Rating
        var recentRating = $(this).val();
        // Set Rating
        fmApp.setRating(indexInSelection, recentRating);
    });
});
