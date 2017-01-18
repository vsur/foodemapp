<?php
  require_once 'data.php';
  require_once 'control_functions.php';
  require_once 'data_base.php';

  $data = new yelpData;
  $db = new DataBase();
  $cfunc = new ControlFunctions();

  class SaveData {
    public $pois = array();
    public $pids = array();

    public function getYelpData($fileToItterateOver) {
      global $data;
      global $cfunc;
      // Handle Öffnen
      $handle = $data->getHandle($fileToItterateOver);
      $lines = 0;
      while (($line = fgets($handle)) !== false) {
        $currentObjectLine = json_decode($line);
        $currentCategories = $currentObjectLine->categories;
        // Test
        if($lines == 500) {
          $cfunc->forDebug($currentObjectLine, "Aktueller Zeile 500");
        }
        // Check if line has needed category
        foreach ($currentCategories as $category) {
          if(in_array($category, $data->acceptedBinaryCategories)) {
            // Check if poi exits and create it if neccessary
            $this->poiInstanceCheck($currentObjectLine);

            $currentPoiNameId = $this->pois[$currentObjectLine->name . "_" . $currentObjectLine->business_id];
            // Check if category allready exits and create it if neccessary
            $this->poisCategoriesInstanceCheck($currentPoiNameId);

            // Add category if it doesn't exist already
            if(!in_array($category, $currentPoiNameId->foundBinaryCategories)) {
              array_push($currentPoiNameId->foundBinaryCategories, $category);
            }
          }
        }

        $currentAttributes = $currentObjectLine->attributes;
        // Check attributes of line
        foreach ($currentAttributes as $attrName => $attribute)  {
          // Check if attribute is binary category
          if(in_array($attrName, $data->acceptedBinaryCategories)) {
            // Check if poi exits and create it if neccessary
            $this->poiInstanceCheck($currentObjectLine);

            $currentPoiNameId = $this->pois[$currentObjectLine->name . "_" . $currentObjectLine->business_id];
            // Check if category allready exits and create it if neccessary
            $this->poisCategoriesInstanceCheck($currentPoiNameId);

            // Add Attribute to categories if it doesn't exist already
            if(!in_array($attrName, $currentPoiNameId->foundBinaryCategories)) {
              array_push($currentPoiNameId->foundBinaryCategories, $category);
            }
          }
        }

        $lines++;
      }
      fclose($handle);
      echo $cfunc->tagIt("p", "<strong>Alle Daten durchlaufen, " . $lines . " geprüft, " . count($this->pois) . " gefunden Orte gefunden</strong>");
    }

    private function poiInstanceCheck($currentObjectLine) {
      if(!in_array($currentObjectLine->business_id, $this->pids)) {
        array_push($this->pids, $currentObjectLine->business_id);
        $this->pois[$currentObjectLine->name . "_" . $currentObjectLine->business_id] = $currentObjectLine;
      }
    }
    private function poisCategoriesInstanceCheck($currentPoiNameId) {
      if(!isset($currentPoiNameId->foundBinaryCategories)) {
        $currentPoiNameId->foundBinaryCategories = [];
      }
    }

    public function saveCategoriesToDB() {
      global $secKeys;
      global $db;
      global $data;
      global $cfunc;

      echo $cfunc->tagIt("p", "<strong>Starte Speicherung der Kategorie-Daten " . date("\a\m d.m.Y \u\m H:i:s"));

      try {
        $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
        // Add binary categories to db
        foreach ($data->acceptedBinaryCategories as $categoryToSave) {
          $now = date("Y-m-d H:i:s");
          $sql = "INSERT INTO binary_components (created, modified, name) VALUES (:tstamp, :tstamp, :name)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $categoryToSave
          );
          $db->fire($sql, $para);
        }
        // Add nominal categories to db
        foreach ($data->acceptedNominalCategories as $nominalToSave) {
          $now = date("Y-m-d H:i:s");
          $sql = "INSERT INTO nominal_components (created, modified, name) VALUES (:tstamp, :tstamp, :name)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $nominalToSave
          );
          $db->fire($sql, $para);
        }
        // Add ordinal categories to db
        foreach ($data->acceptedOrdinalCategories as $ordinalToSave) {
          $now = date("Y-m-d H:i:s");
          $sql = "INSERT INTO ordinal_components (created, modified, name) VALUES (:tstamp, :tstamp, :name)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $ordinalToSave
          );
          $db->fire($sql, $para);
        }

        $db->close();
        echo $cfunc->tagIt("p", "<strong>Eintragen des Kategoriesettings erfolgreich abgeschlossen " . date("\a\m d.m.Y \u\m H:i:s"));
      } catch(Exception $e) {
        die('Fehler bei Anlegen des Settings: ' . $e->getMessage());
      }
    }

    public function saveDataToDB($filterdYelpData) {
      global $secKeys;
      global $db;
      global $data;
      global $cfunc;

      echo $cfunc->tagIt("p", "<strong>Starte Speicherung der Daten " . date("\a\m d.m.Y \u\m H:i:s"));

      // for ($i = 0; $i < 5; $i++) {
      for ($i = 0; $i < count($pois); $i++) {
        $now = date("Y-m-d H:i:s");
        echo $cfunc->forDebug($pois[$i], "Ein Eintrag");
        die("Hier erst mal Stop.");
        try {
          $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
          $sql = "INSERT INTO ypois (created, modified, name, lat, lng, google_place, icon, rating, vicinity) VALUES (:tstamp, :tstamp, :name, :lat, :lng, :google_place, :icon, :rating, :vicinity)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $pois[$i]->name,
            'lat'           =>       $pois[$i]->geometry->location->lat,
            'lng'           =>       $pois[$i]->geometry->location->lng,
            'google_place'  =>       $pois[$i]->place_id,
            'icon'          =>       $pois[$i]->icon,
            'rating'        =>       (isset($pois[$i]->rating)) ? $pois[$i]->rating : null,
            'vicinity'      =>       $pois[$i]->vicinity
          );
          $db->fire($sql, $para);
          $lastPoisId = $db->lastInsertId();
          echo ControlFunctions::tagIt("h1",
            "Letzter Eintrag: " . $lastPoisId
          );
          foreach ($filterdYelpData[$i]->types as $tag) {
            $tagId = null;
            // Check if tag is already present
            $sql = "SELECT EXISTS(SELECT 1 FROM tags WHERE title LIKE '%" . $tag . "%')";
            $rows = $db->fire($sql);
            $tagPresent = ( current(current($rows)) == "1") ? true : false;
            ControlFunctions::forDebug($rows, "Ausgabe für Tag $tag");
            echo ($tagPresent) ? "Wert für $tag ist: vorhanden" : "Wert für $tag ist: Nicht existent!";
            if($tagPresent) {
              $sql = "SELECT id FROM tags WHERE title LIKE '%" . $tag . "%'";
              $rows = $db->fire($sql);
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
              $db->fire($sql, $para);
              // Save ID
              $tagId = $db->lastInsertId();
            }
            // Paste Relation
            $sql = "INSERT INTO pois_tags (poi_id, tag_id) VALUES (:poi_id, :tag_id)";
            $para = array(
              'poi_id'  => $lastPoisId,
              'tag_id' => $tagId
            );
            $db->fire($sql, $para);
            echo ControlFunctions::tagIt("h1",
            "Letzter Eintrag: " . $db->lastInsertId()
          );
          }
          $db->close();
        } catch(Exception $e) {
          die('Fehler bei Datenspeicherung Fehler: ' . $e->getMessage());
        }

      }
    }

  }

  $app = new SaveData();

  $app->getYelpData("../data/yelp_karlsruhe_businesses");
  // $app->saveCategoriesToDB();
  $app->saveDataToDB($app->pois);


?>
