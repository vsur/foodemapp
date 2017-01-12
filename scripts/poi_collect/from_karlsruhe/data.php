<?php

  class yelpData {

    public $acceptedBinaryCategories = array();
    public $acceptedAttributesAsBinarayCategories = array();
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
      foreach ($binaries as $category) {
        array_push($this->acceptedBinaryCategories, $category);
      }
      sort($this->acceptedBinaryCategories);

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
      foreach ($binaryAttributes as $category) {
        array_push($this->acceptedAttributesAsBinarayCategories, $category);
      }
      sort($this->acceptedAttributesForBinarayCategories);

      $nominals = [
        "Good For",
        "Ambience",
        "Attire",
        "Smoking",
        "Wi-Fi",
        "Music",
        "BYOB/Corkage",
        "Ages Allowed",
        "Dietary Restrictions"
      ];
      // Attribute Value are simply safed in db
      foreach ($nominals as $category) {
        array_push($this->acceptedNominalCategories, $category);
      }
      sort($this->acceptedNominalCategories);

      $ordinals = [
        "Price Range",
        "Parking",
        "Noise Level",
        "Distance"
      ];
      // Attribute Value are simply safed in db
      foreach ($ordinals as $category) {
        array_push($this->acceptedOrdinalCategories, $category);
      }
      sort($this->acceptedOrdinalCategories);

    }

    /* Control functions */
    public static function getHanlde($pathToFile) {
      $handle = fopen($pathToFile . ".json", "r");
      if($handle) {
       return $handle;
      } else {
       die("Fehler: Kann Datei $pathToFile nicht öffnen!");
      }
    }

  }

?>
