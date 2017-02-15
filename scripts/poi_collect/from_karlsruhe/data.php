<?php

  class yelpData {

    public $acceptedBinaryCategories = array();
    public $acceptedNominalCategories = array();
    public $acceptedOrdinalCategories = array();

    function __construct() {
      $binaries = [
        "Restaurants",
        "Food",
        "German",
        "Nightlife",
        "Italian",
        "Bars",
        "Cafes",
        "Pizza",
        "Hotels & Travel",
        "Coffee & Tea",
        "Hotels",
        "Kebab",
        "Fast Food",
        "Greek",
        "Pubs",
        "Chinese",
        "Beer Garden",
        "Bakeries",
        "Asian Fusion",
        "Mediterranean",
        "Cocktail Bars",
        "International",
        "Specialty Food",
        "Ice Cream & Frozen Yogurt",
        "Turkish",
        "Grocery",
        "Thai",
        "French",
        "Burgers",
        "Food Delivery Services",
        "Indian",
        "Baden",
        "Bed & Breakfast",
        "Meat Shops",
        "Breweries",
        "Caterers",
        "Bistros",
        "Modern European",
        "Patisserie/Cake Shop",
        "Wine Bars",
        "Beer, Wine & Spirits",
        "Dive Bars",
        "Tapas Bars",
        "Steakhouses",
        "Chocolatiers & Shops",
        "American (Traditional)",
        "Serbo Croatian",
        "Lounges",
        "Vietnamese",
        "Sushi Bars",
        "Spanish",
        "Vegetarian",
        "Beer Gardens",
        "Beverage Store",
        "Sports Bars",
        "Curry Sausage",
        "Irish Pub",
        "Mexican",
        "Middle Eastern",
        "Seafood",
        "Arabian",
        "Delicatessen",
        "African",
        "Food Stands",
        "Alsatian",
        "Vegan",
        "Salad",
        "Barbeque",
        "Rhinelandian",
        "Beer Hall",
        "Oriental",
        "Bavarian",
        "Bagels",
        "Cooking Schools",
        "Cupcakes",
        "Irish",
        "Buffets",
        "Swiss Food",
        "Juice Bars & Smoothies",
        "Wok",
        "Moroccan",
        "Hot Dogs",
        "Farmers Market",
        "Falafel",
        "Butcher",
        "Soup",
        "Lebanese",
        "Austrian",
        "Tex-Mex"
      ];

      $binaryAttributes = [
        "Accepts Credit Cards",
        "Wheelchair Accessible",
        "Take-out",
        "Delivery",
        "Outdoor Seating",
        "Takes Reservations",
        "Good For Groups",
        "Good For Dancing",
        "Has TV",
        "Coat Check",
        "Dogs Allowed",
        "Good for Kids",
        "Waiter Service",
        "Happy Hour",
        "Caters",
        "By Appointment Only",
      ];

      // Combine identifiedBinaryCategories and identifiedAttributesForBinarayCategories in one array
      foreach ($binaries as $category) {
        array_push($this->acceptedBinaryCategories, $category);
      }
      foreach ($binaryAttributes as $category) {
        array_push($this->acceptedBinaryCategories, $category);
      }
      sort($this->acceptedBinaryCategories);

      $nominals = [
        "Good For" => [
          "dessert",
          "latenight",
          "lunch",
          "dinner",
          "breakfast",
          "brunch"
        ],
        "Ambience" => [
          "romantic",
          "intimate",
          "classy",
          "hipster",
          "divey",
          "touristy",
          "trendy",
          "upscale",
          "casual"
        ],
        "Attire" => [
          "dressy",
          "casual",
          "formal"
        ],
        "Smoking" => [
          "yes",
          "outdoor",
          "no"
        ],
        "Wi-Fi" => [
          "no",
          "free",
          "paid"
        ],
        "Music" => [
          "dj",
          "background_music",
          "karaoke",
          "live",
          "video",
          "jukebox"
        ],
        "BYOB/Corkage" => [
          "yes_free",
          "no",
          "yes_corkage"
        ],
        "Ages Allowed" => [
          "21plus",
          "18plus",
          "allages",
          "19plus"
        ],
        "Dietary Restrictions" => [
          "dairy-free",
          "gluten-free",
          "vegan",
          "kosher",
          "halal",
          "soy-free".
          "vegetarian"
        ]
      ];
      // Attribute Value are simply safed in db
      foreach ($nominals as $nominal => $nominalsValues) {
        sort($nominalsValues);
        $nominals[$nominal] = $nominalsValues;
      }
      $this->acceptedNominalCategories = $nominals;
      asort($this->acceptedNominalCategories);

      $ordinals = [
        "Price Range" => [
        		"1" => ["display_name" => "Günstig", "meter" => 1],
        		"2" => ["display_name" => "Durschnittlich", "meter" => 2],
        		"3" => ["display_name" => "Gehobene Preisklasse", "meter" => 3],
        		"4" => ["display_name" => "Teuer", "meter" => 4]
        ],
        "Parking" => [
        		"street" => ["display_name" => "Auf der Straße", "meter" => 1],
        		"validated" => ["display_name" => "Parktiketentwertung", "meter" => 2],
        		"lot" => ["display_name" => "Parkplatz", "meter" => 3],
        		"garage" => ["display_name" => "Garage", "meter" => 4],
        		"valet" => ["display_name" => "Parkdienst", "meter" => 5]
        ],
        "Noise Level" => [
        		"quiet" => ["display_name" => "Leise", "meter" => 1],
        		"average" => ["display_name" => "Durchschnittlich", "meter" => 2],
        		"loud" => ["display_name" => "Laut", "meter" => 3],
        		"very_loud" => ["display_name" => "Durchschnittlich", "meter" => 4]
        ],
        "Distance" => []
      ];
      // Attribute Value are simply safed in db
      krsort($ordinals);
      $this->acceptedOrdinalCategories = $ordinals;
    }

    /* Control functions */
    public static function getHandle($pathToFile) {
      $handle = fopen($pathToFile . ".json", "r");
      if($handle) {
       return $handle;
      } else {
       die("Fehler: Kann Datei $pathToFile nicht öffnen!");
      }
    }

  }

?>
