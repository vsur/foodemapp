/*
 * Data script for Chord Diagramm Viz
 */

////////////////////////////////////////////////////////////
////////////////// Input verarbeiten ///////////////////////
////////////////////////////////////////////////////////////

var obj = chordDiagramMatrixData;
var matrix_original = matrix;

console.log("chordDiagramMatrixData", chordDiagramMatrixData);

var execInIframe = isInIframe();
console.log("is iFrame", execInIframe);

if(evalMode) {
    console.log("is running in Debug Mode", evalMode);
} 

var screenWidth = $(window).width(),
    mobileScreen = (screenWidth > 400 ? false : true);
var containerWidth = document.querySelector('#ypoisChord').getBoundingClientRect();
var sizingGround = Math.min(containerWidth.width, window.innerHeight)
  
////////////////////////////////////////////////////////////
//////////////// Skalierung der Bereiche ///////////////////
////////////////////////////////////////////////////////////
 
var maxWidthSize = 1140;
var sizingFactor = containerWidth.width / maxWidthSize;

/* 
 * Hilfsfunktion zum Erkennen 
* der Ausführung innerhlalb des iFframes
* Wichtig für Größenangaben
*/
function isInIframe() {
    if ( window.location !== window.parent.location )
    {
      
        // The page is in an iFrames
        return true;
    } 
    else {
        
        // The page is not in an iFrame
        return false;
    }
}

/*
 * Hilfsfunktion zum Berechnen der Summe
 * aller Werte eines Arrays
 */
function sum_array_values(arr) {
    let sum = 0
    for (var i = 0; i < arr.length; i++) {
        sum += arr[i]
    }
    return sum
}

/*
 * Skaliert die Werte innerhalb der Matrix in Abhängigkeit von
 * der Gewichtung, die diesem Bereich zugewiesen wird.
 */
function computeScaling(matrix, start, end, weight) {

    let sum_values = 0;

    // Skalierungsfaktor berechnen
    matrix.slice(start, end + 1).forEach(function(x) {
        sum_values += sum_array_values(x)
    })

    let scale_by = weight / sum_values;

    // Skalierung durchführen
    for (var i = start; i <= end; i++) {
        matrix[i] = matrix[i].map(function(x) {
            return x * scale_by
        })
    }
}

// Skaliert die einzelnen Bereiche
// Tipp: Am besten in Prozenten denken, zusammen immer 100%

// POIs
computeScaling(obj["adjacencyMatrix"],
    0,
    obj["pois"].length - 1,
    50000 // Skalierung
);
// Filtered Components
computeScaling(obj["adjacencyMatrix"],
    obj["pois"].length,
    obj["pois"].length + obj["rankedComponents"].length - 1,
    25000 // Skalierung
);
// Other Components
computeScaling(obj["adjacencyMatrix"],
    obj["pois"].length +
    obj["rankedComponents"].length,
    obj["pois"].length +
    obj["rankedComponents"].length +
    obj["otherComponents"].length - 1,
    25000 // Skalierung
);

////////////////////////////////////////////////////////////
///////////////// Beschreibungen erstellen /////////////////
////////////////////////////////////////////////////////////

var matrix = obj["adjacencyMatrix"]
var anzahl_elemente = obj["adjacencyMatrix"].length + 1
var anzahl_elemente_rechts = obj["pois"].length
var anzahl_elemente_links = anzahl_elemente - anzahl_elemente_rechts;

// pois
// -> name
var header = []
var header_type = []
obj["pois"].forEach(element => {
    header.push(element.name + (element.distance ? (' \u2794 ' + (Math.round(element.distance * 100) / 100) + ' km').replace('.', ',') : ''))
    header_type.push("poi")
});

// rankedComponents
// -> name // Später: display_name
// -> rating "5" (highest), ist bei 6 uhr, "1" (lowest) bei 9 uhr
obj["rankedComponents"].forEach(element => {
    // header.push(element.name)
    header_type.push("rankedComponents")
        // Wenn display_name fertig:
    header.push(element.display_name)
});

