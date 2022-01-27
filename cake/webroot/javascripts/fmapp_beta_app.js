/*
 * This is fmapp beta data script
 */

var fmApp = {
    init: function(params) {
        // … do something
    },

    // Main Props
    binaryStatePrefix: '_BC-STATE_',
    combinedCriteriaArrayIndex: '_ALLC-ID_',
    componentIdPrefix: '_C-ID_',
    componentModelTypePrefix: '_C-MODEL_',
    chosenSelection: [],
    currentComponent: "",
    nominalAttributeIdPrefix: '_NCATTR-ID_',
    ordinalAttributeIdPrefix: '_OCATTR-ID_',
    standardRating: 3, // Out of 5
    geoLocation: {
        latLong: [49.01, 8.40806],
        accuracy: 50,
        useNavigator: false
    },
    mouseData: {
        mMove: {
            showMap: false,
            data: []
        },
        mClick: {
            showMap: false,
            data: []
        },
        aoi: {
            showData: false,
            list: {
                pois: []
            },
            chord: {
                pois: [],
                choosenComponents: [],
                otherComponents: []
            },
            map: {
                mapComponentsChoice: [],
                pois: [],
                dragMap: [],
                dragPopup: [],
                zoomMap: [],
            }
        }
    },

    // Main Controls
    checks: {
        input: function() {
            var inputValue = $("#criteriaInput").val();
            if (inputValue !== "") {
                fmApp.addComponent();
            } else {
                fmApp.showInputError();
            }

        },
        isComponentAlreadyChoosen: function(selectedCriterion) {
            var componentChoosenState = false;
            let componentType = fmApp.gets.componentTypeByIdentifier(selectedCriterion.type);

            fmApp.chosenSelection.forEach(function(componentInSelection) {
                if (componentType == componentInSelection.componentType) {
                    if (selectedCriterion.id == componentInSelection.componentId)  {
                        componentChoosenState = true;
                    }
                }
            });

            return componentChoosenState;
        },
        dataMatching: function(criterionToCheck) {
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
        usersPosition: function() {
            if (fmApp.geoLocation.useNavigator) {
                console.log("App wants to use Geolocator");
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(fmApp.sets.usersPosition, (error) => {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                console.log("User denied the request for Geolocation. Maybe cause your are using no SSL connection?");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                console.log("Location information is unavailable.");
                                break;
                            case error.TIMEOUT:
                                console.log("The request to get user location timed out.");
                                break;
                            case error.UNKNOWN_ERROR:
                                console.log("An unknown error occurred.");
                                break;
                        }
                        // Set manualy by init
                        fmApp.gets.staticUserPosition();

                    });
                } else {
                    console.log("No Geolocator available");
                    fmApp.gets.staticUserPosition();
                }
            } else {
                console.log("App Geolocator is deactivated by init");
                fmApp.gets.staticUserPosition();
            }
            return;
        } 
    },
    finds: {
        displayNameOfChoosenOrdinalAttribute: function(cssSelector, currentMeter) {
            var foundDisplayName = null;
            $("datalist#attributesDataList" + cssSelector + " > option").each(function(index) {
                if (this.value == currentMeter) {
                    foundDisplayName = $(this).attr("name");
                }
            });
            return foundDisplayName;
        },
        idOfChoosenOrdinalAttribute: function(cssSelector, currentMeter) {
            var foundId = null;
            $("datalist#attributesDataList" + cssSelector + " > option").each(function(index) {
                if (this.value == currentMeter) {
                    foundId = fmApp.slices.ordinalAttributeIdOffString(this.id);
                }
            });
            console.log("Found: " + foundId);
            return foundId;
        },
        indexOfChosenComponent: function(modelType, id) {
            var foundIndex = null;
            fmApp.chosenSelection.forEach(function(component, index) {
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
        indexOfComponentInCriteria: function(modelType, id) {
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
        matchingComponentInAllCriteriaList: function(componentKey) {
            var componentKeyInAllCriteriaList = "#allCriteriaList_" + componentKey;
            var matchingComponentInAllCriteriaList = $(componentKeyInAllCriteriaList);
            return matchingComponentInAllCriteriaList;
        }
    },
    gets: {
        componentTypeByIdentifier: function(componentIdentifier) {
            let componentType = "";
            switch (componentIdentifier) {
                case 'BC':
                    componentType = "BinaryComponents";
                    break;

                case 'NC':
                    componentType = "NominalComponents";
                    break;

                case 'OC':
                    componentType = "OrdinalComponents";
                    break;
            }
            return componentType;
        },
        rating: function(modelType, id) {
            var selectionIndex;
            for (var i = 0; i < fmApp.chosenSelection.length; i++) {
                if (fmApp.chosenSelection[i].componentType == modelType && fmApp.chosenSelection[i].componentId == id) {
                    selectionIndex = i;
                } else {
                    selectionIndex = undefined;
                }
            }
            var rating = fmApp.chosenSelection[selectionIndex].rating;
            return rating;
        },
        staticUserPosition: function() {
            console.log("User position is set by static init values:");
            console.log(fmApp.geoLocation);
        }
    },
    pastes: {
        builds: {
            ratingRadio: function(modelType, id) {
                var ratingRadio;
                ratingRadioStart = '<div class="rate">';
                radiostar5 = '<input type="radio" id="star5' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" name="rate' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" value="5" ' + (fmApp.gets.rating(modelType, id) == 5 ? 'checked' : '') + '/><label for="star5' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" title="text">5 stars</label>';
                radiostar4 = '<input type="radio" id="star4' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" name="rate' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" value="4" ' + (fmApp.gets.rating(modelType, id) == 4 ? 'checked' : '') + '/><label for="star4' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" title="text">4 stars</label>';
                radiostar3 = '<input type="radio" id="star3' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" name="rate' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" value="3" ' + (fmApp.gets.rating(modelType, id) == 3 ? 'checked' : '') + '/><label for="star3' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" title="text">3 stars</label>';
                radiostar2 = '<input type="radio" id="star2' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" name="rate' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" value="2" ' + (fmApp.gets.rating(modelType, id) == 2 ? 'checked' : '') + '/><label for="star2' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" title="text">2 stars</label>';
                radiostar1 = '<input type="radio" id="star1' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" name="rate' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" value="1" ' + (fmApp.gets.rating(modelType, id) == 1 ? 'checked' : '') + '/><label for="star1' + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id + '" title="text">1 star</label>';
                ratingRadioEnd = '</div>';
                ratingRadio = ratingRadioStart + radiostar5 + radiostar4 + radiostar3 + radiostar2 + radiostar1 + ratingRadioEnd;
                return ratingRadio;
            },
            singleNominalAttribute: function(nominalAttribute, chosenComponent, attributeToSet) {
                var nominalAttributeToPaste = '';
                nominalAttributeToPaste += '<div class="nominalAttribute">';
                nominalAttributeToPaste += '<input type="radio" id="nominalAttribute' + fmApp.nominalAttributeIdPrefix + nominalAttribute.id + '" name="attribues' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '" value="' + nominalAttribute.id + '" ' + (nominalAttribute.id == attributeToSet ? 'checked' : '') + '/>';
                nominalAttributeToPaste += '<label for="nominalAttribute' + fmApp.nominalAttributeIdPrefix + nominalAttribute.id + '" title="text">';
                nominalAttributeToPaste += '<figure class="attrIcons ' + nominalAttribute.icon_path + '"></figure>';
                nominalAttributeToPaste += '<figcaption>' + nominalAttribute.display_name + '</figcaption>';
                nominalAttributeToPaste += '</label>';
                nominalAttributeToPaste += '</div>';

                return nominalAttributeToPaste;
            },
        },
        binarySwitch: function(chosenComponent, stateToSet) {
            var switchString = '';
            switchString += '<p class="binaryComponentContainer">';
            switchString += '<span class="componentNameBinarySlider">' + chosenComponent.display_name + '</span>';
            // Switch an simple HTML checkbox: https://www.w3schools.com/howto/howto_css_switch.asp
            switchString += '<label class="switch">';
            switchString += '<input type="checkbox" ' + (stateToSet ? 'checked' : '') + '>';
            switchString += '<span class="slider round"></span>';
            switchString += '</label>';
            switchString += '</p>';
            return switchString;
        },
        nominalAttributes: function(chosenComponent, attributeToSet) {
            var nominalAttributes = '';
            // Differentiate cols for Attributes based on amount
            if (chosenComponent.nominal_attributes.length % 3 == 0) {
                nominalAttributes += '<div id="criteriaAttributes' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '" class="nominalAttributesContainer triple">';
            } else {
                nominalAttributes += '<div id="criteriaAttributes' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '" class="nominalAttributesContainer fourfold">';
            }
            chosenComponent.nominal_attributes.forEach(function(nominalAttribute, index) {
                nominalAttributes += fmApp.pastes.builds.singleNominalAttribute(nominalAttribute, chosenComponent, attributeToSet);
            });
            nominalAttributes += '</div>';

            return nominalAttributes;
        },
        ordinalAttributes: function(chosenComponent, attributeToSet) {
            var meterMin = chosenComponent.ordinal_attributes.slice()[0].meter;
            var meterMax = chosenComponent.ordinal_attributes.slice(-1)[0].meter;
            var rangeSteps = meterMax / chosenComponent.ordinal_attributes.length;
            var valueToSet = null;
            if (attributeToSet)  {
                chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
                    if (ordinalAttribute.id == attributeToSet) {
                        valueToSet = ordinalAttribute.meter;
                    }
                });
            }
            var ordinalAttributes = '';
            ordinalAttributes += '<div id="criteriaAttributes' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '" class="ordinalAttributesContainer">';
            ordinalAttributes += '<p class="ordinalAttributeChoice text-primary">Dynamisch Setzen</p>';
            ordinalAttributes += '<input type="range" min="1" max="' + chosenComponent.ordinal_attributes.length + '" step="1" list="attributes' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '"' + (valueToSet ? 'value="' + valueToSet + '"' : '') + '>';
            ordinalAttributes += '<datalist id="attributesDataList' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '">';
            chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
                ordinalAttributes += '<option id="ordinalAttribute' + fmApp.ordinalAttributeIdPrefix + ordinalAttribute.id + '" value="' + ordinalAttribute.meter + '" name="' + ordinalAttribute.display_name + '">';
            });
            ordinalAttributes += '</datalist>';
            ordinalAttributes += '<table id="attributesList' + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id + '" class="table" title="Bitte nutzen Sie den Slider zum Einstellen">';
            ordinalAttributes += '<tr>';
            ordinalAttributes += '<th>#</th>';
            ordinalAttributes += '<th>Label</th>';
            ordinalAttributes += '</tr>';
            chosenComponent.ordinal_attributes.forEach(function(ordinalAttribute, index) {
                ordinalAttributes += '<tr id="ordinalAttributeTableRow' + fmApp.ordinalAttributeIdPrefix + ordinalAttribute.id + '">';
                ordinalAttributes += '<td>' + ordinalAttribute.meter + '</td>';
                ordinalAttributes += '<td>' + ordinalAttribute.display_name + '</td>';
                ordinalAttributes += '</tr>';
            });
            ordinalAttributes += '</table>';
            ordinalAttributes += '</div>';
            return ordinalAttributes;
        },
    },
    sets: {
        binaryChoice: function(indexOfChosenSelection, newBinaryState) {
            var componentToSetBinaryChoice = fmApp.chosenSelection[indexOfChosenSelection];
            componentToSetBinaryChoice.binaryState = newBinaryState;
        },
        criterionByInputChoice: function(inputValue) {
            selectedCriterion = {
                type: inputValue.slice(0, 2),
                // Get ID between prefixes out of string
                id: fmApp.slices.componentIdOffString(inputValue),
                // Get Index position in array after last prefix out of string
                index: fmApp.slices.combinedCriteriaArrayIndexOffString(inputValue)
            };
            return selectedCriterion;
        },
        criterionByURLData: function(inputValue) {
            var componentIdentifier = inputValue.slice(0, 2);
            var componentType = fmApp.gets.componentTypeByIdentifier(componentIdentifier);
            var componentId = fmApp.slices.componentIdOffString(inputValue);
            selectedCriterion = {
                type: componentIdentifier,
                // Get ID between prefixes out of string
                id: componentId,
                // Get Index position in array after last prefix out of string
                index: fmApp.finds.indexOfComponentInCriteria(componentType, componentId)
            };
            return selectedCriterion;
        },
        current_ordinalAttributeChoice_String: function(modelType, id) {
            var cssSelector = "" + fmApp.componentModelTypePrefix + modelType + fmApp.componentIdPrefix + id;
            var currentMeter = $("#criteriaAttributes" + cssSelector + "> input").val();
            // Get display_name to selected meter
            var displayNameToShow = fmApp.finds.displayNameOfChoosenOrdinalAttribute(cssSelector, currentMeter);
            $("#criteriaAttributes" + cssSelector + "> p.ordinalAttributeChoice").html(displayNameToShow);
        },
        current_ordinalAttributeChoice_TableRow: function(attributesList, ordinalAttributeTableRow) {
            $("table#" + attributesList + " tr").each(function(index) {
                $(this).removeClass("success");
            });
            $("tr#" + ordinalAttributeTableRow).addClass("success");
        },
        nominalChoice: function(indexOfChosenSelection, newNominalAttributeId) {
            var componentToSetNominalAttributeChoice = fmApp.chosenSelection[indexOfChosenSelection];
            componentToSetNominalAttributeChoice.nominalAttributeId = newNominalAttributeId;
        },
        ordinalChoice: function(indexOfChosenSelection, newOrdinalAttributeId) {
            var componentToSetOrdinalAttributeChoice = fmApp.chosenSelection[indexOfChosenSelection];
            componentToSetOrdinalAttributeChoice.ordinalAttributeId = newOrdinalAttributeId;
        },
        rating: function(indexOfChosenSelection, newRating) {
            var componentToSetRating = fmApp.chosenSelection[indexOfChosenSelection];
            componentToSetRating.rating = newRating;
        },
        usersPosition: function(position) {
            fmApp.geoLocation.latLong = [
                position.coords.latitude,
                position.coords.longitude
            ];
            fmApp.geoLocation.accuracy = position.coords.accuracy;
            console.log(fmApp.geoLocation);
        },
        sessionGeo: function(url, paramString) {

            var jqxhr = $.ajax({
                    method: "POST",
                    url: storeUserPositionInSessionURL,
                    data: {
                        latitude: $("#latitude").val(),
                        longitude: $("#longitude").val(),
                        accuracy: $("#accuracy").val()
                    },
                    beforeSend: function() {
                        fmApp.checks.usersPosition();
                        $("#loadingSpinnerContainer").fadeIn(500, function(event) {
                            // Set values in Input fields
                            $("#latitude").val(fmApp.geoLocation.latLong[0]);
                            $("#longitude").val(fmApp.geoLocation.latLong[1]);
                            $("#accuracy").val(fmApp.geoLocation.accuracy);
                        });
                    }
                })
                .done(function() {
                    console.log("Data Sent to API");
                })
                .fail(function() {
                    alert("An error occured results will not be sorted by distance");
                });

            // Set another completion function for the request above
            jqxhr.always(function() {
                setTimeout(function() {
                    history.pushState({ 'setHistoryWithParams': true }, document.title, paramString);
                    $("#loadingSpinnerContainer").hide("slow");
                    window.location = url + paramString;
                }, 500);
            });
        }
    },
    slices: {
        binaryStateOffStringAsBoolean: function(findBinaryStateIn) {
            var foundBinaryState = findBinaryStateIn.slice(findBinaryStateIn.indexOf(fmApp.binaryStatePrefix) + fmApp.binaryStatePrefix.length);
            return !!(parseInt(foundBinaryState));
        },
        combinedCriteriaArrayIndexOffString: function(findCombinedCriteriaArrayIndexIn) {
            var foundCombinedCriteriaArrayIndex = findCombinedCriteriaArrayIndexIn.slice(findCombinedCriteriaArrayIndexIn.indexOf(fmApp.combinedCriteriaArrayIndex) + fmApp.combinedCriteriaArrayIndex.length);
            return foundCombinedCriteriaArrayIndex;
        },
        componentIdOffString: function(findIdIn) {
            var foundComponentId = findIdIn.slice(findIdIn.indexOf(fmApp.componentIdPrefix) + fmApp.componentIdPrefix.length);
            return parseInt(foundComponentId);
        },
        componentModelTypeOffString: function(findModelIn) {
            var foundModelType = findModelIn.slice(findModelIn.indexOf(fmApp.componentModelTypePrefix) + fmApp.componentModelTypePrefix.length, findModelIn.indexOf(fmApp.componentIdPrefix));
            return foundModelType;
        },
        nominalAttributeIdOffString: function(findNominalAttributeIdIn) {
            var foundNominalAttributeId = findNominalAttributeIdIn.slice(findNominalAttributeIdIn.indexOf(fmApp.nominalAttributeIdPrefix) + fmApp.nominalAttributeIdPrefix.length);
            return parseInt(foundNominalAttributeId);
        },
        ordinalAttributeIdOffString: function(findOrdinalAttributeIdIn) {
            var foundOrdinalAttributeId = findOrdinalAttributeIdIn.slice(findOrdinalAttributeIdIn.indexOf(fmApp.ordinalAttributeIdPrefix) + fmApp.ordinalAttributeIdPrefix.length);
            return parseInt(foundOrdinalAttributeId);
        },
        criteriaListOffString: function(findCriteriaListIn)  {
            var slicedIdentifier = findCriteriaListIn.slice(13);
            return slicedIdentifier;
        },
        allCriteriaListOffString: function(findAllCriteriaListIn)  {
            var slicedIdentifier = findAllCriteriaListIn.slice(16);
            return slicedIdentifier;
        },
    },

    // Main Functions
    addComponent: function(componentDataFromURL, componentDataFromCriteriaList) {
        var chosenComponent;
        var selectedCriterion;
        var inputValue;
        var bcState = null;
        var ncAttrId = null;
        var ocAttrId = null;
        var matchingComponentInAllCriteriaList;
        // Set Component Data
        if (componentDataFromURL) {
            inputValue = componentDataFromURL.identifierString;
            selectedCriterion = fmApp.sets.criterionByURLData(inputValue);
            cRating = componentDataFromURL.rating;
            bcState = selectedCriterion.type == 'BC' ? fmApp.slices.binaryStateOffStringAsBoolean(inputValue) : null;
            ncAttrId = selectedCriterion.type == 'NC' ? fmApp.slices.nominalAttributeIdOffString(inputValue) : null;
            ocAttrId = selectedCriterion.type == 'OC' ? fmApp.slices.ordinalAttributeIdOffString(inputValue) : null;
            console.log("Coming from URL");
            console.log("selectedCriterion is: ");
            console.log(selectedCriterion);
            console.log("Input Value: " + inputValue);
            console.log("");
        } else if (componentDataFromCriteriaList) {
            console.log("Value from List ID: " + componentDataFromCriteriaList);
            inputValue = componentDataFromCriteriaList;
            cRating = this.standardRating;
            selectedCriterion = fmApp.sets.criterionByURLData(inputValue);
            console.log("Coming from AllCriteriaList");
            console.log("selectedCriterion is: ");
            console.log(selectedCriterion);
            console.log("Input Value: " + inputValue);
            console.log("");
            bcState = selectedCriterion.type == 'BC' ? true : null;
        } else {
            inputValue = $("#criteriaInput").val();
            cRating = this.standardRating;
            selectedCriterion = fmApp.sets.criterionByInputChoice(inputValue);
            bcState = selectedCriterion.type == 'BC' ? true : null;
            console.log("Coming from Input");
            console.log("selectedCriterion is: ");
            console.log(selectedCriterion);
            console.log("Input Value: " + inputValue);
            console.log("");
        }
        // Check Data
        if (this.checks.dataMatching(selectedCriterion)) {
            chosenComponent = criteria[selectedCriterion.index];
        } else {
            this.alertMessage("Fehler bei der Datenzuordnung Ihrer Auswahl", "alert-danger");
            console.log("Matching-Error \nAuswahl: " + criterionNames[selectedCriterion.index][0] + "\n" + "Zuordnung: " + criteria[selectedCriterion.index].display_name + "\nAus Input kommend: " + inputValue + "\n" + "Index: " + selectedCriterion.index + "\n" + "Typ: " + selectedCriterion.type + "\n" + "Model-ID: " + selectedCriterion.id);
        }
        // Reset input-field
        $("#criteriaInput").val("").attr('placeholder', '').toggleClass("chosen");
        setTimeout(function() {
            $("#criteriaInput").attr('placeholder', 'Weitere wählen').toggleClass("chosen");
        }, 2000);

        // Check if selected component is not already chosen
        var componentAlreadyChoosen = fmApp.checks.isComponentAlreadyChoosen(selectedCriterion);
        if (componentAlreadyChoosen) {
            fmApp.alertMessage("Die Kategorie <strong>" + chosenComponent.display_name + "</strong> wurde bereitsausgewählt.<br> Sie können diese Komponente nicht erneut auswählen.", "alert-danger");
        } else {
            // Add Component to selection
            this.chosenSelection.push({
                'componentName': chosenComponent.display_name,
                'componentType': chosenComponent.modelType,
                'componentId': chosenComponent.id,
                'rating': cRating,
                'binaryState': bcState,
                'nominalAttributeId': ncAttrId,
                'ordinalAttributeId': ocAttrId
            });
            // Show Labels and Button
            $(".areaLabel").show();
            $("#showAction").show();
            var criteriaListIdentifier = "criteriaList" + this.componentModelTypePrefix + chosenComponent.modelType + this.componentIdPrefix + chosenComponent.id;
            // Prepend chosen component
            this.currentComponent = '<p id="' + criteriaListIdentifier + '">' + chosenComponent.display_name + ' <a title="Diese Kategorie löschen" class="throwComponent"><span class="glyphicon glyphicon-minus-sign text-danger" aria-hidden="true"></span></a></p>';
            $("#criteriaChoice").append(this.currentComponent);
            this.currentComponent = null;
            // Add deletion action
            $("#" + criteriaListIdentifier + " .throwComponent").click(function() {
                var componentToDelete = $(this).parent().attr("id");
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
                chosenComponentToPaste += this.pastes.binarySwitch(chosenComponent, bcState);
                this.sets.binaryChoice(this.finds.indexOfChosenComponent(chosenComponent.modelType, chosenComponent.id), bcState);
            }
            if (chosenComponent.modelType == 'NominalComponents') {
                // Check if component is chosen from URL, so prepending is not necessary
                if (componentDataFromURL) {
                    chosenComponentToPaste += this.pastes.nominalAttributes(chosenComponent, ncAttrId);
                } else {
                    // Prepend chosen component
                    chosenComponentToPaste += this.pastes.nominalAttributes(chosenComponent, chosenComponent.nominal_attributes[0].id);
                    this.sets.nominalChoice(this.finds.indexOfChosenComponent(chosenComponent.modelType, chosenComponent.id), chosenComponent.nominal_attributes[0].id);
                }
            }
            if (chosenComponent.modelType == 'OrdinalComponents') {
                // Check if component is chosen from URL, so prepending is not necessary
                if (componentDataFromURL) {
                    chosenComponentToPaste += this.pastes.ordinalAttributes(chosenComponent, ocAttrId);
                } else {
                    // Prepend chosen component
                    chosenComponentToPaste += this.pastes.ordinalAttributes(chosenComponent, chosenComponent.ordinal_attributes[0].id);
                    this.sets.ordinalChoice(this.finds.indexOfChosenComponent(chosenComponent.modelType, chosenComponent.id), chosenComponent.ordinal_attributes[0].id);
                }
            }

            chosenComponentToPaste += '</div>';

            var chosenComponentToPasteRating = "";
            chosenComponentToPasteRating += '<div class="col-md-6">';
            chosenComponentToPasteRating += this.pastes.builds.ratingRadio(chosenComponent.modelType, chosenComponent.id);
            chosenComponentToPasteRating += '</div>';
            chosenComponentToPasteRating += '</div>';

            // $("#criteriaOutput").append(labelRow + chosenComponentToPaste + chosenComponentToPasteRating);
            $("#criteriaOutput").append(chosenComponentToPaste + chosenComponentToPasteRating);

            // Set ordinal attribute choice string initialy
            if (chosenComponent.modelType == 'OrdinalComponents') {
                this.sets.current_ordinalAttributeChoice_String(chosenComponent.modelType, chosenComponent.id);
                this.sets.current_ordinalAttributeChoice_TableRow("attributesList" + fmApp.componentModelTypePrefix + chosenComponent.modelType + fmApp.componentIdPrefix + chosenComponent.id, "ordinalAttributeTableRow" + fmApp.ordinalAttributeIdPrefix + chosenComponent.ordinal_attributes[0].id);
            }
        }
    },
    alertMessage: function(alertText, alertState) {
        /*
         * There are three different alert state by Bootstrap
         * sucess | info | warning | danger
         */
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
    },
    comparePois: function() {
        var paramString = "?";
        var url = 'findMatches/selectViz';
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

        fmApp.sets.sessionGeo(url, paramString);

    },
    deleteComponent: function(delName) {
        // Delete entry from criteria list
        $("#" + delName).remove();
        // Slice Information
        var cleanedIdentifier = fmApp.slices.criteriaListOffString(delName);
        var deletionDOMID = "#criteriaOptions_" + cleanedIdentifier;
        var deletionComponentType = fmApp.slices.componentModelTypeOffString(cleanedIdentifier);
        var deletionComponentId = fmApp.slices.componentIdOffString(cleanedIdentifier);

        // Delete DOM elem from selection area
        $(deletionDOMID).remove();
        // Find elem in choosenSelction object
        var deletionChosenSelectionIndexconsole = fmApp.finds.indexOfChosenComponent(deletionComponentType, deletionComponentId);
        // Delette JS object elem

        fmApp.chosenSelection.splice(deletionChosenSelectionIndexconsole, 1);

        // Update params for future routing
        // Temporarly not necessary because on #showAction click will build everything based on chosenSelection

    },
    showInputError: function() {
        $("#criteriaInput").attr('placeholder', 'Kategorie wählen!').toggleClass("noChoice");
        setTimeout(function() {
            $("#criteriaInput").toggleClass("noChoice");
        }, 2000);
    },
    heatmap: {
        config: {
            container: document.getElementById('heatmap'),
            radius: 50,
            maxOpacity: 0.5,
            minOpacity: 0,
            blur: 0.75,
            // gradient: {
            //   // enter n keys between 0 and 1 here
            //   // for gradient color customization
            //   '0.5': 'blue',
            //   '0.8': 'red',
            //   '0.95': 'white'
            // }
        },
        init: function()  {
            console.log("Init Heatmap");
            heatmap = h337.create(fmApp.heatmap.config);
        },
        reinit: function() {
            heatmap = undefined;
            document.getElementById('heatmap').innerHTML = "";
            heatmap = h337.create(fmApp.heatmap.config);
            console.log("Heatmap re-initialized");
        },
        setHideAllMaps: function() {
            for (const trackingType in fmApp.mouseData) {
                if (Object.hasOwnProperty.call(fmApp.mouseData, trackingType)) {
                    fmApp.mouseData[trackingType].showMap = false;
                }
            }
        },
        showFront: function() {
            $("#heatmapContainer").css("z-index", "1010");
        },
        hideBack: function() {
            $("#heatmapContainer").css("z-index", "0");
        },
        getCenteredCoordinates: function(item, ev) {
            let elementCenters = {};

            let bodyRect = document.body.getBoundingClientRect(),
                elemRect = item.getBoundingClientRect();
            elementCenters.centerX = Math.round(elemRect.left + item.offsetWidth / 2);
            elementCenters.centerY = Math.round(elemRect.top + item.offsetHeight / 2);
            if (ev == "click") console.log("elem " + elemRect.top + " / body " + bodyRect.top + " / item.offsetHeight " + item.offsetHeight + " / itemH/2 " + item.offsetHeight / 2);
            if (ev == "click") console.log("eCenter " + elementCenters.centerY);

            return elementCenters;
        },
        showAoiData: function(displayVariant) {
            fmApp.heatmap.setHideAllMaps();
            let heatMapData = {
                max: 1,
                min: 0,
                data: []
            };
            switch (displayVariant) {
                case "list":
                    heatmap.setData(heatMapData);
                    $("#aoiChordTables").hide();
                    $("#aoiMapTables").hide();
                    $("#aoiListTables").show();
                    break;

                case "chord":
                    heatmap.setData(heatMapData);
                    $("#aoiListTables").hide();
                    $("#aoiMapTables").hide();
                    $("#aoiChordTables").show();
                    break;

                case "map":
                    mymap.removeLayer(heatmapLayer);
                    heatmapLayer.setData(heatMapData);
                    $("#aoiListTables").hide();
                    $("#aoiChordTables").hide();
                    $("#aoiMapTables").show();
                    break;

                default:
                    break;
            }
            $("#aoiInfoContainer").addClass("show");
        },
        hideAoiData: function() {
            $("#aoiInfoContainer").removeClass("show");
        },
        debugShow: {
            mMove: function()  {
                let mMoveState = fmApp.mouseData.mMove.showMap;
                fmApp.heatmap.setHideAllMaps();
                fmApp.heatmap.hideAoiData();
                if (fmApp.mouseData.aoi.showData) fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                fmApp.mouseData.mMove.showMap = !mMoveState;
                let heatMapData = {
                    max: 10,
                    min: 0,
                    data: fmApp.mouseData.mMove.showMap ? fmApp.mouseData.mMove.data : []
                };
                heatmap.setData(heatMapData);
                if (fmApp.mouseData.mMove.showMap) fmApp.heatmap.showFront();
                else fmApp.heatmap.hideBack();
            },
            mMoveMap: function()  {
                let mMoveState = fmApp.mouseData.mMove.showMap;
                fmApp.heatmap.setHideAllMaps();
                fmApp.heatmap.hideAoiData();
                if (fmApp.mouseData.aoi.showData) fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                fmApp.mouseData.mMove.showMap = !mMoveState;
                let heatMapData = {
                    max: 10,
                    min: 0,
                    data: fmApp.mouseData.mMove.showMap ? fmApp.mouseData.mMove.data : []
                };
                if (fmApp.mouseData.mMove.showMap) mymap.addLayer(heatmapLayer);
                else mymap.removeLayer(heatmapLayer);
                heatmapLayer.setData(heatMapData);
            },
            mClick: function()  {
                let mClickState = fmApp.mouseData.mClick.showMap;
                fmApp.heatmap.setHideAllMaps();
                fmApp.heatmap.hideAoiData();
                if (fmApp.mouseData.aoi.showData) fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                fmApp.mouseData.mClick.showMap = !mClickState;
                let heatMapData = {
                    max: 1,
                    min: 0,
                    data: fmApp.mouseData.mClick.showMap ? fmApp.mouseData.mClick.data : []
                };
                heatmap.setData(heatMapData);
                if (fmApp.mouseData.mClick.showMap) fmApp.heatmap.showFront();
                else fmApp.heatmap.hideBack();
            },
            mClickMap: function()  {
                let mClickState = fmApp.mouseData.mClick.showMap;
                fmApp.heatmap.setHideAllMaps();
                fmApp.heatmap.hideAoiData();
                if (fmApp.mouseData.aoi.showData) fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                fmApp.mouseData.mClick.showMap = !mClickState;
                let heatMapData = {
                    max: 1,
                    min: 0,
                    data: fmApp.mouseData.mClick.showMap ? fmApp.mouseData.mClick.data : []
                };
                if (fmApp.mouseData.mClick.showMap) mymap.addLayer(heatmapLayer);
                else mymap.removeLayer(heatmapLayer);
                heatmapLayer.setData(heatMapData);
            },
            aoiList: function() {
                fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                let aoiModalState = fmApp.mouseData.aoi.showData;
                if (aoiModalState) {
                    let zwiebel = 0,
                        vapiano = 0,
                        oishii = 0,
                        diner = 0;
                    console.log(zwiebel, vapiano, oishii, diner);
                    fmApp.mouseData.aoi.list.pois.forEach(poi => {
                        switch (poi.poi) {
                            case "Die Zwiebel":
                                zwiebel++;
                                break;
                            case "Vapiano":
                                vapiano++;
                                break;
                            case "Oishii":
                                oishii++;
                                break;
                            case "American Diner Durlach":
                                diner++;
                                break;

                            default:
                                break;
                        }
                    });
                    $("#aoiListValue-zwiebel > span").html(zwiebel);
                    $("#aoiListValue-vapiano > span").html(vapiano);
                    $("#aoiListValue-oishii > span").html(oishii);
                    $("#aoiListValue-diner > span").html(diner);
                    let allListEvents = fmApp.mouseData.aoi.list.pois;
                    $("#allListEventsTableBody").html("");
                    let newTableRows = "";
                    allListEvents.sort(function(x, y) {
                        return x.time - y.time;
                    });
                    allListEvents.forEach(event => {
                        newTableRows +=
                            `
                            <tr>
                                <td>${event.poi}</td>
                                <td>${new Date(event.time).toLocaleString()}</td>
                                <td>${event.value}</td>
                            </tr>
                        `;
                    });
                    $("#allListEventsTableBody").html(newTableRows);
                    fmApp.heatmap.showAoiData("list");
                } else {
                    fmApp.heatmap.hideAoiData();
                }
            },
            aoiChord: function() {
                fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                let aoiModalState = fmApp.mouseData.aoi.showData;
                if (aoiModalState) {
                    console.log(fmApp.mouseData.aoi);
                    $("#aoiChordValue-pois > span").html(fmApp.mouseData.aoi.chord.pois.length);
                    $("#aoiChordValue-choosenComponents > span").html(fmApp.mouseData.aoi.chord.choosenComponents.length);
                    $("#aoiChordValue-otherComponents > span").html(fmApp.mouseData.aoi.chord.otherComponents.length);
                    let allChordEvents = [];
                    Object.entries(fmApp.mouseData.aoi.chord).forEach(arcType => {
                        const [key, value] = arcType;
                        value.forEach(
                            dataPoint => {
                                allChordEvents.push(dataPoint);
                            });
                    });
                    $("#allChordEventsTableBody").html("");
                    let newTableRows = "";
                    allChordEvents.sort(function(x, y) {
                        return x.time - y.time;
                    });
                    allChordEvents.forEach(event => {
                        let namePrefix = "";

                        switch (event.arc) {
                            case "poi":
                                namePrefix = "P";
                                break;
                            case "choosenComponent":
                                namePrefix = "\u2605";
                                break;
                            case "otherComponent":
                                namePrefix = "O";
                                break;

                            default:
                                break;
                        }

                        newTableRows += `
                            <tr>
                                <td>${event.name}</td>
                                <td>${namePrefix} ${new Date(event.time).toLocaleString()}</td>
                                <td>${event.value}</td>
                            </tr>
                        `;
                    });
                    $("#allChordEventsTableBody").html(newTableRows);
                    fmApp.heatmap.showAoiData("chord");
                } else {
                    fmApp.heatmap.hideAoiData();
                }
            },
            aoiMap: function() {
                fmApp.mouseData.aoi.showData = !fmApp.mouseData.aoi.showData;
                let aoiModalState = fmApp.mouseData.aoi.showData;
                if (aoiModalState) {
                    $("#aoiMapValue-mapComponentsChoice > span").html(fmApp.mouseData.aoi.map.mapComponentsChoice.length);
                    $("#aoiMapValue-pois > span").html(fmApp.mouseData.aoi.map.pois.length);
                    $("#aoiMapValue-dragMap > span").html(fmApp.mouseData.aoi.map.dragMap.length);
                    $("#aoiMapValue-dragPopup > span").html(fmApp.mouseData.aoi.map.dragPopup.length);
                    $("#aoiMapValue-zoomMap > span").html(fmApp.mouseData.aoi.map.zoomMap.length);
                    let allMapEvents = [];
                    Object.entries(fmApp.mouseData.aoi.map).forEach(mapEvent => {
                        const [key, value] = mapEvent;
                        value.forEach(
                            dataPoint => {
                                dataPoint.mapEvent = key;
                                allMapEvents.push(dataPoint);
                            });
                    });
                    $("#allMapEventsTableBody").html("");
                    let newTableRows = "";
                    allMapEvents.sort(function(x, y) {
                        return x.time - y.time;
                    });
                    allMapEvents.forEach(event => {
                        let name = event.mapEvent;

                        switch (event.mapEvent) {
                            case "dragMap":
                                name += " " + event.event;
                                break;
                            case "dragPopup":
                                name += " " + event.poi + " " + event.event;
                                break;
                            case "mapComponentsChoice":
                                name += " " + event.componentType;
                                break;
                            case "pois":
                                name += " " + event.poi;
                                break;
                            case "zoomMap":
                                name += " " + event.event + " " + event.zoom;
                                break;

                            default:
                                break;
                        }

                        newTableRows += `
                            <tr>
                                <td>${name}</td>
                                <td>${new Date(event.time).toLocaleString()}</td>
                                <td>${event.value}</td>
                            </tr>
                        `;
                    });
                    $("#allMapEventsTableBody").html(newTableRows);
                    fmApp.heatmap.showAoiData("map");
                    console.log(fmApp.mouseData.aoi.map);
                } else {
                    fmApp.heatmap.hideAoiData();
                }
            }
        }
    }
};

