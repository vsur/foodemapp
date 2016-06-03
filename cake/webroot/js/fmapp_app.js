/*
 * This is fmapp data script
 */

var fmApp = {
  init: function(params) {
     // ...do something
  },
  currentComponent: "",
  chosenSelection: [],
  checkInput: function() {
    var inputValue = $("#componentInput").val();
    if(inputValue !== "") {
      this.addComponent();
    } else {
      this.showInputError();
    }

  },
  showInputError: function() {
    // $('#componentInput').attr('placeholder', 'Kategorie wählen!').addClass('noChoice').delay(2000).removeClass('noChoice');
    $("#componentInput").attr('placeholder', 'Kategorie wählen!').toggleClass("noChoice");
    setTimeout(function(){ $("#componentInput").toggleClass("noChoice"); }, 2000);
  },
  addComponent: function() {
    var chosenComponent = $("#componentInput").val();
    $("#componentInput").val("").attr('placeholder', '').toggleClass("chosen");
    setTimeout(function() {
      $("#componentInput").attr('placeholder', 'Weitere wählen').toggleClass("chosen");
    }, 2000);
    // Prepend choosen component
    // this.chosenSelection.push(chosenComponent);
    this.chosenSelection.push(
      {
        'componentName': chosenComponent,
        'config': {},
        'gauge':  {},
        'weight': 0.0
      }
    );
    this.currentComponent = '<p id="' + chosenComponent + '">' + chosenComponent + ' <a title="Diese Katrgorie löschen" class="throwComponent"><span class="glyphicon glyphicon-minus-sign text-danger" aria-hidden="true"></span></a></p>';
    $("#componentChoice").append(this.currentComponent);
    $(".throwComponent").click(function() {
      var componentToDelete = $(this).parent().attr("id");
      $(this).parent().remove();
      fmApp.deleteComponent(componentToDelete);
    });
    // Base for Gauge <svg id="fillgauge1" width="25%" height="250" onclick="gauge1.update(NewValue());"></svg>
    var newGaugeSize = 250/3;
    var newGauge = '<svg id="' + chosenComponent + 'Gauge" class="gaugeValue"' +
      // Höhe stimmt noch nicht und muss auch nach Paste angepasst werden.
      'width="' + newGaugeSize + '" height="' + newGaugeSize + '"></svg>';
    $("#componentOutput").append(newGauge);
    var gaugeObj = this.chosenSelection[this.chosenSelection.length -1];
    gaugeObj.config = liquidFillGaugeDefaultSettings();
    gaugeObj.config.circleColor = "#c2005d";
    gaugeObj.config.textColor = "#7d003c";
    gaugeObj.config.waveTextColor = "#c2005d";
    gaugeObj.config.waveColor = "#7d003c";
    gaugeObj.gauge = loadLiquidFillGauge(chosenComponent + "Gauge", 100, gaugeObj.config);
    var d3Obj = d3.select("svg#" + chosenComponent + "Gauge");
    d3Obj.on('click', function () {
      yPos = d3.mouse(this)[1];
      var objHeight = d3Obj.attr('height');
      var newGaugeValue = Math.round( (objHeight - yPos) / objHeight * 100 );
      gaugeObj.weight = newGaugeValue;
      gaugeObj.gauge.update(gaugeObj.weight);
    });
    // TODO: Set right width for all gauges when addin new
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
   * There are three diferent alert state by Bootstrap
   * sucess | info | warning | danger
   */
  alertMessage: function(alertText, alertState) {
    console.log(alertState);
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
    $("#componentOutput").prepend(alertBoxString);
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
});