// otherComponents
//  -> name // Später: display_name
//  -> switch(componentType)
//   case: 	"BC"
//     -> name
//   case:	"NC"
//     -> this.nominal_component.name + ": " + this.name  // Später: display_name
//   case:	"OC"
//     -> this.ordinal_component.display_name + ": " + this.display_name
obj["otherComponents"].forEach(element => {
    header_type.push("otherComponents")
    if (element.componentType === "BC") {
        header.push(element.display_name)
    } else if (element.componentType === "NC") {
        header.push(element.nominal_component.display_name + ": " + element.display_name)
            // Wenn display_name fertig:
            // header.push(element.nominal_component.display_name + ": " + element.display_name)
    } else if (element.componentType === "OC") {
        header.push(element.ordinal_component.display_name + ": " + element.display_name)
    } else {
        alert("Unknown componentType")
    }

});

////////////////////////////////////////////////////////////
////////////////// Dummy einfügen //////////////////////////
////////////////////////////////////////////////////////////

// Header Dummy-Bezeichnungen einfügen
// Wichtig für Margin links und rechts
header.splice(anzahl_elemente_rechts, 0, "")
header.splice(anzahl_elemente, 0, "")
header_type.splice(anzahl_elemente_rechts, 0, "")
header_type.splice(anzahl_elemente, 0, "")

// Leere Dummy-Zeilen erzeugen
leeres_array_first = []
leeres_array_second = []
for (let i = 0; i < anzahl_elemente - 1; i++) {
    leeres_array_first.push(0);
    leeres_array_second.push(0);
}

// Dummy Zeilen einfügen
matrix.splice(anzahl_elemente_rechts, 0, leeres_array_first)
matrix.splice(anzahl_elemente + 1, 0, leeres_array_second)
matrix_original.splice(anzahl_elemente_rechts, 0, leeres_array_first)
matrix_original.splice(anzahl_elemente + 1, 0, leeres_array_second)

// Dummy-Werte in die einzelnen Spalten der Adjazenzmatrix der originalen Matrix einfügen
for (let i = 0; i < anzahl_elemente + 1; i++) {
    matrix[i].splice(anzahl_elemente_rechts, 0, 0);
    matrix[i].splice(anzahl_elemente, 0, 0);
    matrix_original[i].splice(anzahl_elemente_rechts, 0, 0);
    matrix_original[i].splice(anzahl_elemente, 0, 0);
}

////////////////////////////////////////////////////////////
////////////////// Visualisierung Dummy ////////////////////
////////////////////////////////////////////////////////////

let showDummy = false;
let dummyColor = "none";
let dummyOpacity = 0;

if (showDummy) {
    dummyColor = "#FF0000";
    dummyOpacity = 0.8;
}

respondents = 0

for (let i = 0; i < anzahl_elemente_rechts; i++) {
    for (let j = anzahl_elemente_rechts + 1; j < anzahl_elemente; j++) {
        respondents += matrix[i][j];
    }
}

// Wieviel Platz soll der Dummy einnehmen
var emptyPerc = 0.3,
    emptyStroke = Math.round(respondents * emptyPerc);

// Wert des Dummys-Chords (Bestimmt somit die Breite)
matrix[anzahl_elemente_rechts][anzahl_elemente] = matrix[anzahl_elemente][anzahl_elemente_rechts] = emptyStroke

// Calculate how far the Chord Diagram needs to be rotated clockwise to make the dummy
// invisible chord center vertically
var offset = (2 * Math.PI) * (emptyStroke / (respondents + emptyStroke)) / 4;

////////////////////////////////////////////////////////////
//////////////////////// Set-up ////////////////////////////
////////////////////////////////////////////////////////////

var margin = { left: 50, top: 0, right: 50, bottom: 0 },
    // width = Math.min(screenWidth, 1200) - margin.left - margin.right,
    width = containerWidth.width - margin.left - margin.right,
    // height = (mobileScreen ? 300 : Math.min(screenWidth, 1200) * 5 / 6) - margin.top - margin.bottom;
    height = window.innerHeight - margin.top - margin.bottom;
    console.log("Used containerWidth.width: ", containerWidth.width);
    console.log("Used Widht: ", width);
    console.log("Used Widht: ", height);
    if(evalMode) {
        width = 940 - margin.left - margin.right,
        height = 615 - margin.top - margin.bottom + 1; // Calc Correction
}
console.log("Set Widht: ", width);
console.log("Set Widht: ", height);
var svg = d3.select("#ypoisChord").append("svg")
    .attr("width", (width + margin.left + margin.right))
    .attr("height", (height + margin.top + margin.bottom)-8); // -8 Offset correction, for no-scroll, no clue why.

var wrapper = svg.append("g").attr("class", "chordWrapper")
    .attr("transform", "translate(" + (width / 2 + margin.left) + "," + (height / 2 + margin.top) + ")");