var heatmap;

$(document).ready(function() {

    if (configuredSelection) {
        $("#criteriaChoice").fadeOut(250);
        $("#criteriaOutput").fadeOut(250);
        $("#loadingSpinnerContainer").fadeIn(500, function(event) {
            for (var configuredComponentKey in configuredSelection) {
                var componentDataFromURL = { identifierString: configuredComponentKey, rating: configuredSelection[configuredComponentKey] };
                fmApp.addComponent(componentDataFromURL);
            }
            setTimeout(function() {
                $("#criteriaChoice").fadeIn(250);
                $("#criteriaOutput").fadeIn(250, function(event) {
                    $("#loadingSpinnerContainer").fadeOut(500);
                });
            }, 1000);
        });
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

    $(".addFromList").click(function() {
        event.preventDefault();
        var criterionListID = $(this).attr('id');
        var criteronToken = fmApp.slices.allCriteriaListOffString(criterionListID);
        // var componentDataLikeFromURL = {"identifierString": fmApp.slices.allCriteriaListOffString(criteronToken), "rating": "3"};
        fmApp.addComponent(null, criteronToken);
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
        var componentModelType = fmApp.slices.componentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.slices.componentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.finds.indexOfChosenComponent(componentModelType, componentId);
        // Get recent binary component state
        var recentBinaryState = $(this).is(":checked");
        // Set binary choice in Selection on update
        fmApp.sets.binaryChoice(indexInSelection, recentBinaryState);
    });

    // Click handler for nominal attribute choice
    $("#criteriaOutput").on("click", ".nominalAttributesContainer > .nominalAttribute > input", function() {
        // Get component string of clicked nomnial attribuite element
        var componentIdentifierName = $(this).attr("name");
        // Get nominal attribute string of clicked nomnial attribuite element
        var nominalAttributeIdentifierName = this.id;
        // Extract ModelType of component
        var componentModelType = fmApp.slices.componentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.slices.componentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.finds.indexOfChosenComponent(componentModelType, componentId);
        // Extract id of nominal attribute
        var nominalAttributeId = fmApp.slices.nominalAttributeIdOffString(nominalAttributeIdentifierName);
        // Set attribute choice in Selection on update
        fmApp.sets.nominalChoice(indexInSelection, nominalAttributeId);
    });

    // Click handler for ordinal attribute choice, first try was [mousedown mousemove mouseup] but input seems to work as well
    $("#criteriaOutput").on("input", ".ordinalAttributesContainer > input", function() {
        // Get component string of clicked rating element
        var componentIdentifierName = $(this).attr("list");
        // Extract ModelType of component
        var componentModelType = fmApp.slices.componentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.slices.componentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.finds.indexOfChosenComponent(componentModelType, componentId);
        // Actual clicked Rating
        var recentOrdinalAttributeMeter = $(this).val();
        // Build CSS Selector
        var cssSelector = "" + fmApp.componentModelTypePrefix + componentModelType + fmApp.componentIdPrefix + componentId;
        // Get id of current selected ordinal attribute
        var recentOrdinalAttributeId = fmApp.finds.idOfChoosenOrdinalAttribute(cssSelector, recentOrdinalAttributeMeter);
        // Set ordinal attribute choice string on update
        fmApp.sets.current_ordinalAttributeChoice_String(componentModelType, componentId);
        // Set ordinal attribute choice table row highlight
        fmApp.sets.current_ordinalAttributeChoice_TableRow("attributesList" + cssSelector, "ordinalAttributeTableRow" + fmApp.ordinalAttributeIdPrefix + recentOrdinalAttributeId);

        // Set ordinal attribute choice in Selection on update
        fmApp.sets.ordinalChoice(indexInSelection, recentOrdinalAttributeId);
    });

    // Click handler for rating
    $("#criteriaOutput").on("click", ".rate>input", function() {
        // Get component string of clicked rating element
        var componentIdentifierName = $(this).attr("name");
        // Extract ModelType of component
        var componentModelType = fmApp.slices.componentModelTypeOffString(componentIdentifierName);
        // Extract Id of component
        var componentId = fmApp.slices.componentIdOffString(componentIdentifierName);
        // Get Index to set Rating in chosenSelection
        var indexInSelection = fmApp.finds.indexOfChosenComponent(componentModelType, componentId);
        // Actual clicked Rating
        var recentRating = $(this).val();
        // Set Rating
        fmApp.sets.rating(indexInSelection, recentRating);
    });

    // Add CSS pointer for list view panel-headings
    $("#listView .panel-heading").css("cursor", "pointer");

    // Click handler for list view "Mehr anzeigen …" on panel heading
    $("#listView").on("click", ".panel-heading", function() {
        // NEXT Find Specific Area to Toggle
        $(this).parent().find(".componentOverview").slideToggle("slow", function(event) {
            fmApp.heatmap.reinit();
        });
        $(this).find(".listMoreInfo").toggleClass("showMore");
    });

    // Toggle compnentWheel
    $("#componentWheel").click(function() {
        var compnentWheelContainer = $("#compnentWheelContainer");
        compnentWheelContainer.toggleClass("showComponentWheel");
        if (compnentWheelContainer.hasClass("showComponentWheel")) {
            compnentWheelContainer.fadeIn(function(event) {
                drawCompnentWheel();
            });
        } else {
            compnentWheelContainer.fadeOut();
        }
    });

    // Handle hints
    $("#usageAlert").fadeTo(10000, 500).slideUp(500, function() {
        $("#usageAlert").slideUp(500);
    });

});
