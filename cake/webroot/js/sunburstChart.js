/*
 * Data script for Sunburst Viz
 */
var maxWidth = +d3.select("#poisSunburst").style("width").replace("px", "");
d3.select("#poisTreemap").style("position", "relative").style("padding-top", "");
var margin = {top: 50, right: 10, bottom: 50, left: 10},
    // width = maxWidth - margin.left - margin.right,
    width = maxWidth,
    // height = 500 - margin.top - margin.bottom;
    height = maxWidth/2,
    radius = Math.min(width, height) / 2;

var color = d3.scale.category10();

var svg = d3.select("#poisSunburst").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var partition = d3.layout.partition()
    .sort(null)
    .size([2 * Math.PI, radius * radius])
    .value(function(d) { return 1; });

var arc = d3.svg.arc()
    .startAngle(function(d) { return d.x; })
    .endAngle(function(d) { return d.x + d.dx; })
    .innerRadius(function(d) { return Math.sqrt(d.y); })
    .outerRadius(function(d) { return Math.sqrt(d.y + d.dy); });

var path = svg.datum(sunburstData).selectAll("path")
    .data(partition.nodes)
    .enter().append("path")
    .attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
    .attr("d", arc)
    .style("stroke", "#fff")
    .style("fill", function(d) {
      console.log("d");
      console.log(d);
      if(d.depth == 1) {
        return "#7d003c";
      } else if (d.depth == 2) {
        var colorComponents = d3.scale.category10();
        var componentNAmes = [];
        d.parent.children.forEach(function(childComponent) {
          componentNAmes.push(childComponent.name);
        });
        console.log(componentNAmes);
        colorComponents.domain(componentNAmes);
        console.log(colorComponents.domain());
        return colorComponents(d.name);
        // return color((d.children ? d : d.parent).name);
      }
    })
    .style("fill-rule", "evenodd")
    .each(stash);

d3.selectAll("input").on("change", function change() {
  var value = this.value === "count"
      ? function() { return 1; }
      : function(d) { return d.rating; };

  path
      .data(partition.value(value).nodes)
    .transition()
      .duration(1500)
      .attrTween("d", arcTween);
});


// Stash the old values for transition.
function stash(d) {
  d.x0 = d.x;
  d.dx0 = d.dx;
}

// Interpolate the arcs in data space.
function arcTween(a) {
  var i = d3.interpolate({x: a.x0, dx: a.dx0}, a);
  return function(t) {
    var b = i(t);
    a.x0 = b.x;
    a.dx0 = b.dx;
    return arc(b);
  };
}

d3.select(self.frameElement).style("height", height + "px");
