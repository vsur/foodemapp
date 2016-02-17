<?php
  require_once 'data.php';
  require_once 'control_functions.php';

  class classTest {

    public $pois = array();
    public $pids = array();
    public $gSearchURL = "https://maps.googleapis.com/maps/api/place/radarsearch/json?location=";

    public function radarOneType($queryData, $typenr = 0, $doDebug = null) {
      // String for request
      $this->gSearchURL .= $queryData->{'geometry'}->{'location'}->{'lat'} . "," . $queryData->{'geometry'}->{'location'}->{'lng'} .
      "&radius=1500" .
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

      //ControlFunctions::formatResultArray($fpois);

      ControlFunctions::forDebug($fpois, "Gefilterte Pois");


    }
  }

  $data = new googleData();
  $app = new classTest();

  $app->radarOneType($data->phpQueryObj);

/*
  function radarOneType($data->jRobj, $typenr = 0, $doDebug = null) {
    global $pois;
    global $pids;
    global $gSearchURL;
    // String for request
    $gSearchURL = "https://maps.googleapis.com/maps/api/place/radarsearch/json?location=" .
    $jRobj->{'geometry'}->{'location'}->{'lat'} . "," . $jRobj->{'geometry'}->{'location'}->{'lng'} .
    "&radius=1500" .
    "&types=" . $jRobj->{'types'}[$typenr];
    $gSearchURL = addAPIkey($gSearchURL);

    $info = json_decode( file_get_contents($gSearchURL) );

    foreach($info->results as $poi) {
      $array =  (array) $poi;
      array_push($pois, $poi);
    }

    // TODO: Check if Next Page is present at all!

    echo "<h2>";
    echo "Radar Anfrage für <span style=\"color: blue;\">" . $jRobj->{'types'}[$typenr] . "</span> Query " . $gSearchURL . "\n";
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
    if($doDebug) {
      forDebug($fpois);
    }
  }
  */
?>
