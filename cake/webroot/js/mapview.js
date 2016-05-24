// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#poisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('poisMap').setView([49.01340740000001, 12.101631], 13);
var marker = L.marker([51.5, -0.09]).addTo(mymap);
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);
pois.forEach(function(poi, i) {
    console.log(poi.name + " LAT " + poi.lat + " LNG " + poi.lng);
    /*
      Das Color Coding noch mal vertagen, weil nicht ganz trivial.

      var colorRating
      poi.components.forEach(fucntion(component, j) {
      });
    */

    var circle = L.circle([poi.lat, poi.lng], 100, {
        color: '#c2005d',
        // fillColor: '#7d003c',
        fillColor: '#ffffff',
        fillOpacity: 0.75
    }).addTo(mymap);
    var recentIcon = L.icon({
        iconUrl: poi.icon,
        iconSize:     [18, 18], // size of the icon
        // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    var marker = L.marker([poi.lat, poi.lng], {icon: recentIcon}).addTo(mymap);
    // var marker = L.marker([poi.lat, poi.lng] ).addTo(mymap);
});

/*
  NEXT TODO

  Combiniere Icons mit Aster-Plot-Diagramme

  Baue Legene als alle enthaltenen › immer über Color Domain iterieren, dann ausgeben

  Dann vielleicht noch mal Color Code Frage

  Dann umschalter

*/
