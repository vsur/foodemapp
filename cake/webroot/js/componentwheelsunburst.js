/*
 * Script for Filter Wheel
 */

 // d3.select("#compnentWheelContainer").style("display", "none");
console.log(componentWheelJSONData);
// Define Space

console.log(d3.selectAll("p"));

var maxWidth = +d3.select("#wheelBlock").style("width").replace("px", "");
var maxHeight= +d3.select("#wheelBlock").style("height").replace("px", "");
var margin = {top: 50, right: 10, bottom: 50, left: 10},
    width = maxWidth,
    height = maxHeight,
    radius = Math.min(width, height) / 2;

// const standardColor = d3.scaleOrdinal.range(["#A07A19", "#AC30C0", "#EB9A72", "#BA86F5", "#EA22A8"]);
const standardColor =  d3.color("steelblue");

    console.log("w" + width);
    console.log("h" + height);

// Addtional for labels
var x = d3.scaleLinear()
    .range([0, 2 * Math.PI]);

var y = d3.scaleLinear()
    .range([0, radius]);

var svg = d3.select("#wheelBlock").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// var partition = d3.partition()
//     .size([2 * Math.PI, radius])
//     (d3.hierarchy(componentWheelJSONData)
//     .sum(d => d.value)
//     .sort((a, b) => b.value - a.value))

var partition = d3.partition()
    .size([2 * Math.PI, radius]);

var root = d3.hierarchy(componentWheelJSONData)
    .sum(function (d) { return d.size});

partition(root);

var arc = d3.arc()
    .startAngle(function(d) { return d.x0; })
    .endAngle(function(d) {
        // return d.x + d.dx;
        return d.x1;
    })
    .innerRadius(function(d) { return Math.sqrt(d.y0); })
    .outerRadius(function(d) {
        // return Math.sqrt(d.y + d.dy);
        return Math.sqrt(d.y1);
    });

var path = svg.selectAll("path")
    .data(root.descendants())
    .enter().append("path")
    .attr("display", function(d) { return d.depth ? null : "none"; }) // hide inner ring
    .attr("d", arc)
    .style("stroke", "#fff")
    .style("fill", function(d) {
        var componentNames = [];
        if(d.depth == 1) {
            componentNames = d.parent.children.map(function(child) {
                    return child.name;
                });
            standardColor.domain(componentNames);
            return d3.rgb(standardColor(d.name)).toString();
        } else if (d.depth == 2) {
            componentNames = d.parent.children.map(function(child) {
                return child.name;
            });
            standardColor.domain(componentNames);
            return d3.rgb(standardColor(d.name)).brighter(1.5).toString();
        }
    })
    .style("fill-rule", "evenodd")
    // .each(stash)
    // .each(stash)
    .on("mouseover", mouseover)
    .on("mouseleave", mouseleave);

/*
var text = d3.selectAll("path").append("text")
    .attr("transform", function(d) { return "rotate(" + computeTextRotation(d) + ")"; })
    .attr("x", function(d) { return y(d.y); })
    .attr("dx", "6") // margin
    .attr("dy", ".35em") // vertical-align
    .text(function(d) { return d.name; });


d3.selectAll("input").on("change", function change() {
    var value = this.value === "count" ? (  function() { return 1; }    ) : (   function(d) { return d.rating; }    );

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

function computeTextRotation(d) {
    return (x(d.x + d.dx / 2) - Math.PI / 2) / Math.PI * 180;
}
*/
d3.select(self.frameElement).style("height", height + "px");

// Fade all but the current sequence, and show it in the breadcrumb trail.
function mouseover(d) {
    // console.log(d.rating);
    var percentage = (10 * d.rating ).toPrecision(3) + "%";
    var pathName = d.name;
    console.log(pathName);
    if (d.depth == 3) {
        d3.select("#percentage")
            .text(percentage);

        d3.select("#nameAttribute")
            .text(pathName);

    } else if (d.depth == 2) {
        d3.select("#percentage")
            .text(pathName);

        d3.select("#nameAttribute")
            .text(d.parent.name);} else if (d.depth == 1) {
        d3.select("#percentage")
            .text("");

        d3.select("#nameAttribute")
            .text(pathName);
    }

    d3.select("#explanation")
        .style("visibility", "");

    // Fade all the segments.
    d3.selectAll("path")
    // .transition()
    // .duration(500)
        .style("opacity", 0.3);

    // Then highlight only those that are an ancestor of the current segment.
    d3.select(this)
        .style("opacity", 1);

}

// Restore everything to full opacity when moving off the visualization.
function mouseleave(d) {

    //  d3.selectAll("path").on("mouseover", null);

    // Transition each segment to full opacity and then reactivate it.
    d3.selectAll("path")
    // .transition()
    // .duration(1000)
        .style("opacity", 1);

    d3.select("#explanation")
        .style("visibility", "hidden");
}
