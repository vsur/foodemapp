/*
 * This is fmapp data script
 */

// Google Places API App

var geoInfoR = {
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
            ],
};

            // https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=49.01340740000001,12.101631&key=AIzaSyD9JmV9-qAXPJsG1K77xtarCM77qUa488M&types=painter
// Example Query https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=-33.8670522,151.1957362&radius=500&types=food&name=cruise&key=YOUR_API_KEY
var gSearch = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" +
              geoInfoR.geometry.location.lat + "," + geoInfoR.geometry.location.lng +
              "&radius=1500" +
              "&types=" + geoInfoR.types[27] +
              "&key=" + secData.gAPI;

$.getJSON( gSearch, function( response ) {
  /*
  var items = [];
  $.each( data, function( key, val ) {
    items.push( "<li id='" + key + "'>" + val + "</li>" );
  });
  */
  console.log(response);
});
