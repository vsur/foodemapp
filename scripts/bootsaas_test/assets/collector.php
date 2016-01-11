<!DOCTYPE html>
<html lang="en">
<head>
<!-- 1. Load webcomponents-lite.min.js for polyfill support. -->
<script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<!-- 2. Use an HTML Import to bring in some elements. -->
<link rel="import" href="bower_components/iron-icons/iron-icons.html">
<link rel="import" href="bower_components/paper-styles/paper-styles.html">
<link rel="import" href="bower_components/paper-material/paper-material.html">
<link rel="import" href="bower_components/paper-header-panel/paper-header-panel.html">
<link rel="import" href="bower_components/paper-toolbar/paper-toolbar.html">
<link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
<link rel="import" href="bower_components/paper-menu/paper-menu.html">
<link rel="import" href="bower_components/paper-item/paper-item.html">
<link rel="import" href="bower_components/paper-dropdown-menu/paper-dropdown-menu.html">
<link rel="import" href="bower_components/paper-input/paper-input.html">

<!-- 3. Use also HTML Import to bring in own elements. -->

<title>Start Template for Food Map App</title>

<!-- Bootstrap core CSS -->
<link href="css/fmappstyle.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- 4. Custom Style for Elements -->
<?php include 'inc/polymer_styles.php'; ?>
</head>

<!-- <body class="fullbleed layout vertical" role="document"> -->
<body role="document">

	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Start Data Collector</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="https://github.com/vsur/foodemapp">Find on Git</a></li>
				</ul>
			</div>
		</div>
		<!--  /.container -->
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Hier Polymer Menu Zeug</h1>
				<paper-header-panel>
					<paper-toolbar id="polyBar">
						<paper-icon-button icon="menu" onclick="menuAction"></paper-icon-button>
						<div>Select place and check map</div>
					</paper-toolbar>
				</paper-header-panel>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-md-12">
				<h2>Das Map-Form</h2>
				<polymer-element name="my-menu">
        <template>
            <paper-menu icon="menu">
                <paper-item on-tap="{{refresh}}">Refresh</paper-item>
                <paper-item on-tap="{{help}}">Help</paper-item>
                <paper-item on-tap="{{signOut}}">Sign out</paper-item>
            </paper-menu>
        </template>

        <script>
//             Polymer('my-menu', {
//                 refresh: function () { console.log('Refresh'); },
//                 help: function () { console.log('Help'); },
//                 signOut: function () { console.log('Sign out'); }
//             });
        </script>
    </polymer-element>

    <my-menu></my-menu>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-md-12">
				<h1>Hier ein wenig Inhalt</h1>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-md-12">
				<h1>Hier eine Polymerkarte</h1>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container -->


	<!-- No Bootstrap core JavaScript, cause Polymer shall be integrated
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/fmapp_app.js"></script>
	<script>
	/*alert("What TH F");
	var mapCM = $("#mapChoiceMenu");
	mapCM.click(function(e) {
		alert("TYG");
	});*/
// 		mapCM.addEventListener('tap', function() { 
// 			alert("Should work!");
// 		});
// 	document.addEventListener('WebComponentsReady', function() {
    /*var mapMenu = document.querySelector('#mapChoiceMenu');
    mapMenu.addEventListener('click', function() {
      //greeting.textContent = 'Hello, ' + input.value;
      console.log(this.$$('paper-item.iron-selected'));
      alert("Nun auch mit Elements");
    });*/
// 		 Polymer('mapMenu', {
// 			 showPlace: function () { console.log('Place'); },
// 			 shoTude: function () { console.log('Tude'); }
//    });
//   });
	</script>
</body>
</html>
