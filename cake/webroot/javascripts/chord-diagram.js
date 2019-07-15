/*
 * Data script for Chord Diagramm Viz
 */

 ////////////////////////////////////////////////////////////
 ////////////////// Input verarbeiten ///////////////////////
 ////////////////////////////////////////////////////////////

 var matrix_original = chordDiagramMatrixData["adjacencyMatrix"]
 var anzahl_elemente = chordDiagramMatrixData["adjacencyMatrix"].length + 1
 var anzahl_elemente_rechts = chordDiagramMatrixData["pois"].length
 var anzahl_elemente_links = anzahl_elemente - anzahl_elemente_rechts;

 // pois
 // -> name
 var header = []
 chordDiagramMatrixData["pois"].forEach(element => {
 	header.push(element.name)
 });

 // rankedComponents
 // -> name // Später: display_name
 // -> rating "5" (highest), ist bei 6 uhr, "1" (lowest) bei 9 uhr
 chordDiagramMatrixData["rankedComponents"].forEach(element => {
 	header.push(element.name)
 	// Wenn display_name fertig:
 	// header.push(element.display_name)
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
 chordDiagramMatrixData["otherComponents"].forEach(element => {
 	if (element.componentType === "BC") {
 		header.push(element.name)
 	} else if (element.componentType === "NC") {
 		header.push(element.nominal_component.name + ": " + element.name)
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

 // Leere Dummy-Zeilen erzeugen
 leeres_array_first = []
 leeres_array_second = []
 for (let i = 0; i < anzahl_elemente - 1; i++) {
 	leeres_array_first.push(0);
 	leeres_array_second.push(0);
 }

 // Dummy Zeilen einfügen
 matrix_original.splice(anzahl_elemente_rechts, 0, leeres_array_first)
 matrix_original.splice(anzahl_elemente + 1, 0, leeres_array_second)

 // Dummy-Werte in die einzelnen Spalten der Adjazenzmatrix der originalen Matrix einfügen
 for (let i = 0; i < anzahl_elemente + 1; i++) {
 	matrix_original[i].splice(anzahl_elemente_rechts, 0, 0);
 	matrix_original[i].splice(anzahl_elemente, 0, 0);
 }

 // Dummy Verbindungswerte
 dummy_value = 50
 matrix_original[anzahl_elemente_rechts][anzahl_elemente] = dummy_value
 matrix_original[anzahl_elemente][anzahl_elemente_rechts] = dummy_value

 ////////////////////////////////////////////////////////////
 ////////////////// Dummy anzeigen //////////////////////////
 ////////////////////////////////////////////////////////////

 let showDummy = false;
 let dummyColor = "none";
 let dummyOpacity = 0;

 if (showDummy) {
 	dummyColor = "#FF0000";
 	dummyOpacity = 0.8;
 }

 ////////////////////////////////////////////////////////////
 //////////////////////// Set-up ////////////////////////////
 ////////////////////////////////////////////////////////////

 var screenWidth = $(window).width(),
 	mobileScreen = (screenWidth > 400 ? false : true);

 var margin = {left: 50, top: 10, right: 50, bottom: 10},
 	width = Math.min(screenWidth, 1200) - margin.left - margin.right,
 	height = (mobileScreen ? 300 : Math.min(screenWidth, 1200)*5/6) - margin.top - margin.bottom;

 var svg = d3.select("#ypoisChord").append("svg")
 			.attr("width", (width + margin.left + margin.right))
 			.attr("height", (height + margin.top + margin.bottom));

 var wrapper = svg.append("g").attr("class", "chordWrapper")
 			.attr("transform", "translate(" + (width / 2 + margin.left) + "," + (height / 2 + margin.top) + ")");;

 var outerRadius = Math.min(width, height) / 2  - (mobileScreen ? 80 : 100),
 	innerRadius = outerRadius * 0.95,
 	pullOutSize = 0,
 	opacityDefault = 0.7, //default opacity of chords
 	opacityLow = 0.02; //hover opacity of those chords not hovered over

 ////////////////////////////////////////////////////////////
 ////////////////////////// Data ////////////////////////////
 ////////////////////////////////////////////////////////////

 Names = header;
 matrix = matrix_original
 // console.log("amountOfElements: " + amountOfElements)
 // console.log("anzahl_elemente_rechts: " + anzahl_elemente_rechts)
 amountOfElements = anzahl_elemente + 1
 // anzahl_elemente_rechts = amountOfElements - anzahl_elemente_links - 1
 // console.log("amountOfElements: " + amountOfElements)
 // console.log("anzahl_elemente_rechts: " + anzahl_elemente_rechts)
 respondents = 0

 for(let i = 0; i < anzahl_elemente_rechts; i++) {
 	for(let j = anzahl_elemente_rechts + 1; j < anzahl_elemente; j++) {
 		respondents += matrix_original[i][j];
 	}
 }

 //What % of the circle should become empty
 var emptyPerc = 0.6,
 	emptyStroke = Math.round(respondents * emptyPerc);

 // Dummy Stroke, damit wird es gerade gerichtet
 matrix[anzahl_elemente_rechts][amountOfElements - 1] = matrix[amountOfElements - 1][anzahl_elemente_rechts] = emptyStroke

 //Calculate how far the Chord Diagram needs to be rotated clockwise to make the dummy
 //invisible chord center vertically
 var offset = (2 * Math.PI) * (emptyStroke / (respondents + emptyStroke)) / 4;

 // anzahl_elemente_links = anzahl_elemente - anzahl_elemente_links - 1
 padding_between_arcs = 0.00 // Angabe in rad
 difference = anzahl_elemente_links - anzahl_elemente_rechts

 // HOW?
 rotate_by = 1

 var offset_test = 0.4;

 ////////////////////////////////////////////////////////////
 /////////////////// D3 Initialisierung /////////////////////
 ////////////////////////////////////////////////////////////

 var chord = d3.chord()
 	.padAngle(padding_between_arcs)
 	// .padding(1)
 	// .sortSubgroups(d3.descending) //sort the chords inside an arc from high to low
 	.sortSubgroups(d3.descending) //which chord should be shown on top when chords cross. Now the biggest chord is at the bottom
 	(matrix);

 var arc = d3.arc()
 	.innerRadius(innerRadius)
 	.outerRadius(outerRadius)
 	.startAngle(startAngle) //startAngle and endAngle now include the offset in degrees
 	.endAngle(endAngle);

 var path = stretchedChord()
 	.radius(innerRadius)
 	.startAngle(startAngle)
 	.endAngle(endAngle)
 	.pullOutSize(pullOutSize);

 var fill = d3.scaleOrdinal()
     .domain(d3.range(Names.length))
     .range(["#C4C4C4","#C4C4C4","#C4C4C4","#E0E0E0","#EDC951","#CC333F","#00A0B0","#E0E0E0"]);

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
 	.style("stroke", function(d,i) { return (Names[i] === "" ? dummyColor : "#00A1DE"); })
 	.style("fill", function(d,i) { return (Names[i] === "" ? dummyColor : "#00A1DE"); })
 	.style("pointer-events", function(d,i) { return (Names[i] === "" ? dummyColor : "auto"); })
 	.attr("d", arc)
 	.attr("transform", function(d, i) {
 		//Pull the two slices apart
 		d.pullOutSize = pullOutSize * ( d.startAngle + 1 > Math.PI ? -1 : 1);
 		return "translate(" + d.pullOutSize + ',' + 0 + ")";
 	});

 ////////////////////////////////////////////////////////////
 ////////////////////// Append Names ////////////////////////
 ////////////////////////////////////////////////////////////

 //The text also needs to be displaced in the horizontal directions
 //And also rotated with the offset in the clockwise direction
 g.append("text")
 	.each(function(d) { d.angle = ((d.startAngle + d.endAngle) / 2) + offset;})
 	.attr("dy", ".35em")
 	.attr("class", "titles")
 	.attr("text-anchor", function(d) { return d.angle > Math.PI ? "end" : null; })
 	.attr("transform", function(d,i) {
 		var c = arc.centroid(d);
 		return "translate(" + (c[0] + d.pullOutSize) + "," + c[1] + ")"
 		+ "rotate(" + (d.angle * 180 / Math.PI - 90) + ")"
 		+ "translate(" + 55 + ",0)"
 		+ (d.angle > Math.PI ? "rotate(180)" : "")
 	})
   .text(function(d,i) { return Names[i]; });

 ////////////////////////////////////////////////////////////
 //////////////////// Draw inner chords /////////////////////
 ////////////////////////////////////////////////////////////

 var chords = wrapper.selectAll("path.chord")
     .data(chord)
     .enter().append("path")
     .attr("class", "chord")
     .style("stroke", "none")
     .style("fill", "#C4C4C4")
     .style("opacity", function(d) { return (Names[d.source.index] === "" ? dummyOpacity : opacityDefault); }) //Make the dummy strokes have a zero opacity (invisible)
     .style("pointer-events", function(d,i) { return (Names[d.source.index] === "" ? "none" : "auto"); }) //Remove pointer events from dummy strokes
     .attr("d", path);
     
 ////////////////////////////////////////////////////////////
 ///////////////////////// Tooltip //////////////////////////
 ////////////////////////////////////////////////////////////

 //Arcs
 g.append("title")
 	.text(function(d, i) {return Math.round(d.value) + " people in " + Names[i];});

 //Chords
 chords.append("title")
 	.text(function(d) {
 		return [Math.round(d.source.value), " people from ", Names[d.target.index], " to ", Names[d.source.index]].join("");
 	});

 ////////////////////////////////////////////////////////////
 ////////////////// Extra Functions /////////////////////////
 ////////////////////////////////////////////////////////////

 //Include the offset in de start and end angle to rotate the Chord diagram clockwise
 function startAngle(d) {
 	// calc = d.startAngle + offset;
 	// console.log("d.startAngle: " + d.startAngle + "  - offset: " + offset);
 	return d.startAngle + offset; }
 function endAngle(d) { return d.endAngle + offset; }

 // Returns an event handler for fading a given chord group
 function fade(opacity) {
   return function(d, i) {
 	svg.selectAll("path.chord")
 		.filter(function(d) { return d.source.index !== i && d.target.index !== i && Names[d.source.index] !== ""; })
 		.transition("fadeOnArc")
 		.style("opacity", opacity);
   };
 }//fade

 ////////////////////////////////////////////////////////////
 //////// Draw Super Categories - By Faraz Shuja ////////////
 ////////////////////////////////////////////////////////////

 // POIs
 poiStart = 0
 poiEnd = anzahl_elemente_rechts - 1

 // Ranked Components
 filteredAttributesStart = poiEnd + 2 // 2 weil Dummy
 filteredAttributesEnd = filteredAttributesStart + chordDiagramMatrixData["rankedComponents"].length

 // Other Components
 otherAttributesStart = filteredAttributesEnd + 1
 otherAttributesEnd = otherAttributesStart + chordDiagramMatrixData["otherComponents"].length - 2 // 2 weil Dummy

 // Define grouping with colors
 var groups = [
 	{sIndex: poiStart, eIndex: poiEnd, title: 'POIs', color: '#FF0000'},
 	{sIndex: filteredAttributesStart, eIndex: filteredAttributesEnd, title: 'Filtered Components', color: '#00FF00'},
 	{sIndex: otherAttributesStart, eIndex: otherAttributesEnd, title: 'Other Components', color: '#0000FF'}
 ];

 var cD = chord.groups;

 // Draw arcs
 for(var i=0;i<groups.length;i++) {
 	var __g = groups[i];

 	var arc1 = d3.arc()
 		.innerRadius(innerRadius * 1.1)
 		.outerRadius(outerRadius * 1.11)
 		.startAngle(

 			cD[__g.sIndex].startAngle + offset
 		)
 		.endAngle(

 			cD[__g.eIndex].endAngle + offset
 		)

 	svg.append("path")
 		.attr("d", arc1)
 		.attr('fill', __g.color)
 		.attr('id', 'groupId' + i)

 		.attr("transform",
 			  "translate(" + (width / 2 + margin.left) + "," + (height / 2 + margin.top) + ")");

 	// Add a text label.
 	var text = svg.append("text")
 		.attr("x", 200)
 		.attr("dy", 13);

 	text.append("textPath")
 		.attr("stroke","#000")
 		.attr('fill', '#000')
 		.attr("xlink:href","#groupId" + i)
 		.text(__g.title);
 }
