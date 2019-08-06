// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('ypoisMap').setView([49.01, 8.40806], 13);
var marker = L.marker([51.5, -0.09]).addTo(mymap);
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);
ypois.forEach(function(ypoi, i) {
    var marker = L.marker([ypoi.lat, ypoi.lng]).addTo(mymap);
});