var outerRadius = Math.min(width, height) / 2 - (mobileScreen ? 80 : 100),
    innerRadius = outerRadius * 0.92,
    pullOutSize = 0,
    opacityDefault = 0.6, //default opacity of chords
    opacityLow = 0.1; //hover opacity of those chords not hovered over

// http://paletton.com/#uid=32a0u0kw0w0jyC+oRxVy4oIDfjr
var colors = {
    "poi": "#2196f3",
    "rankedComponents": "#7d003c", // Original Grün
    // "otherComponents": "#4CAF50" // Original Grün
    // "otherComponents": "#00FF04" // Max Contrast (ranked) 7,9:1
    "otherComponents": "#00D900" // Mid Contrast (ranked) 5,68:1
};

var colors_dark = {
    "poi": "#0a6fc2",
    "rankedComponents": "#4d0025",
    "otherComponents": "#367c39"
};

// Finde ich zu dunkel
// var colors_dark = {
// "poi": "#769400",
// "rankedComponents": "#8D0023",
// "otherComponents": "#340669"
// };

////////////////////////////////////////////////////////////
/////////////////// D3 Initialisierung /////////////////////
////////////////////////////////////////////////////////////

var chord = d3.chord()
    .padAngle(0.00)
    .sortSubgroups(d3.descending)
    (matrix);

var arc = d3.arc()
    .cornerRadius(7)
    .innerRadius(innerRadius)
    .outerRadius(outerRadius)
    .startAngle(startAngle)
    .endAngle(endAngle);

var path = stretchedChord()
    .radius(innerRadius)
    .startAngle(startAngle)
    .endAngle(endAngle)
    .pullOutSize(pullOutSize);

////////////////////////////////////////////////////////////
//////////////////// Draw outer Arcs ///////////////////////
////////////////////////////////////////////////////////////

var g = wrapper.selectAll("g.group")
    .data(chord.groups)
    .enter().append("g")
    .attr("class", "group")
    .on("mouseover", fade(opacityLow))
    .on("mouseout", fade(opacityDefault));

g.append("path")
    .style("stroke", function(d, i) {
        if (header[i] === "") {
            return dummyColor
        } else {
            return colors_dark[header_type[i]]
        }
    })
    .style("fill", function(d, i) {
        if (header[i] === "") {
            return dummyColor
        } else {
            return colors[header_type[i]]
        }
    })
    .style("pointer-events", function(d, i) { return (header[i] === "" ? dummyColor : "auto"); })
    .attr("d", arc)
    .attr("transform", function(d, i) {
        //Pull the two slices apart
        d.pullOutSize = pullOutSize * (d.startAngle + 1 > Math.PI ? -1 : 1);
        return "translate(" + d.pullOutSize + ',' + 0 + ")";
    })
    .attr("class", function(d, i) {
        if (i < obj["pois"].length) {
            return "aoi-poi"
        } else if (i >= obj["pois"].length - 1 + 2 && i < obj["pois"].length - 1 + 2 + obj["rankedComponents"].length) {
            return "aoi-choosenComponent";
        } else {
            if (header[i] != "") return "aoi-otherComponent";
        }
    })
    .attr("data-name", function(d, i) {
        if (header[i] != "") return header[i];
    });

////////////////////////////////////////////////////////////
//////////////// Beschreibungen anzeigen ///////////////////
////////////////////////////////////////////////////////////

// The text also needs to be displaced in the horizontal directions
// And also rotated with the offset in the clockwise direction
g.append("text")
    .each(function(d) { d.angle = ((d.startAngle + d.endAngle) / 2) + offset; })
    .attr("dy", "0." + (35 * sizingFactor) + "em")
    .attr("class", "titles")
    .attr("text-anchor", function(d) { return d.angle > Math.PI ? "end" : null; })
    .attr("transform", function(d, i) {
        var c = arc.centroid(d);
        return "translate(" + (c[0] + d.pullOutSize) + "," + c[1] + ")" +
            "rotate(" + (d.angle * 180 / Math.PI - 90) + ")" +
            "translate(" + ( ( execInIframe||evalMode ? 40 : (80 * sizingFactor) ) ) + ",0)" +
            (d.angle > Math.PI ? "rotate(180)" : "")
    })
    .text(function(d, i) {
        let label = header[i];
        chordDiagramMatrixData.rankedComponents.map(c => {
            if (c.display_name == label) {
                if (c.componentType == "NC") {
                    label = c.nominal_component.display_name + ": " + label;
                }
                if (c.componentType == "OC") {
                    label = c.ordinal_component.display_name + ": " + label;
                }
                label = c.rating + ' ★ ' + label;
            }
        });
        return label;
    });

