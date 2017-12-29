/*
 * This is fmapp beta data script
 */

var fmApp = {
  init: function(params) {
     // … do something
  },
  standardRating: 2, // Out of 3
  currentComponent: "",
  chosenSelection: [],
  checkInput: function() {
    var inputValue = $("#criteriaInput").val();
    if(inputValue !== "") {
      this.addComponent();
    } else {
      this.showInputError();
    }

  },
  showInputError: function() {
    // $('#criteriaInput').attr('placeholder', 'Kategorie wählen!').addClass('noChoice').delay(2000).removeClass('noChoice');
    $("#criteriaInput").attr('placeholder', 'Kategorie wählen!').toggleClass("noChoice");
    setTimeout(function(){ $("#criteriaInput").toggleClass("noChoice"); }, 2000);
  },
  addComponent: function() {
    var inputValue = $("#criteriaInput").val();
    var chosenComponent;
    var selectedCriterion = {
      index   :   inputValue.slice(inputValue.indexOf("#") + 1),
      type    :   inputValue.slice(0,2),
      id      :   inputValue.slice(inputValue.indexOf(".") + 1, inputValue.indexOf("#"))
    };
    if(this.checkDataMatching(selectedCriterion)) {
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
    this.chosenSelection.push(
      {
        'componentName'   :       chosenComponent.display_name,
        'componentType'   :       chosenComponent.modelType,
        'componentId'     :       chosenComponent.id,
        'rating'          :       this.standardRating,
        'binaryState'     :       true,
        'nominalAttribute':       null,
        'ordinalAttribute':       null
      }
    );
    // Prepend choosen component
    this.currentComponent = '<p id="criteriaList#' + chosenComponent.modelType + "." + chosenComponent.id + '">' + chosenComponent.display_name + ' <a title="Diese Kategorie löschen" class="throwComponent"><span class="glyphicon glyphicon-minus-sign text-danger" aria-hidden="true"></span></a></p>';
    $("#criteriaChoice").append(this.currentComponent);
    $(".throwComponent").click(function() {
      var componentToDelete = $(this).parent().attr("id");
      $(this).parent().remove();
      fmApp.deleteComponent(componentToDelete);
    });
    var labelRow = "";
    if(this.chosenSelection.length <= 1) {
      // Add labels to areas

      labelRow += '<div class="row hidden-sm hidden-xs">';
      labelRow +=   '<div class="col-md-6">';
      labelRow +=     '<label class="text-info">Kategorien einstellen</label>';
      labelRow +=   '</div>';
      labelRow +=   '<div class="col-md-6">';
      labelRow +=     '<label class="text-info">Gewichtung einstellen</label>';
      labelRow +=   '</div>';
      labelRow += '</div>';
    }
    var chosenComponentToPaste = "";
    var chosenComponentToPasteRating = "";

    chosenComponentToPaste        +=  '<div id="criteriaOptions#' + chosenComponent.modelType + "." + chosenComponent.id + '" class="row">';
    chosenComponentToPaste        +=    '<div class="col-md-6">';
    chosenComponentToPaste        +=      chosenComponent.display_name;
    chosenComponentToPaste        +=    '</div>';

    chosenComponentToPasteRating  +=    '<div class="col-md-6">';
    chosenComponentToPasteRating  +=      'Rating = ' + this.getRating(chosenComponent.modelType, chosenComponent.id);
    chosenComponentToPasteRating  +=     '</div>';
    chosenComponentToPasteRating  +=  '</div>';

    $("#criteriaOutput").append(labelRow + chosenComponentToPaste + chosenComponentToPasteRating);
  },
  checkDataMatching: function(criterionToCheck) {
    var machtingCorrect = true;
    // Check names
    if( criterionNames[criterionToCheck.index][0].search(criteria[criterionToCheck.index].display_name) < 0 ) {
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
    if(typeToCheck != criteria[criterionToCheck.index].modelType) {
      machtingCorrect = false;
    }
    // Check ids
    if(criterionToCheck.id != criteria[criterionToCheck.index].id) {
      machtingCorrect = false;
    }
    return machtingCorrect;
  },
  deleteComponent: function(delName) {
    $("#" + delName ).remove();
    $("#" + delName + "Gauge" ).remove();
    var i = this.chosenSelection.indexOf(delName);
    this.chosenSelection.splice( i, 1 );
    console.log("Eintrag aus Array gelöscht");
    console.log("Noch Einträge:  " + this.chosenSelection.length);
    console.log(this.chosenSelection);

  },
  getRating: function(modelType, id) {
    var selectionIndex;
    for(var i = 0; i < this.chosenSelection.length; i++) {
      if(this.chosenSelection[i].componentType == modelType && this.chosenSelection[i].componentId == id) {
        selectionIndex = i;
      } else {
        selectionIndex = undefined;
      }
    }
    var rating = this.chosenSelection[selectionIndex].rating;
    return rating;
  },
  updateGauge: function(clickedGauge) {
    var j;
    for(var i = 0; i < this.chosenSelection.length; i++) {
      j = this.chosenSelection[i].componentName == clickedGauge ? i : undefined;
    }
    var gaugeObj = this.chosenSelection[j];
    gaugeObj.gauge.update(50);
  },
  comparePois: function() {
    var paramString = "?";
    for(var i = 0; i < this.chosenSelection.length; i++) {
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
    if(alertState === undefined) {
      alertState = "alert-info";
    }
    // Clean alertState from former message
    if(alertText === undefined) {
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

$( document ).ready(function() {
  // Function for selection
  window.addEventListener("awesomplete-select", function(e){
    // User types somethin and a select is made.
    // Therefor action button shall apear,
    $("#chooseAction").slideDown("fast");
  }, false);
  // Function for adding a component
  window.addEventListener("awesomplete-selectcomplete", function(e){
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
  $("#showAllCriteria").css("cursor", "pointer").click(function(){
    $("#criteriaListView").fadeToggle(1500, function(){
      $("#compnentListDisplayState").fadeOut(500, function(){
        if(listDisplayState) {
          $(this).text("ausblenden ↑").fadeIn(500);
        } else {
          $(this).text("einblenden ↓").fadeIn(500);
        }
        listDisplayState = !listDisplayState;
      });
    });
  });
});
