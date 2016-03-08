<?php
  require_once 'data.php';
  require_once 'control_functions.php';
  require_once 'data_base.php';

  class SaveData {
    public $pois = array();
    public $pids = array();
    public $gSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=";

    public function dataTypes3Pages($queryData) {

      for ($i = 0; $i < count($queryData->{'types'}); $i++) {
      // for ($i = 0; $i < 1; $i++) {
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

        // Check if result contains next_page_token and try to get additional data

        if( isset($info->next_page_token) ) {
          $this->callAddToken($info->next_page_token);
        } else {
          echo ControlFunctions::tagIt("h4",
            "<p><span style=\"color: orange\">Just one result page</span>: No Next Page Token found at all!</p>"
          );
        }

      }

      $fpois = ControlFunctions::checkDuplicatePID($this->pois);
      echo ControlFunctions::tagIt("h3",
        "Gefilterte Einträge: <b>" . count($fpois) . "</b>"
      );

      $this->saveToDB($fpois);

    }

    public function callAddToken($nextPageToken) {
      $gAddSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken=" .
        $nextPageToken;
        $gAddSearchURL = addAPIkey($gAddSearchURL);
      // Wait 1 second, because next page token must be valid at google first!
      usleep(1000000);
      $addInfo = json_decode( file_get_contents($gAddSearchURL) );
      // Check if request with next_page_token result is OK
      if($addInfo->status != "INVALID_REQUEST") {
        // if not INVALID -> Save Data
        foreach($addInfo->results as $poi) {
          array_push($this->pois, $poi);
        }
        echo ControlFunctions::tagIt("h4",
          "<span style=\"font-family: monospace;\">Zusätzliche Suchergebnisseite <span style=\"color: green;\">gespeichert</span></span>"
        );
        // Check if another next_page_token is set
        if(isset($addInfo->next_page_token)) {
          echo ControlFunctions::tagIt("h4",
            "<span style=\"font-family: monospace;\"><span style=\"color: orange;\">Weiteren Next Page Token gefunden. Call again callAddToken()</span></span>"
          );
          $anotherNextPageToken = $addInfo->next_page_token;
          // unset($GLOBALS['addInfo']);
          $this->callAddToken($anotherNextPageToken);
        } else {
          echo ControlFunctions::tagIt("h4",
          "<span style=\"font-family: monospace;\"><span style=\"color: green\">Crawled all pages</span>: No Next Page Token left!</span>"
        );
        }
      } else {
        echo ControlFunctions::tagIt("h4",
          "<span style=\"font-family: monospace;\"><span style=\"color: red;\">Next Page Token not yet valid!</span> <span style=\"color: orange;\">Start recall callAddToken()</span></span>"
        );
        $this->callAddToken($nextPageToken);
      }
    }

    public function saveToDB($filterdQueryData) {
      global $secKeys;
      ControlFunctions::forDebug($filterdQueryData, "Gefilterte Pois");
      // for ($i = 0; $i < 5; $i++) {
      for ($i = 0; $i < count($filterdQueryData); $i++) {
        $now = date("Y-m-d H:i:s");
        try {
          DataBase::connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
          $sql = "INSERT INTO pois (created, modified, name, lat, lng, google_place, icon, rating, vicinity) VALUES (:tstamp, :tstamp, :name, :lat, :lng, :google_place, :icon, :rating, :vicinity)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $filterdQueryData[$i]->name,
            'lat'           =>       $filterdQueryData[$i]->geometry->location->lat,
            'lng'           =>       $filterdQueryData[$i]->geometry->location->lng,
            'google_place'  =>       $filterdQueryData[$i]->place_id,
            'icon'          =>       $filterdQueryData[$i]->icon,
            'rating'        =>       (isset($filterdQueryData[$i]->rating)) ? $filterdQueryData[$i]->rating : null,
            'vicinity'      =>       $filterdQueryData[$i]->vicinity
          );
          DataBase::fire($sql, $para);
          $lastPoisId = DataBase::lastInsertId();
          echo ControlFunctions::tagIt("h1",
            "Letzter Eintrag: " . $lastPoisId
          );
          foreach ($filterdQueryData[$i]->types as $tag) {
            $tagId = null;
            // Check if tag is already present
            $sql = "SELECT EXISTS(SELECT 1 FROM tags WHERE title LIKE '%" . $tag . "%')";
            $rows = DataBase::fire($sql);
            $tagPresent = ( current(current($rows)) == "1") ? true : false;
            ControlFunctions::forDebug($rows, "Ausgabe für Tag $tag");
            echo ($tagPresent) ? "Wert für $tag ist: vorhanden" : "Wert für $tag ist: Nicht existent!";
            if($tagPresent) {
              $sql = "SELECT id FROM tags WHERE title LIKE '%" . $tag . "%'";
              $rows = DataBase::fire($sql);
              $tagId = current(current($rows));
              ControlFunctions::forDebug($rows, "Ausgabe für Tag $tag, tag ID: ");
              echo ControlFunctions::tagIt("h1",
                "$tag ID: $tagId"
              );
            } else {
              // Paste Tag
              $sql = "INSERT INTO tags (title, created, modified) VALUES (:title, :tstamp, :tstamp)";
              $para = array(
                'title'  => $tag,
                'tstamp' => $now
              );
              DataBase::fire($sql, $para);
              // Save ID
              $tagId = DataBase::lastInsertId();
            }
            // Paste Relation
            $sql = "INSERT INTO pois_tags (poi_id, tag_id) VALUES (:poi_id, :tag_id)";
            $para = array(
              'poi_id'  => $lastPoisId,
              'tag_id' => $tagId
            );
            DataBase::fire($sql, $para);
            echo ControlFunctions::tagIt("h1",
            "Letzter Eintrag: " . DataBase::lastInsertId()
          );
          }
          DataBase::close();
        } catch(Exception $e) {
          die('Fehler bei .... Fehler: ' . $e->getMessage());
        }

      }
    }

  }

  $data = new googleData();
  $app = new SaveData();
  $db = new DataBase();

  $app->dataTypes3Pages($data->phpQueryObj);

?>
