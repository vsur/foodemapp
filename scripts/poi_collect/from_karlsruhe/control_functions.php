<?php
  require '../../../sec/givexml.php';
  $secKeys = getSecVars('../../../sec/');
  /*
   *
   *  Control functions
   *
   */

  class ControlFunctions {

    public static function addAPIkey($urlString) {
      global $secKeys;
      $urlString .= "&key=" . $secKeys->{'gSerAPI'};
      return $urlString;
    }

    public static function tagIt($tag, $contentToTag) {
      $taggedContent = "<" . $tag . ">" . $contentToTag . "</" . $tag . ">";
      return $taggedContent;
    }

    public static function checkDuplicatePID($resultArray) {
      $pids = array();
      $filteredArray =array();
      foreach($resultArray as $toFilter) {

        if( !in_array($toFilter->place_id, $pids)) {
          array_push($pids, $toFilter->place_id);
          array_push($filteredArray, $toFilter);
        }

      }
      return $filteredArray;
    }

    public static function formatResultArray($data) {
      echo "<hr />";
      echo '<h1 style="font-weight: bold;">Datenausgabe</h1>';
      foreach($data as $poi) {
        echo "<p>";
        if(isset($poi->name)) echo "<b>" . $poi->name . "</b>";
        if(isset($poi->vicinity)) echo ", " . $poi->vicinity;
        if( !( isset($poi->name) && isset($poi->vicinity) ) ) echo "<b><u>Kein Name und keine Adresse im Datensatz</u></b>";
        echo "<br />";
        echo "place_id: " .$poi->place_id . ", lat: " .  $poi->geometry->location->lat . ", lng: " .  $poi->geometry->location->lat;
        echo "<br />";
        if( isset($poi->types) ) {
          echo "types: " . implode(", ", $poi->types);
        } else {
           echo "<i>Keine Google-Types im Datensatz vorhanden</i>";
        }
        echo "</p>";
      }
    }

    public static function pasteSpacer($spacerKey, $spacerRows = 10) {
      $spacerString = "<p>";
      for( $i = 0; $i < $spacerRows; $i++) {
        $spacerString .= "$spacerKey<br />";
      }
      $spacerString .= "</p>";
      return $spacerString;
    }

    public static function forDebug($dataToDebug, $name = null) {
      echo "<hr />";
      echo "<pre>";
      if(isset($name)) echo "<b>Debugausgabe für: <span style=\"color: purple;\">" . $name . "</span></b>\n";
      echo print_r($dataToDebug);
      echo "</pre>";
    }

  }

?>
