<?php
  include '../../../sec/givexml.php';
  $secKeys = getSecVars('../../../sec/');

  class googleData {

    // Data Var
    private $jsonR = '{
        "formatted_address" : "Regensburg, Deutschland",
        "geometry" : {
           "location" : {
              "lat" : 49.01340740000001,
              "lng" : 12.101631
           },
           "viewport" : {
              "northeast" : {
                 "lat" : 49.22328419999999,
                 "lng" : 12.4909978
              },
              "southwest" : {
                 "lat" : 48.7649053,
                 "lng" : 11.6591858
              }
           }
        },
        "icon" : "https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
        "name" : "Regensburg",
        "place_id" : "ChIJIWdnpCHBn0cRPLc80Q0Fk6E",
        "types" : [


                  "bakery",
                  "bar",
                  "cafe",
                  "casino",
                  "city_hall",
                  "convenience_store",
                  "department_store",
                  "establishment",
                  "food",
                  "gas_station",
                  "grocery_or_supermarket",
                  "liquor_store",
                  "meal_delivery",
                  "meal_takeaway",
                  "movie_theater",
                  "night_club",
                  "restaurant",
                  "rv_park",
                  "shopping_mall",
                  "spa",
                  "store",
                  "university"
                  ]
      }';

    // forDebug($jRobj->{'types'});
    public $jRobj;
    public $pois = array();
    public $pids = array();
    public $gSearchURL = "";
    function  __construct() { }
      $jRobj = json_decode($jsonR);
    }
  }

  /*
   *
   *  Control functions
   *
   */
  function checkDuplicatePID($farray) {
    global $pids;
    if( !in_array($farray->place_id, $pids)) {
      array_push($pids, $farray->place_id);
      return true;
    } else {
      return false;
    }
  }
  function callAddToken($nextPageToken) {
    global $pois;
    // echo "<p><b>NP Token: " . $nextPageToken . "</b></p>";
    $gAddSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken=" .
      $nextPageToken;
      $gAddSearchURL = addAPIkey($gAddSearchURL);
    // Wait 1 second, because next page token must be valid at google first!
    usleep(1000000);
    $addInfo = json_decode( file_get_contents($gAddSearchURL) );
    if($addInfo->status != "INVALID_REQUEST") {
      foreach($addInfo->results as $poi) {
        $array =  (array) $poi;
        array_push($pois, $poi);
      }
    } else {
      usleep(500000);
      $addInfo = json_decode( file_get_contents($gAddSearchURL) );
      foreach($addInfo->results as $poi) {
        $array =  (array) $poi;
        array_push($pois, $poi);
      }
    }

    if(isset($addInfo->next_page_token)) {
      $nextToken = $addInfo->next_page_token;
      unset($GLOBALS['addInfo']);
      callAddToken($nextToken);

    } else {
      echo '<p><span style="color: green">Crawled all pages</span>: No Next Page Token left!</p>';
    }
  }
  function formatResult($data) {
    echo '<h1 style="font-weight: bold;">Datenausgabe</h1>';
    foreach($data as $poi) {
      echo "<p>";
      echo "<b>" . $poi->name . "</b>, " . $poi->vicinity;
      echo "<br />";
      echo "place_id: " .$poi->place_id . ", lat: " .  $poi->geometry->location->lat . ", lng: " .  $poi->geometry->location->lat;
      echo "<br />";
      echo "types: " . implode(", ", $poi->types);
      echo "</p>";
    }
  }
  function addAPIkey($urlString) {
    global $secKeys;
    $urlString .= "&key=" . $secKeys->{'gSerAPI'};
    return $urlString;
  }
  function forDebug($a) {
      echo "<pre>";
      echo print_r($a);
      echo "</pre>";
  }

?>
