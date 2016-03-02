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
        echo ControlFunctions::tagIt("h4",
          "<span style=\"font-family: monospace;\">Erste Suchergebnisseite <span style=\"color: green;\">gespeichert</span></span>"
        );
        // Check if result contains next_page_token and try to get additional data
        if( isset($info->next_page_token) ) {
          echo ControlFunctions::tagIt("h4",
            "<span style=\"font-family: monospace;\"><span style=\"color: orange;\">Next Page Token gefunden</span></span>"
          );
          $this->callAddToken($info->next_page_token);
        } else {
          echo ControlFunctions::tagIt("h4",
            "<p><span style=\"color: orange\">Just one result page</span>: No Next Page Token found at all!</p>"
          );
        }

        echo ControlFunctions::tagIt("h2",
          "<span style=\"font-family: monospace;\">nearbyAllTypesAllPage()</span><br />" .
          "Nearby Anfrage für 1. Seite <span style=\"color: blue;\">" .  $queryData->{'types'}[$i] . "</span> Query " . $loopQuery
        );
        echo ControlFunctions::tagIt("h3",
          "Einträge: <b>" . count($info->results) . "</b>"
        );

        echo ControlFunctions::pasteSpacer("###  Next ###");

      }

      echo ControlFunctions::tagIt("h2",
        "<span style=\"font-family: monospace;\">nearbyAllTypesFirstPage()</span><br />" .
        "Nearby Anfrage für <span style=\"color: blue;\">First Page – All Types</span>-Query "
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

  }

  $data = new googleData();
  $app = new SaveData();
  $db = new DataBase();

  // Get Data
  try {
    $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
    $sql = "SELECT name, description, counter FROM scenarios";
    $rows = $db->fire($sql);
    //ControlFunctions::forDebug($rows, "Datenabnkausgabe");
  } catch(Exception $e) {
    echo ControlFunctions::tagIt("h4",
      $e->getMessage()
    );
  }

  // Paste Data
  $now = date("Y-m-d H:i:s");
  try {
    $db->connect('localhost', $secKeys->cakeVars->{'dbUsr'}, $secKeys->cakeVars->{'dbPw'}, $secKeys->cakeVars->{'dbCake'});
    $sql = "INSERT INTO tags (title, created, modified) VALUES (:title, :tstamp, :tstamp)";
    $para = array(
        'title'  => "Tag vom $now",
        'tstamp' => $now
    );
    $db->fire($sql, $para);
    echo ControlFunctions::tagIt("h1",
      "Letzter Eintrag: " . $db->lastInsertId()
    );
  } catch(Exception $e) {
    die('Fehler bei .... Fehler: ' . $e->getMessage());
  }
  /*
   *
   *
   * Next Steps:
   * 1. create Save Array inn = 3 loop
   * 2. Save Data in Tags
   * 3. Increase Loop
   *
   *
   */
  // $app->nearbyAllTypesAllPages($data->phpQueryObj);

?>
