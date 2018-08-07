/*
 * Data script for Chord Diagramm Viz
 */
var maxWidth = +d3.select("#ypoisChord").style("width").replace("px", "");
var margin = {
        top: 40,
        right: 10,
        bottom: 10,
        left: 10
    },
    // width = maxWidth - margin.left - margin.right,
    width = maxWidth,
    // height = 500 - margin.top - margin.bottom;
    height = maxWidth / 2,
    innerRadius = Math.min(width, height) * .375,
    outerRadius = innerRadius * 1.1;

var color = d3.scale.category10();

var chord = d3.layout.chord()
    .padding(.05)
    .sortSubgroups(d3.descending)
    .matrix(matrix);

var fill = d3.scale.category10();

var svg = d3.select("#ypoisChord").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

svg.append("g").selectAll("path")
    .data(chord.groups)
    .enter().append("path")
    .style("fill", function(d) {
        return fill(d.index);
    })
    .style("stroke", function(d) {
        return fill(d.index);
    })
    .attr("d", d3.svg.arc().innerRadius(innerRadius).outerRadius(outerRadius))
    .on("mouseover", fade(.1))
    .on("mouseout", fade(1));

var ticks = svg.append("g").selectAll("g")
    .data(chord.groups)
    .enter().append("g").selectAll("g")
    .data(groupTicks)
    .enter().append("g")
    .attr("transform", function(d) {
        return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")" +
            "translate(" + outerRadius + ",0)";
    });

ticks.append("line")
    .attr("x1", 1)
    .attr("y1", 0)
    .attr("x2", 5)
    .attr("y2", 0)
    .style("stroke", "#000");

ticks.append("text")
    .attr("x", 8)
    .attr("dy", ".35em")
    .attr("transform", function(d) {
        return d.angle > Math.PI ? "rotate(180)translate(-16)" : null;
    })
    .style("text-anchor", function(d) {
        return d.angle > Math.PI ? "end" : null;
    })
    .text(function(d) {
        return d.label;
    });

svg.append("g")
    .attr("class", "chord")
    .selectAll("path")
    .data(chord.chords)
    .enter().append("path")
    .attr("d", d3.svg.chord().radius(innerRadius))
    .style("fill", function(d) {
        return fill(d.target.index);
    })
    .style("opacity", 1);

// Returns an array of tick angles and labels, given a group.
function groupTicks(d) {
    // console.log("Var k:");
    var k = (d.endAngle - d.startAngle) / d.value;
    // console.log(k);
    // console.log("Für d.endAngle = " + d.endAngle  + " - d.startAngle = " + d.startAngle + " / d.value = " + d.value);
    // console.log("Objekt D:");
    // console.log(d);
    return d3.range(0, d.value, 1000).map(function(v, i) {
        // console.log("V ist : ");
        // console.log(v);
        // console.log("i ist : ");
        // console.log(i);
        // console.log(poiComponentMatrix[d.index][0]);
        return {
            angle: v * k + d.startAngle,
            // TODO: Label noch besser ausrichten
            label: chordLables[d.index]
            // label: (d.index < pois.length) ? poiComponentMatrix[d.index][0] : poiComponentMatrix[d.index][1][d.index - pois.length][2]
            // label: i % 5 ? null : v / 1000 + "k"
        };
    });
}

// Returns an event handler for fading a given chord group.
function fade(opacity) {
    return function(g, i) {
        svg.selectAll(".chord path")
            .filter(function(d) {
                return d.source.index != i && d.target.index != i;
            })
            .transition()
            .style("opacity", opacity);
    };
}
