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
    binaryStatePrefix: '_BC-STATE_',
    nominalAttributeIdPrefix: '_NCATTR-ID_',
    ordinalAttributeIdPrefix: '_OCATTR-ID_',
    combinedCriteriaArrayIndex: '_ALLC-ID_',
    currentComponent: "",
    chosenSelection: [],
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
    addComponent: function(componentDataFromURL) {
        var chosenComponent;
        var selectedCriterion;
        var inputValue;
        var bcState = null;
        var ncAttrId = null;
        var ocAttrId = null;
        if (componentDataFromURL) {
            inputValue = Object.keys(componentDataFromURL)[0];
            selectedCriterion = this.setCriterionByURLData(inputValue);
            bcState = null; // <= To Set for Dynamic Gui
            ncAttrId = null;
            ocAttrId = null;
        } else {
            inputValue = $("#criteriaInput").val();
            selectedCriterion = this.setCriterionByInputChoice(inputValue);
        }
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
            'binaryState': bcState,
            'nominalAttributeId': null,
            'ordinalAttributeId': null
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
        if (chosenComponent.modelType == 'BinaryComponents') {
            chosenComponentToPaste += this.pasteBinarySwitch(chosenComponent);
            this.setBinaryChoice(this.findIndexOfChosenComponent(chosenComponent.modelType, chosenComponent.id), true);
        }
        if (chosenComponent.modelType == 'NominalComponents') {
            chosenComponentToPaste += this.pasteNominalAttributes(chosenComponent);
        }
        if (chosenComponent.modelType == 'OrdinalComponents') {
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

        // Set ordinal attribute choice string initialy
        if (chosenComponent.modelType == 'OrdinalComponents') {
            this.setCurrent_ordinalAttributeChoice_String(chosenComponent.modelType, chosenComponent.id);
        }
    },
    setCriterionByURLData: function(inputValue) {
        var componentModelIdentifier = inputValue.slice(0, 2);
        var componentModelType = "";
        switch (componentModelIdentifier) {
            case 'BC':
                componentModelType = "BinaryComponents";
                break;

            case 'NC':
                componentModelType = "NominalComponents";
                break;

            case 'OC':
                componentModelType = "OrdinalComponents";
                break;
        }
        var componentId = this.sliceComponentIdOffString(inputValue);
        selectedCriterion = {
            type: componentModelIdentifier,
            // Get ID between prefixes out of string
            id: componentId,
            // Get Index position in array after last prefix out of string
            index: this.findIndexOfComponentInCriteria(componentModelType, componentId)
        };
        return selectedCriterion;
    },
    setCriterionByInputChoice: function(inputValue) {
        selectedCriterion = {
            type: inputValue.slice(0, 2),
            // Get ID between prefixes out of string
            id: this.sliceComponentIdOffString(inputValue),
            // Get Index position in array after last prefix out of string
            index: this.sliceCombinedCriteriaArrayIndexOffString(inputValue)
        };
        return selectedCriterion;
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
        switchString += '<p class="binaryComponentContainer">';
        switchString += '<span class="componentNameBinarySlider">' + chosenComponent.display_name + '</span>';
        // Switch an simple HTML checkbox: https://www.w3schools.com/howto/howto_css_switch.asp
        switchString += '<label class="switch">';
        switchString += '<input type="checkbox" checked>';
        switchString += '<span class="slider round"></span>';
        switchString += '</label>';
        switchString += '</p>';
        return switchString;
    },
    pasteNominalAttributes: function(chosenComponent) {
        var nominalAttributes = '';
        // Differentiate cols for Attributes based on amount
        if (chosenComponent.nominal_attributes.length % 3 == 0) {
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
    setBinaryChoice: function(indexOfChosenSelection, newBinaryState) {
        var componentToSetBinaryChoice = this.chosenSelection[indexOfChosenSelection];
        componentToSetBinaryChoice.binaryState = newBinaryState;
    },
    setNominalChoice: function(indexOfChosenSelection, newNominalAttributeId) {
        var componentToSetNominalAttributeChoice = this.chosenSelection[indexOfChosenSelection];
        componentToSetNominalAttributeChoice.nominalAttributeId = newNominalAttributeId;
    },
    setOrdinalChoice: function(indexOfChosenSelection, newOrdinalAttributeId) {
        var componentToSetOrdinalAttributeChoice = this.chosenSelection[indexOfChosenSelection];
        componentToSetOrdinalAttributeChoice.ordinalAttributeId = newOrdinalAttributeId;
    },
    pasteOrdinalAttributes: function(chosenComponent) {
        var meterMin = chosenComponent.ordinal_attributes.slice()[0].meter;
        var meterMax = chosenComponent.ordinal_attributes.slice(-1)[0].meter;
        var rangeSteps = meterMax / chosenComponent.ordinal_attributes.length;
        var ordinalAttributes = '';
        ordinalAttributes += '<div id="criteriaAttributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="ordinalAttributesContainer">';
        ordinalAttributes += '<p class="ordinalAttributeChoice text-primary">Dynamisch Setzen</p>';
        ordinalAttributes += '<input type="range" min="1" max="5" step="1" list="attributes' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '">';
        ordinalAttributes += '<datalist id="attributesDataList' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '">';
        chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
            ordinalAttributes += '<option id="ordinalAttribute' + fmApp.ordinalAttributeIdPrefix + ordinalAttribute.id + '" value="' + ordinalAttribute.meter + '" name="' + ordinalAttribute.display_name + '">';
        });
        ordinalAttributes += '</datalist>';
        ordinalAttributes += '<table id="attributesList' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" class="table table-hover">';
        ordinalAttributes += '<tr>';
        ordinalAttributes += '<th>#</th>';
        ordinalAttributes += '<th>Label</th>';
        ordinalAttributes += '</tr>';
        chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
            ordinalAttributes += '<tr>';
            ordinalAttributes += '<td>' + ordinalAttribute.meter + '</td>';
            ordinalAttributes += '<td>' + ordinalAttribute.display_name + '</td>';
            ordinalAttributes += '</tr>';
        });
        ordinalAttributes += '</table>';
        ordinalAttributes += '</div>';
        return ordinalAttributes;
    },
    buildSingleNominalAttribute: function(nominalAttribute, chosenComponent) {
        var nominalAttributeToPaste = '';
        nominalAttributeToPaste += '<div class="nominalAttribute">';
        nominalAttributeToPaste += '<input type="radio" id="nominalAttribute' + this.nominalAttributeIdPrefix + nominalAttribute.id + '" name="attribues' + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id + '" value="' + nominalAttribute.id + '" />';
        nominalAttributeToPaste += '<label for="nominalAttribute' + this.nominalAttributeIdPrefix + nominalAttribute.id + '" title="text">';
        nominalAttributeToPaste += '<figure class="attrIcons ' + nominalAttribute.icon_path + '"></figure>';
        nominalAttributeToPaste += '<figcaption>' + nominalAttribute.display_name + '</figcaption>';
        nominalAttributeToPaste += '</label>';
        nominalAttributeToPaste += '</div>';

        return nominalAttributeToPaste;
    },
    setCurrent_ordinalAttributeChoice_String: function(modelType, id) {
        var cssSelector = "" + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id;
        var currentMeter = $("#criteriaAttributes" + cssSelector + "> input").val();
        // Get display_name to selected meter
        var displayNameToShow = this.findDisplayNameOfChoosenOrdinalAttribute(cssSelector, currentMeter);
        $("#criteriaAttributes" + cssSelector + "> p.ordinalAttributeChoice").html(displayNameToShow);
    },
    findDisplayNameOfChoosenOrdinalAttribute: function(cssSelector, currentMeter) {
        var foundDisplayName = null;
        $("datalist#attributesDataList" + cssSelector + " > option").each(function(index) {
            if (this.value == currentMeter) {
                foundDisplayName = $(this).attr("name");
            }
        });
        return foundDisplayName;
    },
    findIdOfChoosenOrdinalAttribute: function(cssSelector, currentMeter) {
        var foundId = null;
        $("datalist#attributesDataList" + cssSelector + " > option").each(function(index) {
            if (this.value == currentMeter) {
                foundId = fmApp.sliceOrdinalAttributeIdOffString(this.id);
            }
        });
        return foundId;
    },
    findIndexOfComponentInCriteria: function(modelType, id) {
        var foundIndex = null;
        criteria.forEach(function(component, index) {
            // Check if type machtes
            if (component.modelType == modelType) {
                // Check if ID matches
                if (component.id == id)  {
                    foundIndex = index;
                }
            }
        });
        return foundIndex;
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
    sliceComponentModelTypeOffString: function(findModelIn) {
        var foundModelType = findModelIn.slice(findModelIn.indexOf(this.componentModelTypePrefix) + this.componentModelTypePrefix.length, findModelIn.indexOf(this.componentIdPrefix));
        return foundModelType;
    },
    sliceComponentIdOffString: function(findIdIn) {
        var foundComponentId = findIdIn.slice(findIdIn.indexOf(this.componentIdPrefix) + this.componentIdPrefix.length);
        return parseInt(foundComponentId);
    },
    sliceCombinedCriteriaArrayIndexOffString: function(findCombinedCriteriaArrayIndexIn) {
        var foundCombinedCriteriaArrayIndex = findCombinedCriteriaArrayIndexIn.slice(findCombinedCriteriaArrayIndexIn.indexOf(this.combinedCriteriaArrayIndex) + this.combinedCriteriaArrayIndex.length);
        return foundCombinedCriteriaArrayIndex;
    },
    sliceNominalAttributeIdOffString: function(findNominalAttributeIdIn) {
        var foundNominalAttributeId = findNominalAttributeIdIn.slice(findNominalAttributeIdIn.indexOf(this.nominalAttributeIdPrefix) + this.nominalAttributeIdPrefix.length);
        return parseInt(foundNominalAttributeId);
    },
    sliceOrdinalAttributeIdOffString: function(findOrdinalAttributeIdIn) {
        var foundOrdinalAttributeId = findOrdinalAttributeIdIn.slice(findOrdinalAttributeIdIn.indexOf(this.ordinalAttributeIdPrefix) + this.ordinalAttributeIdPrefix.length);
        return parseInt(foundOrdinalAttributeId);
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
    },
    buildRatingRadio: function(modelType, id) {
        var ratingRadio;
        ratingRadioStart = '<div class="rate">';
        radiostar5 = '<input type="radio" id="star5' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" name="rate' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" value="5" ' + (this.getRating(modelType, id) == 5 ? 'checked' : '') + '/><label for="star5' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" title="text">5 stars</label>';
        radiostar4 = '<input type="radio" id="star4' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" name="rate' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" value="4" ' + (this.getRating(modelType, id) == 4 ? 'checked' : '') + '/><label for="star4' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" title="text">4 stars</label>';
        radiostar3 = '<input type="radio" id="star3' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" name="rate' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" value="3" ' + (this.getRating(modelType, id) == 3 ? 'checked' : '') + '/><label for="star3' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" title="text">3 stars</label>';
        radiostar2 = '<input type="radio" id="star2' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" name="rate' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" value="2" ' + (this.getRating(modelType, id) == 2 ? 'checked' : '') + '/><label for="star2' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" title="text">2 stars</label>';
        radiostar1 = '<input type="radio" id="star1' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" name="rate' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" value="1" ' + (this.getRating(modelType, id) == 1 ? 'checked' : '') + '/><label for="star1' + this.componentModelTypePrefix + modelType + this.componentIdPrefix + id + '" title="text">1 star</label>';
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
        var url = '../ypois/findMatches/';
        this.chosenSelection.forEach(function(component, index) {
            switch (component.componentType) {
                case 'BinaryComponents':
                    paramString += 'BC' + fmApp.componentIdPrefix + component.componentId + fmApp.binaryStatePrefix + (component.binaryState ? 1 : 0) + '=' + component.rating;
                    break;

                case 'NominalComponents':
                    paramString += 'NC' + fmApp.componentIdPrefix + component.componentId + fmApp.nominalAttributeIdPrefix + component.nominalAttributeId + '=' + component.rating;
                    break;

                case 'OrdinalComponents':
                    paramString += 'OC' + fmApp.componentIdPrefix + component.componentId + fmApp.ordinalAttributeIdPrefix + component.ordinalAttributeId + '=' + component.rating;
                    break;
            }
            paramString += index < (fmApp.chosenSelection.length - 1) ? "&" : "";
        });
        window.location = url + paramString;
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

    if (configuredSelection) {
        $("#loadingSpinnerContainer").fadeIn(500);
        fmApp.addComponent(configuredSelection);
    }
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

    // Click handler for binary choice
    $("#criteriaOutput").on("click", ".binaryComponentContainer > label.switch > input", function() {
        // Get component string of clicked nomnial attribuite element
        var componentIdentifierName = $(this).parent().parent().parent().parent().attr("id");
        // Extract ModelType of component
        var componentModelType = fmApp.sliceComponentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.sliceComponentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.findIndexOfChosenComponent(componentModelType, componentId);
        // Get recent binary component state
        var recentBinaryState = $(this).is(":checked");
        // Set binary choice in Selection on update
        fmApp.setBinaryChoice(indexInSelection, recentBinaryState);
    });
    // Click handler for nominal attribute choice
    $("#criteriaOutput").on("click", ".nominalAttributesContainer > .nominalAttribute > input", function() {
        // Get component string of clicked nomnial attribuite element
        var componentIdentifierName = $(this).attr("name");
        // Get nominal attribute string of clicked nomnial attribuite element
        var nominalAttributeIdentifierName = this.id;
        // Extract ModelType of component
        var componentModelType = fmApp.sliceComponentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.sliceComponentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.findIndexOfChosenComponent(componentModelType, componentId);
        // Extract id of nominal attribute
        var nominalAttributeId = fmApp.sliceNominalAttributeIdOffString(nominalAttributeIdentifierName);
        // Set attribute choice in Selection on update
        fmApp.setNominalChoice(indexInSelection, nominalAttributeId);
    });

    // Click handler for ordinal attribute choice
    $("#criteriaOutput").on("mousedown mousemove mouseup", ".ordinalAttributesContainer > input", function() {
        // Get component string of clicked rating element
        var componentIdentifierName = $(this).attr("list");
        // Extract ModelType of component
        var componentModelType = fmApp.sliceComponentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.sliceComponentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.findIndexOfChosenComponent(componentModelType, componentId);
        // Actual clicked Rating
        var recentOrdinalAttributeMeter = $(this).val();
        // Build CSS Selector
        var cssSelector = "" + fmApp.componentModelTypePrefix + componentModelType + fmApp.componentIdPrefix + componentId;
        // Get id of current selected ordinal attribute
        var recentOrdinalAttributeId = fmApp.findIdOfChoosenOrdinalAttribute(cssSelector, recentOrdinalAttributeMeter);
        // Set ordinal attribute choice string on update
        fmApp.setCurrent_ordinalAttributeChoice_String(componentModelType, componentId);
        // Set ordinal attribute choice in Selection on update
        fmApp.setOrdinalChoice(indexInSelection, recentOrdinalAttributeId);
    });

    // Click handler for rating
    $("#criteriaOutput").on("click", ".rate>input", function() {
        // Get component string of clicked rating element
        var componentIdentifierName = $(this).attr("name");
        // Extract ModelType of component
        var componentModelType = fmApp.sliceComponentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.sliceComponentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.findIndexOfChosenComponent(componentModelType, componentId);
        // Actual clicked Rating
        var recentRating = $(this).val();
        // Set Rating
        fmApp.setRating(indexInSelection, recentRating);
    });
});
