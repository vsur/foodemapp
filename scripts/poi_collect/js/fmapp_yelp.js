var foundCities = {};
var foundCategories = {};

$(document).ready(function() {
  // getDataFromJSON('yelp_academic_dataset_business.json');
  getDataFromJSON('smalltest.json');
});

function getDataFromJSON(jsonFileName) {
  console.log("Name ist: " + jsonFileName);
  var dumper;
  var now = new Date();
  $.getJSON( "data/" + jsonFileName, function(data) {
    console.log( "Success from $getJSON " + now.getHours() + ":" + now.getMinutes() + ":" + now.getMilliseconds() );
    console.log(data);
  })
  .fail(function(jqxhr, textStatus, error) {
    console.log( "Error from $getJSON " + now.getHours() + ":" + now.getMinutes() + ":" + now.getMilliseconds() );
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );

  });
  console.log(phpParsedJSON);
}
