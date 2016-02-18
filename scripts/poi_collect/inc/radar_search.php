<?php
  require_once 'data.php';
  require_once 'control_functions.php';

  class classTest {

    public $pois = array();
    public $pids = array();
    public $gSearchURL = "https://maps.googleapis.com/maps/api/place/radarsearch/json?location=";

    public function radarOneType($queryData, $typenr = 0) {
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

      ControlFunctions::formatResultArray($fpois);

      ControlFunctions::forDebug($fpois, "Gefilterte Pois");
    }

    function radarAllTypesConcat($queryData) {

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
          "Radar Anfrage für  1. Seite <span style=\"color: blue;\">" .  $queryData->{'types'}[$i] . "</span> Query " . $loopQuery
        );
        echo ControlFunctions::tagIt("h3",
          "Einträge: <b>" . count($info->results) . "</b>"
        );

        echo ControlFunctions::pasteSpacer("#");

      }

      echo ControlFunctions::tagIt("h2",
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

    function radarConcatTypesInOne($queryData, $doDebug = null) {
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
        "Radar Anfrage für meherere Types in einer Anfrage: <span style=\"color: blue;\">" .
        $queryData->{'types'}[0] . "|" .
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
  $app = new classTest();

  $app->radarConcatTypesInOne($data->phpQueryObj);

?>
