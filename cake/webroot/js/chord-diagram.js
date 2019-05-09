/*
 * Data script for Chord Diagramm Viz
 */
 /*
  * Data script for Chord Diagramm Viz
  */

  var file_sample_data = '../data/sampledata/2018-08-08_10-39-47JSON_Adjacency_Matrix.json';

  // 2018-08-08_10-39-47JSON_Adjacency_Matrix.json
  var json_1 = '[["Bombay Palace","Au\u00dfenbereich_BC_C-ID_77","Indische K\u00fcche_BC_C-ID_60","WLAN: Kostenlos_NC_C-ID_2_NCATTR-ID_4","Lieferung_BC_C-ID_38","Nimmt Reservierungen an_BC_C-ID_94","Restaurants_BC_C-ID_81","Zum Mitnehmen_BC_C-ID_93","Raucher: Au\u00dfen_NC_C-ID_3_NCATTR-ID_8","Preisklasse: 2_OC_C-ID_1_OCATTR-ID_2"],[0,1,1,1,1,1,1,1,1,1],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0]]'

  // 2018-08-08_10-37-10JSON_Adjacency_Matrix.json
  var json_2 = '[["Olive - das kleine Restaurant","Alte Bank","Jacques Meyers Culinarium","Gold","Gelbe Seiten","Kesselhaus","Hong Asia","Im Schlachthof","Bistros_BC_C-ID_20","Au\u00dfenbereich_BC_C-ID_77","Deutsche K\u00fcche_BC_C-ID_48","Restaurants_BC_C-ID_81","Raucher: Nein_NC_C-ID_3_NCATTR-ID_7","Preisklasse: 2_OC_C-ID_1_OCATTR-ID_2","Bedienung_BC_C-ID_102","Gruppenfreundlich_BC_C-ID_50","Kinderfreundlich_BC_C-ID_51","Nimmt Reservierungen an_BC_C-ID_94","Gut f\u00fcr: Mittagessen_NC_C-ID_7_NCATTR-ID_28","Kleidung: L\u00e4ssig_NC_C-ID_1_NCATTR-ID_1","Raucher: Au\u00dfen_NC_C-ID_3_NCATTR-ID_8","WLAN: Nein_NC_C-ID_2_NCATTR-ID_5","Catering Services_BC_C-ID_28","Franz\u00f6sische K\u00fcche_BC_C-ID_47","Hunde erlaubt_BC_C-ID_40","Lieferung_BC_C-ID_38","Mediterrane K\u00fcche_BC_C-ID_70","Zum Mitnehmen_BC_C-ID_93","Parkm\u00f6glichkeiten: Stra\u00dfe_OC_C-ID_2_OCATTR-ID_5","Parkm\u00f6glichkeiten: Parkplatz_OC_C-ID_2_OCATTR-ID_7","Preisklasse: 3_OC_C-ID_1_OCATTR-ID_3","Bars_BC_C-ID_12","Cocktail Bars_BC_C-ID_32","Lounges_BC_C-ID_68","Nachtleben_BC_C-ID_75","Musik: Jukebox_NC_C-ID_6_NCATTR-ID_19","Ger\u00e4uschpegel: Laut_OC_C-ID_3_OCATTR-ID_12","Caf\u00e9s_BC_C-ID_26","F\u00fcr Rollstuhlfahrer_BC_C-ID_103","Raucher: Ja_NC_C-ID_3_NCATTR-ID_9","WLAN: Kostenlos_NC_C-ID_2_NCATTR-ID_4","Ambiente: Romantisch_NC_C-ID_9_NCATTR-ID_40","Gut f\u00fcr: Abendessen_NC_C-ID_7_NCATTR-ID_26","Ger\u00e4uschpegel: Durchschnittlich_OC_C-ID_3_OCATTR-ID_11","Asiatische K\u00fcche_BC_C-ID_6","Chinesische K\u00fcche_BC_C-ID_29","Preisklasse: 1_OC_C-ID_1_OCATTR-ID_1","Musik: Live_NC_C-ID_6_NCATTR-ID_21"],[0,0,0,0,0,0,0,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,1,1,0,1,0,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,1,1,0,1,0,0,1,0,0,1,0,0,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,1,1,0,1,0,1,0,1,1,1,0,1,1,0,0,0,0,0,0,0,1,0,0,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,1,1,0,1,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,1,0,1,1,1,1,1,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,0,1,1,0,1,0,0,1,1,1,1,0,1,1,0,1,0,1,0,0,0,0,1,1,0,0,0,0,0,0,0,1,0,1,1,1,1,0,0,0,0],[0,0,0,0,0,0,0,0,1,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0],[0,0,0,0,0,0,0,0,1,1,0,1,1,1,1,1,1,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,1,0,0,0,1],[1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[1,1,1,1,1,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[1,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[1,1,0,1,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,1,0,1,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,0,1,1,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,1,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,1,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,1,1,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],[0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]]'



  // var json = json_1
  // var anzahl_elemente_rechts = 1

  var json = json_2
  var anzahl_elemente_rechts = 8


  // var obj = JSON.parse(json);
  var obj = matrix;

  var matrix_original = []
  var header;

  var anzahl_elemente = obj.length

  // Werte in Header / Matrix übertragen
  for (let i = 0; i < anzahl_elemente; i++) {
  	if (i == 0) {
  		// Header
  		header = obj[i];
  	} else {
  		matrix_original.push(obj[i]);
  	}
  }

  // Header Dummy-Bezeichnungen einfügen
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






  // Soll Dummy angezeigt werden
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
  	pullOutSize = 100,
  	opacityDefault = 0.7, //default opacity of chords
  	opacityLow = 0.02; //hover opacity of those chords not hovered over

  ////////////////////////////////////////////////////////////
  ////////////////////////// Data ////////////////////////////
  ////////////////////////////////////////////////////////////

  // var Names = ["X","Y","","C","B","A","F","G",""];

  // var respondents = 100, //Total number of respondents (i.e. the number that makes up the total group)
  // 	emptyPerc = 0.4, //What % of the circle should become empty
  // 	emptyStroke = Math.round(respondents*emptyPerc);
  // var matrix = [
  // 	[0,0,0,10,5,15,20,5,0], //X
  // 	[0,0,0,5,15,20,10,5,0], //Y
  // 	[0,0,0,0,0,0,0,0,emptyStroke], //Dummy stroke
  // 	[10,5,0,0,0,0,0,0,0], //C
  // 	[5,15,0,0,0,0,0,0,0], //B
  // 	[15,20,0,0,0,0,0,0,0], //A

  // 	[20,10,0,0,0,0,0,0,0], //F
  // 	[5,5,0,0,0,0,0,0,0], //G

  // 	[0,0,emptyStroke,0,0,0,0,0,0] //Dummy stroke
  // ];

  debug_randomize = false
  if(debug_randomize)
  {
  	var anzahl_elemente_links = 10;
  	var anzahl_elemente_rechts = 2;
  	var amountOfElements = anzahl_elemente_rechts + anzahl_elemente_links + 2; // +2 wegen Dummy-Elementen

  	var respondents = 0;
  	var Names = [];
  	// Names = header;
  	// var Names = ["X","Y","Z","","C","B","A",""];
  	var matrix = [];

  	for(let i = 0; i < amountOfElements; i++) {
  		let row = [];
  		for(let j = 0; j < amountOfElements; j++) {
  			let number;


  			// DUMMY START
  			if (i == anzahl_elemente_rechts && j == amountOfElements - 1) {
  				// Letzte Spalte Mittlere Zeile
  				number = 50;
  			}
  			else if (j == anzahl_elemente_rechts && i == amountOfElements - 1) {
  				// Mittlere Spalte Letzte Zeile
  				number = 50;
  			}
  			else if (j == anzahl_elemente_rechts) {
  				// Mittlere Spalte
  				number = 0;
  			}
  			else if (i == anzahl_elemente_rechts) {
  				// Mittlere Zeile
  				number = 0;
  			}
  			else if (j == amountOfElements - 1) {
  				// Letzte Spalte
  				number = 0;
  			}
  			else if (i == amountOfElements - 1) {
  				// Letzte Zeile
  				number = 0;
  			}
  			// DUMMY END




  			else if (i < anzahl_elemente_rechts && j < anzahl_elemente_rechts) {
  				// Verweis auf eigene Gruppe, links
  				number = 0;
  			} else if (i > anzahl_elemente_rechts && j > anzahl_elemente_rechts) {
  				// Verweis auf eigene Gruppe, rechts
  				number = 0;
  			}
  			else {
  				// Normale Zeile
  				number = 5;
  				// number = "" + i + j
  				respondents += number;
  			}

  			row[j] = number;
  		}

  		if (i == anzahl_elemente_rechts || i == amountOfElements - 1) {
  			// Dummy Zeile
  			Names.push("");
  		} else {
  			Names.push("XXX");
  		}

  		matrix.push(row);
  	}

  	// console.log(matrix);

  	// console.log(respondents)
  	// Werte zusammenaddieren
  	// Durch 2, da sonst Ziel UND Ursprung gezählt werden
  	respondents = respondents / 2
  }
  else
  {
  	// DEBUG START
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
  		let counter = 0
  		for(let j = anzahl_elemente_rechts + 1; j < anzahl_elemente; j++) {
  			counter += matrix_original[i][j];
  			respondents += matrix_original[i][j];
  		}

  		// console.log(counter)
  	}

  	// console.log("Respondents: " + respondents)
  	// console.log("Header: " + header.length)
  }
  // DEBUG END

  // DEBUG START
  // var matrix = [
  	// [0,0,0,0,10,5,15,0], //X
  	// [0,0,0,0,5,15,20,0], //Y
  	// [0,0,0,0,15,5,5,0], //Z
  	// [0,0,0,0,0,0,0,emptyStroke], //Dummy stroke
  	// [10,5,15,0,0,0,0,0], //C
  	// [5,15,5,0,0,0,0,0], //B
  	// [15,20,5,0,0,0,0,0], //A
  	// [0,0,0,emptyStroke,0,0,0,0] //Dummy stroke
  // ];
  // respondents = 95
  // DEBUG END


  //What % of the circle should become empty
  var emptyPerc = 0.6,
  	emptyStroke = Math.round(respondents * emptyPerc);

  	// console.log("emptyStroke: " + emptyStroke)
  	// console.log("respondents: " + respondents)
  	// console.log("emptyStroke/(respondents + emptyStroke): " + emptyStroke/(respondents + emptyStroke))

  // Dummy Stroke, damit wird es gerade gerichtet
  matrix[anzahl_elemente_rechts][amountOfElements - 1] = matrix[amountOfElements - 1][anzahl_elemente_rechts] = emptyStroke

  //Calculate how far the Chord Diagram needs to be rotated clockwise to make the dummy
  //invisible chord center vertically
  var offset = (2 * Math.PI) * (emptyStroke / (respondents + emptyStroke)) / 4;

  // anzahl_elemente_links = anzahl_elemente - anzahl_elemente_links - 1
  padding_between_arcs = 0.00 // Angabe in rad
  difference = anzahl_elemente_links - anzahl_elemente_rechts

  // HOW?
  // rotate_by = difference * padding_between_arcs
  // rotate_by = (2 * Math.PI) * (emptyStroke/(respondents + emptyStroke)) / 4;
  rotate_by = 1

  // console.log("offset before: " + offset)
  // console.log("anzahl_elemente_links: " + anzahl_elemente_links)
  // console.log("anzahl_elemente_rechts: " + anzahl_elemente_rechts)
  // console.log("difference: " + difference)
  // console.log("rotate: " + rotate_by)

  // wie :)
  // offset *= (1 + rotate_by/2)
  var offset_test = 0.4;
  // ca 1.7

  // offset += offset_test

  // Sollte ca. sein:
  // offset = 0.672
  // console.log("offset after calc: " + offset_test)
  // console.log(offset_test + offset)











  var chord = d3.layout.chord()
  	.padding(padding_between_arcs)
  	// .padding(1)
  	// .sortSubgroups(d3.descending) //sort the chords inside an arc from high to low
  	.sortChords(d3.descending) //which chord should be shown on top when chords cross. Now the biggest chord is at the bottom
  	.matrix(matrix);

  var arc = d3.svg.arc()
  	.innerRadius(innerRadius)
  	.outerRadius(outerRadius)
  	.startAngle(startAngle) //startAngle and endAngle now include the offset in degrees
  	.endAngle(endAngle);

  var path = stretchedChord()
  	.radius(innerRadius)
  	.startAngle(startAngle)
  	.endAngle(endAngle)
  	.pullOutSize(pullOutSize);

  var fill = d3.scale.ordinal()
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

  //+ "translate(" + (innerRadius + 55) + ")"

  ////////////////////////////////////////////////////////////
  //////////////////// Draw inner chords /////////////////////
  ////////////////////////////////////////////////////////////

  var chords = wrapper.selectAll("path.chord")
  	.data(chord.chords)
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
  	calc = d.startAngle + offset;
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
