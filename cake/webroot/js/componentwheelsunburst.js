/*
 * Script for Filter Wheel
 */

 // d3.select("#compnentWheelContainer").style("opacity", "0");
console.log(componentWheelJSONData);
// Define Space

var maxWidth = +d3.select("#wheelBlock").style("width").replace("px", "");
var maxHeight= +d3.select("#wheelBlock").style("height").replace("px", "");
var margin = {top: 50, right: 10, bottom: 50, left: 10},
    width = maxWidth,
    height = maxHeight,
    radius = Math.min(width, height) / 2;

// const standardColor = d3.scaleOrdinal.range(["#A07A19", "#AC30C0", "#EB9A72", "#BA86F5", "#EA22A8"]);
const urCdBaseColors =  d3.scaleOrdinal().range(["#7d003c", "#8e8e8d"]);

const fMappYellowStar =  d3.scaleOrdinal()
                            .range(["#ffc700", "#ffd233", "#ffdd66", "ffe999", "fff4cc"])
                            .domain(["rating5", "rating4", "rating3", "rating2", "rating1"]);

const componentTypeColors =  d3.scaleOrdinal()
                            .range(["#065180", "#33B1FF", "#1486CC"])
                            .domain(["binaryComponents", "nominalComponents", "ordinalComponents"]);


const urTriadeColors = d3.scaleOrdinal().range(["#0AB0C9", "#07414A", "#7D003C", "#8A7C0E", "#C9146C"]);
const urCdColorPalette = d3.scaleOrdinal().range(["#ecbc00", "#cdd30f", "#aea700", "#00556a", "#ec6200", "#bf002a", "#9c004b", "#009b77", "#008993", "#4fb800", "#0087b2"]);

var svg = d3.select("#wheelBlock").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

var partition = d3.partition()
    .size([2 * Math.PI, radius]);

var root = d3.hierarchy(componentWheelJSONData)
    .count();

partition(root);

var arc = d3.arc()
    .startAngle(function (d) { return d.x0 })
    .endAngle(function (d) { return d.x1 })
    .innerRadius(function (d) { return d.y0 })
    .outerRadius(function (d) { return d.y1 });

var node = svg.selectAll("g")
    .data(root.descendants())
    .enter().append('g').style("cursor", "help").attr("class", "node")
    .append('path')
    .attr("display", function (d) { return d.depth ? null : "inline"; }) // Inner circle visible?
    .attr("d", arc)
    .style('stroke', '#fff')
    .style("fill", function (d) {

        switch (d.depth) {
            case 0:
                return urCdBaseColors(d.data.name);
                break;
            case 1:
                if(d.data.name == "choosenComponents") {
                    urCdBaseColors.domain(d.data.name);
                    return d3.rgb(urCdBaseColors(d.data.name)).brighter(1.5);
                } else if(d.data.name == "otherComponents") {
                    urCdBaseColors.domain(["choosenComponents", d.data.name]);
                    return urCdBaseColors(d.data.name);
                } else {
                    return fMappYellowStar(d.data.name);
                }
                break;
            case 2:
                if(d.parent.data.name == "choosenComponents") {
                    return fMappYellowStar(d.data.name);
                } else {
                    return componentTypeColors(d.data.name);
                }
                break;
            case 3:
                if(d.parent.parent.data.name == "choosenComponents") {
                    return componentTypeColors(d.data.name);
                } else {
                    let lighterComponentColor = d3.hsl(componentTypeColors(d.data.name));
                    lighterComponentColor.l += 0.2;
                    return lighterComponentColor;
                }
                break;
            case 4:
                let lighterComponentColor = d3.hsl(componentTypeColors(d.data.name));
                lighterComponentColor.l += 0.2;
                return lighterComponentColor;
                break;
            default:
                return urCdColorPalette(d.data.name);
        }
    })
    .on("mouseover", mouseover)
    .on("mouseleave", mouseleave);

svg.selectAll(".node")
    .append("text")
    .attr("transform", function(d) {
        if (d.depth == 0) {
            return "";
        } else {
            return "translate(" + arc.centroid(d) + ")rotate(" + computeTextRotation(d) + ")";
        }
    })
    .attr("dx", function(d) {
        let dx = setLabelString(d).length * 2.5;
        dx = dx * (-1);
        return dx;
    })
    .attr("dy", function(d) {
        if (d.depth == 0) {
            return ".5em";
        } else {
            return ".5em";
        }
    })
    .text(function(d) { return setLabelString(d) })
    .style("fill", function(d) {
        if(d.data.name.search("rating") == 0) {
            return "black";
        } else {
            return "white";
        }
    });

function computeTextRotation(d) {
    var angle = (d.x0 + d.x1) / Math.PI * 90;

    // Avoid upside-down labels
     // return (angle < 120 || angle > 270) ? angle : angle + 180;  // labels as rims
    return (angle < 180) ? angle - 90 : angle + 90;  // labels as spokes
}

// Darken all but the current sequence, and show it in the breadcrumb trail.
function mouseover(d) {
    let pathName = d.data.name;
    let infoString = setInfoString(d);
    d3.select("#coponentTextInfo span").style("visibility", "").html(infoString);

    // Fade all the segments.
    d3.selectAll("#wheelBlock path")
    .style("opacity", 0.3);

    // Then highlight only those that are an ancestor of the current segment.
    d3.select(this)
        .style("opacity", 1);

}

// Restore everything to full opacity when moving off the visualization.
function mouseleave(d) {

    // Transition each segment to full opacity and then reactivate it.
    d3.selectAll("path")
        .style("opacity", 1);

    d3.select("#coponentTextInfo span")
        .style("visibility", "hidden");
}

function setInfoString(d) {
    let infoString = "";
    let isCategory = false;
    let namesTranslationNeeded = Object.keys(sunburstInfoTranslations);
    if (namesTranslationNeeded.includes( d.data.name)) {
        isCategory = true;
    }
    if (isCategory) {
        infoString = sunburstInfoTranslations[d.data.name];
    } else {
        let componentPrefix = sunburstInfoTranslations[d.parent.data.name] +  ": "
        infoString = componentPrefix + "<u>" + d.data.name + "</u>";
    }
    return infoString;
}

function setLabelString(d) {
    let labelString = "";
    let isCategory = false;
    let namesTranslationNeeded = Object.keys(sunburstLabelTranslations);
    if (namesTranslationNeeded.includes( d.data.name)) {
        isCategory = true;
    }
    if (isCategory) {
        labelString = sunburstLabelTranslations[d.data.name];
    }
    return labelString;
}
