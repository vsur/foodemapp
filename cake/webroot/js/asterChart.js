/*
 * Data script for Aster Chart Viz
 */

// Setting base for Aster chart

// Get Everything in a function cause it is called recursivly

function drawAster(poiData, chartID) {
  var maxWidth = +d3.select(chartID).style("width").replace("px", "");
  d3.select(chartID).style("position", "relative").style("padding-top", "");

  var color = d3.scale.category10();

  var margin = {top: 40, right: 10, bottom: 10, left: 10},
    // width = maxWidth - margin.left - margin.right,
    width = maxWidth,
    // height = 500 - margin.top - margin.bottom;
    height = maxWidth/2,
    radius = Math.min(width, height) / 2,
    innerRadius = 0.2 * radius;
  var pie = d3.layout.pie()
    .sort(null)
    /*
      value steuert Segement Umfang, für den Anfang jeder Component gleich groß
      evtl. später Größe durch Gewichtung ändern
    */
    // .value(function(d) { return d._joinData.rating; })
    .value(function(d) { return 1; })
    .sort(null);

  // Tooltip könnte Später noch so ergänzt werden
  /*
    var tip = d3.tip()
      .attr('class', 'd3-tip')
      .offset([0, 0])
      .html(function(d) {
      return d.data.label + ": <span style='color:orangered'>" + d.data.score + "</span>";
    });
  */

  /*
    Außerdem könnte auch noch die Legende
    aus PieChart eingebaut werden
    siehe var legend und am Anfang nicht vergessen
    var legendRectSize = 18;
    var legendSpacing = 4;
    Und später nach svg Deklaration müsste noch
    svg.call(tip);
    gecalled werden
  */

  // Set filling by rating
  var arc = d3.svg.arc()
    .innerRadius(innerRadius)
    .outerRadius(function (d) {
      // Evtl nicht durch 100
      // return (radius - innerRadius) * (d.data._joinData.rating / 100.0) + innerRadius;
      return (radius - innerRadius) * (d.data._joinData.rating * 10 / 100) + innerRadius;
    });

  var outlineArc = d3.svg.arc()
    .innerRadius(innerRadius)
    .outerRadius(radius);

  var svg = d3.select(chartID).append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

  var dataset = poiData.components;

  var path = svg.selectAll(".solidArc")
    .data(pie(dataset))
    .enter().append("path")
    .attr("fill", function(d, i) { return color(d.data.name + " " + d.data._joinData.rating + "%"); })
    // .attr("fill", function(d) { return d.data.color; })
    .attr("class", "solidArc")
    .attr("stroke", "gray")
    .attr("d", arc);
    // .on('mouseover', tip.show)
    // .on('mouseout', tip.hide);

  // HintergrundArc
  var outerPath = svg.selectAll(".outlineArc")
    .data(pie(dataset))
    .enter().append("path")
    .attr("fill", "none")
    // Hellere Farbe hinten einbauen
    // .attr("fill", function(d, i) { return d3.rgb.brighter(color(d.data.name + " " + d.data._joinData.rating + "%")); })
    .attr("stroke", "gray")
    .attr("class", "outlineArc")
    .attr("d", outlineArc);

  svg.append("svg:text")
    .attr("class", "aster-score")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle") // text-align: right
    .text(poiData.name);

// TODO LEGENDE einbauen, analog donut

// Anschluss dann Karte einbauen!

}

// Hier Data Schleife umwwandeln
d3.csv('aster_data.csv', function(error, data) {
  // Prüfen ob notwendig
  data.forEach(function(d) {
    d.id     =  d.id;
    d.order  = +d.order;
    d.color  =  d.color;
    d.weight = +d.weight;
    d.score  = +d.score;
    d.width  = +d.weight;
    d.label  =  d.label;
  });
  // for (var i = 0; i < data.score; i++) { console.log(data[i].id) }
  // Daten Arc
  var path = svg.selectAll(".solidArc")
      .data(pie(data))
      .enter().append("path")
      .attr("fill", function(d) { return d.data.color; })
      .attr("class", "solidArc")
      .attr("stroke", "gray")
      .attr("d", arc)
      .on('mouseover', tip.show)
      .on('mouseout', tip.hide);

  // HintergrundArc
  var outerPath = svg.selectAll(".outlineArc")
      .data(pie(data))
    .enter().append("path")
      .attr("fill", "none")
      .attr("stroke", "gray")
      .attr("class", "outlineArc")
      .attr("d", outlineArc);


  // Nur für den Durschnitt in der Mitte notwendig
  // calculate the weighted mean score
  var score =
    data.reduce(function(a, b) {
      //console.log('a:' + a + ', b.score: ' + b.score + ', b.weight: ' + b.weight);
      return a + (b.score * b.weight);
    }, 0) /
    data.reduce(function(a, b) {
      return a + b.weight;
    }, 0);
    // Hier dann vielleicht lieber den Namen der Lokaliät
  svg.append("svg:text")
    .attr("class", "aster-score")
    .attr("dy", ".35em")
    .attr("text-anchor", "middle") // text-align: right
    .text(Math.round(score));

});
