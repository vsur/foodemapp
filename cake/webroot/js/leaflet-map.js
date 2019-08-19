// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);
console.log(window.location);


// Initalize LMap
var mymap = L.map('ypoisMap').setView([49.01, 8.40806], 13);
var myIcon = L.icon({
    // iconUrl: 'foodmap/cake/img/leaflet/marker-food.png',
    iconUrl: '../../img/leaflet/marker-isac.png',
    iconSize: [32, 32],
    iconAnchor: [16, 16],
    popupAnchor: [-3, -76],
    shadowUrl: '../../img/leaflet/marker-food-isac-shadow.png',
    shadowSize: [32, 32],
    shadowAnchor: [16, 16]
});
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);
ypois.forEach(function(ypoi, i) {
    var marker = L.marker([ypoi.lat, ypoi.lng], {icon: myIcon}).addTo(mymap);
});
