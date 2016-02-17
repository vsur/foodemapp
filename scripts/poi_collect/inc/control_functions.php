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
        echo "<b>" . $poi->name . "</b>, " . $poi->vicinity;
        echo "<br />";
        echo "place_id: " .$poi->place_id . ", lat: " .  $poi->geometry->location->lat . ", lng: " .  $poi->geometry->location->lat;
        echo "<br />";
        echo "types: " . implode(", ", $poi->types);
        echo "</p>";
      }
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
