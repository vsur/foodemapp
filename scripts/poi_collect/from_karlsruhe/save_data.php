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
        /*
        if($lines == 500)  {
          $cfunc->forDebug($currentObjectLine, "Aktueller Zeile 500");
        }
        */
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

        // Check attributes of line
        $currentAttributes = $currentObjectLine->attributes;
        foreach ($currentAttributes as $attrName => $attribute)  {
          // Check if attribute is binary category
          if(in_array($attrName, $data->acceptedBinaryCategories)) {
            // Check if current attr is really set TRUE, otherwise do not copy data to foundBinaryCategories
            if($attribute == TRUE) {
              // Check if poi exits and create it if neccessary
              $this->poiInstanceCheck($currentObjectLine);

              $currentPoiNameId = $this->pois[$currentObjectLine->name . "_" . $currentObjectLine->business_id];
              // Check if category allready exits and create it if neccessary
              $this->poisCategoriesInstanceCheck($currentPoiNameId);

              // Add Attribute to categories if it doesn't exist already
              if(!in_array($attrName, $currentPoiNameId->foundBinaryCategories)) {
                array_push($currentPoiNameId->foundBinaryCategories, $attrName);
              }
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

      echo $cfunc->tagIt("p", "<strong>Starte Speicherung der Kategorie-Daten " . date("\a\m d.m.Y \u\m H:i:s") . "</strong>");

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

        // Add nominal categories and attributes to db
        foreach ($data->acceptedNominalCategories as $nominalToSave => $nominalAttributes) {
          $now = date("Y-m-d H:i:s");
          $sql = "INSERT INTO nominal_components (created, modified, name) VALUES (:tstamp, :tstamp, :name)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $nominalToSave
          );
          // Save nominal category in db
          $db->fire($sql, $para);
          $lastNominalId = $db->lastInsertId();
          // Get nominal attributes ready
          foreach ($nominalAttributes as $nominalAttrValue) {
            $sql = "INSERT INTO nominal_attributes (created, modified, nominal_component_id, name) VALUES (:tstamp, :tstamp, :nominal_component_id, :name)";
            $para = array(
              'tstamp'                =>       $now,
              'nominal_component_id'  =>       $lastNominalId,
              'name'                  =>       $nominalAttrValue
            );
            // Save nominals attribute in db
            $db->fire($sql, $para);
          }
        }
        // Add ordinal categories to db
        foreach ($data->acceptedOrdinalCategories as $ordinalToSave => $ordinalAttributes) {
          if ($ordinalToSave != "Distance") {
            $now = date("Y-m-d H:i:s");
            $sql = "INSERT INTO ordinal_components (created, modified, name) VALUES (:tstamp, :tstamp, :name)";
            $para = array(
              'tstamp'        =>       $now,
              'name'          =>       $ordinalToSave
            );
            // Save ordinal category in db
            $db->fire($sql, $para);
            $lastOrdinalId = $db->lastInsertId();
            // Get nominal attributes ready
            foreach ($ordinalAttributes as $ordinalAttrName => $ordinalAttrValue) {
              $sql = "INSERT INTO ordinal_attributes (created, modified, ordinal_component_id, name, display_name, meter) VALUES (:tstamp, :tstamp, :ordinal_component_id, :name, :display_name, :meter)";
              $para = array(
                  'tstamp'                =>       $now,
                  'ordinal_component_id'  =>       $lastOrdinalId,
                  'name'                  =>       $ordinalAttrName,
                  'display_name'          =>       $ordinalAttrValue["display_name"],
                  'meter'                 =>       $ordinalAttrValue["meter"]
              );
              // Save ordinal attribute in db
              $db->fire($sql, $para);
            }
          }
        }

        $db->close();
        echo $cfunc->tagIt("p", "<strong>Eintragen des Kategoriesettings erfolgreich abgeschlossen " . date("\a\m d.m.Y \u\m H:i:s") . "</strong>");
      } catch(Exception $e) {
        die('Fehler bei Anlegen des Settings: ' . $e->getMessage());
      }
    }

    public function clearDB($tablesToClear) {
      global $secKeys;
      global $db;
      global $data;
      global $cfunc;
      echo $cfunc->tagIt("p", "<strong>Starte Leeren der Datenbank " . date("\a\m d.m.Y \u\m H:i:s") . "</strong>");
      foreach ($tablesToClear as $table) {
        try {
          $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
          $sql = "TRUNCATE " . $table;
          $db->fire($sql);
          echo $cfunc->tagIt("p", "Leeren der Tabelle  <strong>" . $table . "</strong> erfolgreich");
          $db->close();
        } catch(Exception $e) {
          die('Fehler beim Löschen der Tabelle ' . $table . ':' . $e->getMessage());
        }
      }
      echo $cfunc->tagIt("p", "<strong>Leeren der Datenbank " . date("\a\m d.m.Y \u\m H:i:s") . " beendet</strong>");
    }

    public function saveDataToDB($filterdYelpData) {
      global $secKeys;
      global $db;
      global $data;
      global $cfunc;

      echo $cfunc->tagIt("p", "<strong>Starte Speicherung der Daten " . date("\a\m d.m.Y \u\m H:i:s") . "</strong>");
      // for ($i = 0; $i < 5; $i++) {
      foreach ($this->pois as $singlePoi) {
        $now = date("Y-m-d H:i:s");
        try {
          $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
          $sql = "INSERT INTO ypois (created, modified, name, lat, lng, businessid, city, state, full_address, stars, review_count) VALUES (:tstamp, :tstamp, :name, :lat, :lng, :businessid, :city, :state, :full_address, :stars, :review_count)";
          $para = array(
            'tstamp'        =>       $now,
            'name'          =>       $singlePoi->name,
            'lat'           =>       $singlePoi->latitude,
            'lng'           =>       $singlePoi->longitude,
            'businessid'   =>       $singlePoi->business_id,
            'city'          =>       $singlePoi->city,
            'state'         =>       $singlePoi->state,
            // 'state'        =>       (isset($singlePoi->rating)) ? $singlePoi->rating : null,
            'full_address'  =>       $singlePoi->full_address,
            'stars'         =>       $singlePoi->stars,
            'review_count'  =>       $singlePoi->review_count,
          );
          $db->fire($sql, $para);
          $lastPoisId = $db->lastInsertId();

          // Save binary categories
          for ($i=0; $i < count($singlePoi->foundBinaryCategories); $i++) {
            // Find binary_component_id
            $sql = "SELECT `id` FROM binary_components WHERE `name` LIKE '" . $singlePoi->foundBinaryCategories[$i] . "'";
            $rows = $db->fire($sql);
            $sql = "INSERT INTO binary_components_ypois (binary_component_id, ypoi_id, created, modified) VALUES (:binary_component_id, :ypoi_id, :tstamp, :tstamp)";
            $para = array(
              'binary_component_id'  => $rows[0]['id'],
              'ypoi_id' => $lastPoisId,
              'tstamp' => $now
            );
            $db->fire($sql, $para);
          }

          // Save nominal categories
          foreach ($singlePoi->attributes as $attributesName => $attributes)  {
            if (array_key_exists($attributesName, $data->acceptedNominalCategories)) {
              // Get nominal_components id
              $sql = "SELECT `id` FROM nominal_components WHERE `name` LIKE '" . $attributesName . "'";
              $rows = $db->fire($sql);
              $lastNominalId = $rows[0]['id'];

              // Check if aatribute is an Object
              if (is_object($attributes)) {
                foreach ($attributes as $attrName => $attrValue){
                  if ($attrValue == true){
                    // Get nominal_attributes id
                    $sql = "SELECT `id` FROM nominal_attributes WHERE `nominal_component_id` = " . $lastNominalId . " AND `name` LIKE '" . $attrName . "'";
                    $rows = $db->fire($sql);
                    $lastNominalAttrId = $rows[0]['id'];

                    // Save Join Entry in nominal_attributes_ypois
                    $sql = "INSERT INTO nominal_attributes_ypois (nominal_attribute_id, ypoi_id, created, modified) VALUES (:nominal_attribute_id, :ypoi_id, :tstamp, :tstamp)";
                    $para = array(
                      'nominal_attribute_id'  => $lastNominalAttrId,
                      'ypoi_id' => $lastPoisId,
                      'name' => $attrName,
                      'tstamp' => $now
                    );
                    $db->fire($sql, $para);
                  }
                }
              } else { // Current Attribute found in acceptedNominalCategories seems to be no object, probably string
                // Having only a string not an object the var $attrName needs to be reinstantiated
                $attrName = $attributes;
                // Get nominal_attributes id
                $sql = "SELECT `id` FROM nominal_attributes WHERE `nominal_component_id` = " . $lastNominalId . " AND `name` LIKE '" . $attrName . "'";
                $rows = $db->fire($sql);
                $lastNominalAttrId = $rows[0]['id'];

                // Save Join Entry in nominal_attributes_ypois
                $sql = "INSERT INTO nominal_attributes_ypois (nominal_attribute_id, ypoi_id, created, modified) VALUES (:nominal_attribute_id, :ypoi_id, :tstamp, :tstamp)";
                $para = array(
                  'nominal_attribute_id'  => $lastNominalAttrId,
                  'ypoi_id' => $lastPoisId,
                  'name' => $attrName,
                  'tstamp' => $now
                );
                $db->fire($sql, $para);
                // print_r("$attributesName als " . gettype($attributesName) . " => $attributes als " .  gettype($attributes) . " nicht gespeichert <br>");
                // print_r( gettype($attributes) . " nicht gespeichert <br>");
              }

            }

          	// Save ordinal categories
            if (array_key_exists($attributesName, $data->acceptedOrdinalCategories)) {
  						// Get ordinal_components id
  						$sql = "SELECT `id` FROM ordinal_components WHERE `name` LIKE '" . $attributesName . "'";
  						$rows = $db->fire($sql);
  						$lastOrdinalId = $rows[0]['id'];

  						/*
  						 * Get ordinal_attributes id and save join entry in ordinal_attributes_ypois
  						 */
  						// For objects-attributes that have more than one value
  						if (is_object($attributes)) {
  						  foreach ($attributes as $attrName => $attrValue){
  						    if ($attrValue == true) {
                    // Get ordinal_attributes id for attrValues attrName
  						      $sql = "SELECT `id` FROM ordinal_attributes WHERE `ordinal_component_id` = " . $lastOrdinalId . " AND `name` LIKE '" . $attrName . "'";
  						      $rows = $db->fire($sql);
  						      $lastOrdinalAttrId = $rows[0]['id'];

  						      // Save Join Entry in ordinal_attributes_ypois for objects attrs
  						      $sql = "INSERT INTO ordinal_attributes_ypois (ordinal_attribute_id, ypoi_id, created, modified) VALUES (:ordinal_attribute_id, :ypoi_id, :tstamp, :tstamp)";
  						      $para = array(
  						          'ordinal_attribute_id'  => $lastOrdinalAttrId,
  						          'ypoi_id' => $lastPoisId,
  						          'name' => $attrName,
  						          'tstamp' => $now
  						      );
  						      $db->fire($sql, $para);
  						    }
  						  }
  						} else {
  						  // Same for non object-attributes with single value
  						  $attributesName = $attributes;

                // Get ordinal_attributes id for attrValues attrName
  						  $sql = "SELECT `id` FROM ordinal_attributes WHERE `ordinal_component_id` = " . $lastOrdinalId . " AND `name` LIKE '" . $attributesName . "'";
  						  $rows = $db->fire($sql);
  						  $lastOrdinalAttrId = $rows[0]['id'];

  						  // Save Join Entry in ordinal_attributes_ypois for objects attrs
  						  $sql = "INSERT INTO ordinal_attributes_ypois (ordinal_attribute_id, ypoi_id, created, modified) VALUES (:ordinal_attribute_id, :ypoi_id, :tstamp, :tstamp)";
  						  $para = array(
  						      'ordinal_attribute_id'  => $lastOrdinalAttrId,
  						      'ypoi_id' => $lastPoisId,
  						      'name' => $attrName,
  						      'tstamp' => $now
  						  );
  						  $db->fire($sql, $para);
  						}
            }
          }
          $db->close();
        } catch (Exception $e) {
          die('Fehler bei Datenspeicherung Fehler: ' . $e->getMessage());
        }
      }
      echo $cfunc->tagIt("p", "Eintragen der <strong>ypois-, binary_components-</strong>Daten erfolgreich abgeschlossen " . date("\a\m d.m.Y \u\m H:i:s") );
    }

  }

  $app = new SaveData();

  $app->getYelpData("../data/yelp_karlsruhe_businesses");
  /*
  $app->clearDB([

    'binary_components',
    'nominal_attributes',
    'nominal_components',
    'ordinal_components',
    'ordinal_attributes'
  ]);
  $app->saveCategoriesToDB();
  */
  $app->clearDB([
      'ypois',
      'binary_components_ypois',
      'nominal_attributes_ypois',
      'ordinal_attributes_ypois'
  ]);

  $app->saveDataToDB($app->pois);


?>
