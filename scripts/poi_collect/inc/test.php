<?php
  require 'data.php';

  $data = new googleData();

  // $data->getJSON();
  echo  print_r($data->jRobj);
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
