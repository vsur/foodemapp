<?php
  require_once 'data.php';
  require_once 'control_functions.php';

  class NearbySearch {
    public $pois = array();
    public $pids = array();
    public $gSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=";

    public function nearbyAllTypesFirstPage($queryData, $doDebug = null) {

      for ($i = 0; $i < count($queryData->{'types'}); $i++) {
        // String for request
        $loopQuery = $this->gSearchURL;
        $loopQuery .= $queryData->{'geometry'}->{'location'}->{'lat'} . "," . $queryData->{'geometry'}->{'location'}->{'lng'} .
        "&radius=1500" .
        "&types=" . $queryData->{'types'}[$i];
        $loopQuery = ControlFunctions::addAPIkey($loopQuery);

        $info = json_decode( file_get_contents($loopQuery) );

        foreach($info->results as $poi) {
          // $array =  (array) $poi;
          array_push($this->pois, $poi);
        }

        echo ControlFunctions::tagIt("h2",
          "<span style=\"font-family: monospace;\">radarAllTypesConcat()</span><br />" .
          "Nearby Anfrage für 1. Seite <span style=\"color: blue;\">" .  $queryData->{'types'}[$i] . "</span> Query " . $loopQuery
        );
        echo ControlFunctions::tagIt("h3",
          "Einträge: <b>" . count($info->results) . "</b>"
        );

        echo ControlFunctions::pasteSpacer("###  Next ###");

      }

      echo ControlFunctions::tagIt("h2",
        "<span style=\"font-family: monospace;\">nearbyAllTypesFirstPage()</span><br />" .
        "Radar Anfrage für <span style=\"color: blue;\">All Types</span>-Query "
      );
      echo ControlFunctions::tagIt("h3",
        "Einträge: <b>" . count($this->pois) . "</b>"
      );
      $fpois = ControlFunctions::checkDuplicatePID($this->pois);
      echo ControlFunctions::tagIt("h3",
        "Gefilterte Einträge: <b>" . count($fpois) . "</b>"
      );

      ControlFunctions::formatResultArray($fpois);

      ControlFunctions::forDebug($fpois, "Gefilterte Pois");

    }

  }

  $data = new googleData();
  $app = new NearbySearch();

  $app->nearbyAllTypesFirstPage($data->phpQueryObj);

  /*
   *
   *  Initiate Action Functions
   *
   */


  function nearbyAllPagesOneType($jRobj, $typenr = 0, $doDebug = null) {
    global $pois;
    global $pids;
    global $gSearchURL;
    // String for request
    $gSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" .
    $jRobj->{'geometry'}->{'location'}->{'lat'} . "," . $jRobj->{'geometry'}->{'location'}->{'lng'} .
    "&radius=1500" .
    "&types=" . $jRobj->{'types'}[$typenr];
    $gSearchURL = addAPIkey($gSearchURL);

    $info = json_decode( file_get_contents($gSearchURL) );

    foreach($info->results as $poi) {
      $array =  (array) $poi;
      array_push($pois, $poi);
    }
    if($info->next_page_token) {
      callAddToken($info->next_page_token);
    } else {
      echo '<p><span style="color: orange">Just one result page</span>: No Next Page Token found at all!</p>';
    }
    echo "<h2>";
    echo "Anfrage Query " . $gSearchURL . "\n";
    echo "</h2>";
    echo "<h3>";
    echo "Einträge: <b>" . count($pois) . "</b>\n";
    echo "</h3>";
    $fpois = array_filter($pois, "checkDuplicatePID");
    echo "<h3>";
    echo "Gefilterte Einträge: <b>" . count($fpois) . "</b>\n";
    echo "</h3>";

    /*
    formatResult($fpois);
    */
    if($doDebug) {
      forDebug($fpois);
    }
  }


  /*
   *
   *  Call functions
   *
   */
   // nearbyAllTypesFirstPage($jRobj, true);
   // nearbyAllPagesOneType($jRobj, 0, true);
   // radarOneType($jRobj, 0, true);
  //  radarAllTypesConcat($jRobj);
  // radarConcatTypesInOne($jRobj);

  /*
   *
   *  Control functions
   *

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
  */
?>
