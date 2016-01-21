<?php
    include '../../../sec/givexml.php';
    $secKeys = getSecVars('../../../sec/');

    // Data Var
    $jsonR = '{
      "formatted_address" : "Regensburg, Deutschland",
      "geometry" : {
         "location" : {
            "lat" : 49.01340740000001,
            "lng" : 12.101631
         },
         "viewport" : {
            "northeast" : {
               "lat" : 49.22328419999999,
               "lng" : 12.4909978
            },
            "southwest" : {
               "lat" : 48.7649053,
               "lng" : 11.6591858
            }
         }
      },
      "icon" : "https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
      "name" : "Regensburg",
      "place_id" : "ChIJIWdnpCHBn0cRPLc80Q0Fk6E",
      "types" : [

                "accounting",
                "airport",
                "amusement_park",
                "aquarium",
                "art_gallery",
                "atm",
                "bakery",
                "bank",
                "bar",
                "beauty_salon",
                "bicycle_store",
                "book_store",
                "bowling_alley",
                "bus_station",
                "cafe",
                "campground",
                "car_dealer",
                "car_rental",
                "car_repair",
                "car_wash",
                "casino",
                "cemetery",
                "church",
                "city_hall",
                "clothing_store",
                "convenience_store",
                "courthouse",
                "dentist",
                "department_store",
                "doctor",
                "electrician",
                "electronics_store",
                "embassy",
                "establishment",
                "finance",
                "fire_station",
                "florist",
                "food",
                "funeral_home",
                "furniture_store",
                "gas_station",
                "general_contractor",
                "grocery_or_supermarket",
                "gym",
                "hair_care",
                "hardware_store",
                "health",
                "hindu_temple",
                "home_goods_store",
                "hospital",
                "insurance_agency",
                "jewelry_store",
                "laundry",
                "lawyer",
                "library",
                "liquor_store",
                "local_government_office",
                "locksmith",
                "lodging",
                "meal_delivery",
                "meal_takeaway",
                "mosque",
                "movie_rental",
                "movie_theater",
                "moving_company",
                "museum",
                "night_club",
                "painter",
                "park",
                "parking",
                "pet_store",
                "pharmacy",
                "physiotherapist",
                "place_of_worship",
                "plumber",
                "police",
                "post_office",
                "real_estate_agency",
                "restaurant",
                "roofing_contractor",
                "rv_park",
                "school",
                "shoe_store",
                "shopping_mall",
                "spa",
                "stadium",
                "storage",
                "store",
                "subway_station",
                "synagogue",
                "taxi_stand",
                "train_station",
                "travel_agency",
                "university",
                "veterinary_care",
                "zoo"
                ]
    }';
    $jRobj = json_decode($jsonR);
    forDebug($jRobj->{'types'});
    $pois = array();

    for ($i = 0; $i < count($jRobj->{'types'}); $i++) {
      // String for request
      $gSearchURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" .
        $jRobj->{'geometry'}->{'location'}->{'lat'} . "," . $jRobj->{'geometry'}->{'location'}->{'lng'} .
        "&radius=1500" .
        "&types=" . $jRobj->{'types'}[$i] .
        "&key=" . $secKeys->{'gSerAPI'};

      $info = json_decode( file_get_contents($gSearchURL) );

      foreach($info->results as $poi) {
        $array =  (array) $poi;
        array_push($pois, $poi);
      }
    }


    echo $gSearchURL . "\n";
    // $pois = array();

    // print_r ($info->results[0]);
    // echo 'Ausgabe für $pois nach ' . "\n";
    // echo '<hr />';
    // echo "\n";
    // echo '<hr />';
    // print_r($info);
    formatResult($pois);

    forDebug($pois);

    function formatResult($data) {
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
    function forDebug($a) {
        echo "<pre>";
        echo print_r($a);
        echo "</pre>";
    }

?>