////////////////////////////////////////////////////////////
//////////////////// Draw inner chords /////////////////////
////////////////////////////////////////////////////////////

var chords = wrapper.selectAll("path.chord")
    .data(chord)
    .enter().append("path")
    .attr("class", "chord")
    .style("stroke", "none")
    .style("fill", function(d) {
        if (header_type[d.source.index] === "poi") {
            return "url(#chordGradient-" + d.source.index + "-" + d.target.index + ")";
        } else {
            return "url(#chordGradient-" + d.target.index + "-" + d.source.index + ")";
        }
    })
    // .style("fill", function(d,i) {
    // if (header_type[d.source.index] === "poi") {
    // return colors[header_type[d.target.index]]
    // } else {
    // return colors[header_type[d.source.index]]
    // }
    // })
    .style("opacity", function(d) { return (header[d.source.index] === "" ? dummyOpacity : opacityDefault); }) // Make the dummy strokes have a zero opacity (invisible)
    .style("pointer-events", function(d, i) {
        return "visiblePainted"
        return (header[d.source.index] === "" ? "none" : "auto");
    }) // Remove pointer events from dummy strokes
    .attr("d", path);

////////////////////////////////////////////////////////////
///////////////////////// Tooltip //////////////////////////
////////////////////////////////////////////////////////////

// Arcs
g.append("title")
    .text(function(d, i) {
        return sum_array_values(matrix_original[i]) + " Verbindungen " + header[i]
    });

// Chords
chords.append("title")
    .text(function(d) {
        return header[d.source.index] +
            " + " +
            header[d.target.index];
    });

////////////////////////////////////////////////////////////
////////////////// Extra Functions /////////////////////////
////////////////////////////////////////////////////////////

//Include the offset in de start and end angle to rotate the Chord diagram clockwise
function startAngle(d) {
    return d.startAngle + offset;
}

function endAngle(d) { return d.endAngle + offset; }

// Returns an event handler for fading a given chord group
function fade(opacity) {
    return function(d, i) {
        let connectedArcs = [];
        svg.selectAll("path.chord")
            .filter(function(d) {
                if (d.source.index === i) connectedArcs.push(d.target.index);
                if (d.target.index === i) connectedArcs.push(d.source.index);
                return d.source.index !== i && d.target.index !== i && header[d.source.index] !== "";
            })
            .transition("fadeOnArc")
            .style("opacity", opacity);
        svg.selectAll("g.group")
            .filter(function(d) {
                return d.index !== i && !connectedArcs.includes(d.index);
            })
            .transition("fadeOnArc")
            .style("opacity", (opacity == opacityDefault ? 1 : opacity));
    };
} //fade

////////////////////////////////////////////////////////////
/////////////// Draw Super Categories - ////////////////////
////////////////////////////////////////////////////////////

// POIs
poiStart = 0
poiEnd = anzahl_elemente_rechts - 1

// Ranked Components
filteredAttributesStart = poiEnd + 2 // 2 weil Dummy, +1 wäre index des Dummy
filteredAttributesEnd = filteredAttributesStart + obj["rankedComponents"].length - 1

// Other Components
otherAttributesStart = filteredAttributesEnd + 1
otherAttributesEnd = otherAttributesStart + obj["otherComponents"].length - 1

// Define grouping with colors
var groups = [{
        sIndex: poiStart,
        eIndex: poiEnd,
        title: 'Gefundene Orte',
        color: colors['poi'],
        color_dark: colors_dark['poi']
    },
    {
        sIndex: filteredAttributesStart,
        eIndex: filteredAttributesEnd,
        title: 'Gesuchte Kategorien',
        color: colors['rankedComponents'],
        color_dark: colors_dark['rankedComponents']
    },
    {
        sIndex: otherAttributesStart,
        eIndex: otherAttributesEnd,
        title: 'Übrige Kategorien',
        color: colors['otherComponents'],
        color_dark: colors_dark['otherComponents']
    }
];

var cD = chord.groups;

