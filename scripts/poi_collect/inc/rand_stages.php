<?php
  require_once 'control_functions.php';
  require_once 'data_base.php';

  class RandStages {
    public $pois = array();
    public $components = array();
    public $stages = array();
    public $savedStagesCount = 0;

    public function getData($maxRandValues = 5) {
      global $secKeys;
      // Conect to DB an get the
      try {
        DataBase::connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
        // Get pois
        $sql = "SELECT * FROM pois";
        $this->pois = DataBase::fire($sql);
        // Get components
        $sql = "SELECT * FROM components";
        $this->components = DataBase::fire($sql);

        DataBase::close();
      } catch(Exception $e) {
        die('Fehler bei .... Fehler: ' . $e->getMessage());
      }
      $this->createRandStages($this->pois, $this->components, $maxRandValues);
      echo ControlFunctions::tagIt("h1",
      "Es wurden: " . $this->savedStagesCount . " Stages gespeichert"
    );
    }

    public function createRandStages($pois, $components, $maxStagesNr) {
        // Walk thru every poi
        // ControlFunctions::forDebug($pois, "Ausgabe für POIS");
        foreach ($pois as $poi ) {
          // Create a random set off stages for rand($maxStagesNr) number of components
          $randStagesNumber = rand(1, $maxStagesNr);
          for($i = 1; $i <= $randStagesNumber; $i++) {
            $randComponent = rand(0, (count($components) - 1) );
            $randStage = rand(0, 100) / 10;
            $this->saveToDB($poi['id'], $components[$randComponent]['id'], $randStage);
          }
        }
    }

    public function saveToDB($poiId, $componentId, $stageRating) {
      global $secKeys;
      $now = date("Y-m-d H:i:s");
      try {
        DataBase::connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
        $sql = "INSERT INTO stages (component_id, poi_id, created, modified, rating) VALUES (:component_id, :poi_id, :tstamp, :tstamp, :rating)";
        $para = array(
          'component_id'    =>       $componentId,
          'poi_id'          =>       $poiId,
          'tstamp'          =>       $now,
          'rating'          =>       $stageRating
        );
        DataBase::fire($sql, $para);
        $this->savedStagesCount = DataBase::lastInsertId();
        DataBase::close();
      } catch(Exception $e) {
        die('Fehler bei .... Fehler: ' . $e->getMessage());
      }
    }

  }

  $app = new RandStages();
  $db = new DataBase();

  $app->getData(8);

?>
