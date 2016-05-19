// Put here Stuff for Leaflet

// First set height for LMap
var maxHeight = window.innerHeight;
$("#poisMap").css("height", maxHeight/2);

// Initalize LMap
var mymap = L.map('poisMap').setView([49.01340740000001, 12.101631], 13);
// var marker = L.marker([51.5, -0.09]).addTo(mymap);
L.tileLayer.provider('OpenStreetMap.BlackAndWhite').addTo(mymap);

/* Initialize the SVG layer */
mymap._initPathRoot();

/* We simply pick up the SVG from the map object */
var svg = d3.select("#poisMap").select("svg"),
g = svg.append("g");

pois.forEach(function(poi, i) {
    console.log(poi.name + " LAT " + poi.lat + " LNG " + poi.lng);
    poi.LatLng = new L.LatLng(poi.lat, poi.lng);
    drawAster(poi, "aster" + poi.google_place);


    /*var circle = L.circle([poi.lat, poi.lng], 100, {
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
    var marker = L.marker([poi.lat, poi.lng], {icon: recentIcon}).addTo(mymap);*/
});

function drawAster(poiData, chartID) {

  var color = d3.scale.category10();

  var width = 50,
    // height = 500 - margin.top - margin.bottom;
    height = width/2,
    radius = Math.min(width, height) / 2,
    innerRadius = 0.2 * radius;

  var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return 1; });

  // Set filling by rating
  var arc = d3.svg.arc()
    .innerRadius(innerRadius)
    .outerRadius(function (d) {
      return (radius - innerRadius) * (d.data._joinData.rating * 10 / 100) + innerRadius;
    });

  var outlineArc = d3.svg.arc()
    .innerRadius(innerRadius)
    .outerRadius(radius);

  var asterPlot = g.append("svg")
    .attr("id", chartID)
    .attr("width", width)
    .attr("height", height)
    .attr("class", "asterDiagram")
    .append("g")
    .attr("transform", "translate(" + (width / 2 - radius  )+ "," + height / 2 + ")");

  var dataset = poiData.components;

  // Background Path
  var outerPath = asterPlot.selectAll(".outlineArc")
  .data(pie(dataset))
  .enter().append("path")
  // Hellere Farbe hinten einbauen
  .attr("fill", function(d, i) {
    return color.range()[i];
  })
  .attr("stroke", "gray")
  .attr("class", "outlineArc")
  .attr("d", outlineArc);

  var path = asterPlot.selectAll(".solidArc")
    .data(pie(dataset))
    .enter().append("path")
    .attr("fill", function(d) {
      return d3.rgb(color(d.data.name + " " + d.data._joinData.rating * 10 + "%")).brighter().toString();
    })
    .attr("class", "solidArc")
    .attr("stroke", "gray")
    .attr("d", arc);
    // .on('mouseover', tip.show)
    // .on('mouseout', tip.hide);

  asterPlot.append("svg:text")
    .attr("class", "aster-score")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle") // text-align: right
    .text(poiData.name);

}


/*var markerDiagram = g.selectAll("circle")
  .data(pois)
  .enter().append("circle")
  .style("stroke", "black")
  .style("opacity", .6)
  .style("fill", "red")
  .attr("r", 20);*/

var asterPlotDiagramms = g.selectAll("svg.asterDiagram");

mymap.on("viewreset", update);
update();

function update() {
  // For Circles
  /*markerDiagram.attr("transform",
  function(d) {
    return "translate("+
      mymap.latLngToLayerPoint(d.LatLng).x +","+
      mymap.latLngToLayerPoint(d.LatLng).y +")";
    }
  );*/
  // Hier Doppelung Fehler in Daten!
  asterPlotDiagramms.forEach(function(aster, i) {
    console.log(aster);
    /*
    aster.attr("transform",
      function(d) {
        console.log(d.LatLng);
        return "translate("+
        mymap.latLngToLayerPoint(d.LatLng).x +","+
        mymap.latLngToLayerPoint(d.LatLng).y +")";
      }
    );*/
  });

}

/*
  NEXT TODO

  Combiniere Icons mit Aster-Plot-Diagramme

  Baue Legened als alle enthaltenen › immer über Color Domain iterieren, dann ausgeben

  Dann vielleicht noch mal Color Code Frage

  Dann umschalter

*/