// Draw arcs
for (var i = 0; i < groups.length; i++) {
    var __g = groups[i];

    var arc1 = d3.arc()
        .cornerRadius(15)
        .innerRadius(innerRadius * 1.13)
        .outerRadius(outerRadius * 1.12)
        .startAngle(

            cD[__g.sIndex].startAngle + offset
        )
        .endAngle(

            cD[__g.eIndex].endAngle + offset
        )

    svg.append("path")
        .attr("d", arc1)
        .attr('fill', __g.color)
        .attr("stroke", __g.color_dark)
        .attr('id', 'groupId' + i)
        .attr("transform",
            "translate(" + (width / 2 + margin.left) + "," + (height / 2 + margin.top) + ")")
        .attr("class", "aoi-move aoi-click");
    
    // Add a text label.
    var text = svg.append("text")
        .attr("x", function(d) {
            if (__g.title === 'Gefundene Orte') {
                if (execInIframe||evalMode) {
                    return 253;
                } else {
                    return ( height/2 * sizingFactor )
                }
            } else {
                if (execInIframe||evalMode) {
                    return 85;
                } else {
                    return ( ( (width / 4) * sizingFactor ) - (__g.title.length * 3.25) )
                }
            }
        })
        .attr("dy", function(d) {
            if (execInIframe||evalMode) {
                return 13;
            } else {
                return 20 * sizingFactor;
            }
        });

    text.append("textPath")
        .attr('fill', '#fff')
        .attr('font-size', '12px')
        .attr('font-weight', '500')
        .attr("xlink:href", "#groupId" + i)
        .text(__g.title);
}

////////////////////////////////////////////////////////////
///////////////////////// TEST /////////////////////////////
////////////////////////////////////////////////////////////
// https://www.visualcinnamon.com/2016/06/orientation-gradient-d3-chord-diagram
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

//Create a gradient definition for each chord
var grads = svg.append("defs").selectAll("linearGradient")
    .data(chord)
    .enter().append("linearGradient")
    //Create a unique gradient id per chord: e.g. "chordGradient-0-4"
    .attr("id", function(d) {
        if (header_type[d.source.index] === "rankedComponents") {
            return "chordGradient-" + d.target.index + "-" + d.source.index;
        } else if (header_type[d.target.index] === "otherComponents") {
            return "chordGradient-" + d.source.index + "-" + d.target.index;
        }
    })
    //Instead of the object bounding box, use the entire SVG for setting locations
    //in pixel locations instead of percentages (which is more typical)
    .attr("gradientUnits", "userSpaceOnUse")
    //The full mathematical formula to find the x and y locations
    //of the Avenger's source chord
    .attr("x1", function(d, i) {
        return innerRadius * Math.cos((d.source.endAngle - d.source.startAngle) / 2 +
            d.source.startAngle - Math.PI / 2);
    })
    .attr("y1", function(d, i) {
        return innerRadius * Math.sin((d.source.endAngle - d.source.startAngle) / 2 +
            d.source.startAngle - Math.PI / 2);
    })
    //Find the location of the target Avenger's chord
    .attr("x2", function(d, i) {
        return innerRadius * Math.cos((d.target.endAngle - d.target.startAngle) / 2 +
            d.target.startAngle - Math.PI / 2);
    })
    .attr("y2", function(d, i) {
        return innerRadius * Math.sin((d.target.endAngle - d.target.startAngle) / 2 +
            d.target.startAngle - Math.PI / 2);
    })

//Set the starting color
grads.append("stop")
    .attr("offset", function(d) {
        if (header_type[d.source.index] === "rankedComponents") {
            return "70%"
        } else if (header_type[d.target.index] === "otherComponents") {
            return "0%"
        }
    })
    .attr("stop-color", function(d) {
        if (header_type[d.source.index] === "rankedComponents") {
            return colors[header_type[d.source.index]]
        } else if (header_type[d.target.index] === "otherComponents") {
            return colors[header_type[d.source.index]]
        }
    });

//Set the ending color
grads.append("stop")
    .attr("offset", function(d) {
        if (header_type[d.source.index] === "rankedComponents") {
            return "100%"
        } else if (header_type[d.target.index] === "otherComponents") {
            return "30%"
        }
    })
    .attr("stop-color", function(d) {
        if (header_type[d.source.index] === "rankedComponents") {
            return colors[header_type[d.target.index]]
        } else if (header_type[d.target.index] === "otherComponents") {
            return colors[header_type[d.target.index]]
        }
    });