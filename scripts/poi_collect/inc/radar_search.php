<?php
  require_once 'data.php';
  require_once 'control_functions.php';

  class RadarSearch {

    public $pois = array();
    public $pids = array();
    public $gSearchURL = "https://maps.googleapis.com/maps/api/place/radarsearch/json?location=";

    public function radarOneType($queryData, $typenr = 0) {
      // String for request
      // $this->gSearchURL .= $queryData->{'geometry'}->{'location'}->{'lat'} . "," . $queryData->{'geometry'}->{'location'}->{'lng'} .
      $this->gSearchURL .= "49.018386,12.095228" .
      "&radius=200" .
      "&types=" . $queryData->{'types'}[$typenr];
      $this->gSearchURL = ControlFunctions::addAPIkey($this->gSearchURL);

      $info = json_decode( file_get_contents($this->gSearchURL) );

      foreach($info->results as $poi) {
        array_push($this->pois, $poi);
      }

      echo ControlFunctions::tagIt("h2",
        "Radar Anfrage für <span style=\"color: blue;\">" . $queryData->{'types'}[$typenr] . "</span> Query " . $this->gSearchURL
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

    function radarAllTypesIteration($queryData) {

      for ($i = 0; $i < count($queryData->{'types'}); $i++) {
        // String for request
        $loopQuery = $this->gSearchURL;
        $loopQuery .= $queryData->{'geometry'}->{'location'}->{'lat'} . "," . $queryData->{'geometry'}->{'location'}->{'lng'} .
        "&radius=3000" .
        "&types=" . $queryData->{'types'}[$i];
        $loopQuery = ControlFunctions::addAPIkey($loopQuery);

        $info = json_decode( file_get_contents($loopQuery) );

        foreach($info->results as $poi) {
          // $array =  (array) $poi;
          array_push($this->pois, $poi);
        }

        echo ControlFunctions::tagIt("h2",
          "<span style=\"font-family: monospace;\">radarAllTypesIteration()</span><br />" .
          "Radar Anfrage für  1. <span style=\"color: blue;\">" .  $queryData->{'types'}[$i] . "</span> Query " . $loopQuery
        );
        echo ControlFunctions::tagIt("h3",
          "Einträge: <b>" . count($info->results) . "</b>"
        );

        echo ControlFunctions::pasteSpacer("#");

      }

      echo ControlFunctions::tagIt("h2",
        "<span style=\"font-family: monospace;\">radarAllTypesConcat()</span><br />" .
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

    public function radarConcatTypesInOne($queryData) {
      // String for request
      $this->gSearchURL .= $queryData->{'geometry'}->{'location'}->{'lat'} . "," . $queryData->{'geometry'}->{'location'}->{'lng'} .
      "&radius=1500" .
      "&types=" .
      $queryData->{'types'}[0] . "|" .
      $queryData->{'types'}[8] . "|" .
      $queryData->{'types'}[12] . "|" .
      $queryData->{'types'}[13] . "|" .
      $queryData->{'types'}[16] . "|";
      $this->gSearchURL = addAPIkey($this->gSearchURL);

      $info = json_decode( file_get_contents($this->gSearchURL) );

      foreach($info->results as $poi) {
        array_push($this->pois, $poi);
      }

      echo ControlFunctions::tagIt("h2",
        "<span style=\"font-family: monospace;\">radarConcatTypesInOne()</span><br />" .
        "Radar Anfrage für meherere Types in einer Anfrage: <span style=\"color: blue;\">" .
        $queryData->{'types'}[0] . ", " .
        $queryData->{'types'}[8] . ", " .
        $queryData->{'types'}[12] . ", " .
        $queryData->{'types'}[13] . ", " .
        $queryData->{'types'}[16] .
        ", " . "</span> Query " . $this->gSearchURL
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
  $app = new RadarSearch();

  $app->radarOneType($data->phpQueryObj, 16);

  // TODO: radar with Iteration over Details
  // TODO: radar with 500 m matrix

  /*
   *
   *  Notes
   *
   *  !!! Important !!! Do not mess around anymore with getting more data! Get your 900 or 500 in a Database and start you Prototype! 
   *
   *  Get more Results for types: restaurant, store, establishment, food
   *  For inner circle Old Town RGB you get 199 food results by radius=500
   *  https://maps.googleapis.com/maps/api/place/radarsearch/json?location=49.018386,12.095228&radius=500&types=food&key=AIzaSyBXpO58KiugJQ3rIwf8lbkNlz-Ar4l33wA
   *
   *  To get less than 60 (3 result pages for nearby query) you need to decreade the radius to 200
   *  Query https://maps.googleapis.com/maps/api/place/radarsearch/json?location=49.018386,12.095228&radius=200&types=restaurant&key=AIzaSyBXpO58KiugJQ3rIwf8lbkNlz-Ar4l33wA
   *
   *  But on the other hand one has to start 675 queries to go over a matrix in a 6x6 km range other RGB in 400m (200m radius) steps to get it all
   *  The Thing is, that it needs to be cleared up if a detail search gets more sinvul information than a neabry search
   */

?>
