/*
 * Data script for Treemap Viz
 */
var maxWidth = +d3.select("#poisTreemap").style("width").replace("px", "");
d3.select("#poisTreemap").style("position", "relative").style("padding-top", "");
var margin = {top: 40, right: 10, bottom: 10, left: 10},
    // width = maxWidth - margin.left - margin.right,
    width = maxWidth,
    // height = 500 - margin.top - margin.bottom;
    height = 500;

var color = d3.scale.category10();

var treemap = d3.layout.treemap()
    .size([width, height])
    .sticky(true)
    .value(function(d) { return d.rating; });
var div = d3.select("#poisTreemap").append("div")
    .style("position", "relative")
    .style("width", (width) + "px")
    .style("height", (height) + "px")
    // .style("width", (width + margin.left + margin.right) + "px")
    // .style("height", (height + margin.top + margin.bottom) + "px")
    .style("left", 0 + "px")
    .style("top", 0 + "px");

  var node = d3.select("#poisTreemap").datum(treemapData).selectAll(".node")
      .data(treemap.nodes)
      .enter().append("div")
      .attr("class", "node")
      .call(position)
      .style("background", function(d) { return d.children ? color(d.name) : null; })
      .text(function(d) { return d.children ? null : d.name; });

  d3.selectAll("input").on("change", function change() {
    var value = this.value === "count"
        ? function() { return 1; }
        : function(d) { return d.rating; };

    node
        .data(treemap.value(value).nodes)
      .transition()
        .duration(1500)
        .call(position);
  });

function position() {
  this.style("left", function(d) { return d.x + "px"; })
      .style("top", function(d) { return d.y + "px"; })
      .style("width", function(d) { return Math.max(0, d.dx - 1) + "px"; })
      .style("height", function(d) { return Math.max(0, d.dy - 1) + "px"; });
}

  function drawTreemap() {

  }
