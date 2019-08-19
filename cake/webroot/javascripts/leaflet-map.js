// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#ypoisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('ypoisMap').setView([49.01, 8.40806], 13);
var myIcon = L.divIcon({
    iconSize: [32, 32],
    iconAnchor: [16, 16],
    popupAnchor: [-3, -76],
});
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);
ypois.forEach(function(ypoi, i) {
    var newIcon = myIcon;
    newIcon.options.className = 'ypoiIcon';
    newIcon.options.html = '<div><span>' + ypoi.name + '</span></div>';
    var marker = L.marker([ypoi.lat, ypoi.lng], {icon: newIcon}).addTo(mymap);
});
