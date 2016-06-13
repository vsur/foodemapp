/*
 * Data script for Pie Chat Viz
 */

  // Setting base for the chart
  var width = 600,
      height = 300,
      radius = Math.min(width, height) / 2;

  var donutWidth = 75;

  var legendRectSize = 18;
  var legendSpacing = 4;

  // Setting the colors for each segment

  function drawPie(poiData) {
    var color =  d3.scale.category10();
    // Setting the SVG Element and its paths
    var svg = d3.select('#poi_' + poiData.google_place + '_PieChart')
     .append('svg')
     .attr('width', width)
     .attr('height', height)
     .append('g')
    //  .attr('transform', 'translate(' + (width / 2) +  ',' + (height / 2) + ')');
     .attr('transform', 'translate(' + (height / 2) +  ',' + (height / 2) + ')');

    // Now it is all about the pie itself
    var arc = d3.svg.arc()
     .outerRadius(radius - 10)
     .innerRadius(radius - donutWidth);

     var labelArc = d3.svg.arc()
       .outerRadius(radius - 40)
       .innerRadius(radius - 40);

    // Setting pie to get data in chart
    var pie = d3.layout.pie()
     .value(function(d) { return d._joinData.rating; })
     .sort(null);
    var dataset = poiData.components;

    var g = svg.selectAll('.arc')
      .data(pie(dataset))
      .enter()
      .append("g")
      .attr("class", "arc");

    g.append('path')
      .attr('d', arc)
      .attr('fill', function(d, i) {
        return color(d.data.name + " " + d.data._joinData.rating * 10 + "%");
      });
    g.append("text")
      .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .text(function(d) {
        var shortendLabel = d.data.name.length < 10 ? d.data.name : d.data.name.slice(0,7) + "…";
        return shortendLabel;
      });

      console.log(color.domain());

    var legend = svg.selectAll('.legend')
      .data(color.domain())
      .enter()
      .append('g')
      .attr('class', 'legend')
      .attr('transform', function(d, i) {
        var height = legendRectSize + legendSpacing;
        // var offset =  height * color.domain().length / 2;
        var offset =  height * color.domain().length / 2;
        var horz = -2 * legendRectSize; horz += 200;
        var vert = i * height - offset;
        return 'translate(' + horz + ',' + vert + ')';
      });

    legend.append('rect')
      .attr('width', legendRectSize)
      .attr('height', legendRectSize)
      .style('fill', color)
      .style('stroke', color);

    legend.append('text')
      .attr('x', legendRectSize + legendSpacing)
      .attr('y', legendRectSize - legendSpacing)
      .text(function(d) { return d; });
  }
