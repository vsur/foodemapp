<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>Get overview of Yelp Categories</title>

<!-- Bootstrap core CSS -->
<link href="css/fmappdata.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body role="document">

	<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Yelp DataCollector · Categories</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Categories</a></li>
					<li><a href="get_yelp_reviews.php">Reviews</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container" role="main">

		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h1>Get Category POIs from Karlsruhe POIS</h1>
			<p>Yelp Dataset Chalange Offers a 862 KB JSON file of Business Data in Karlsruhe.</p>
		</div>
    <div class="row">
      <div class="col-md-12">
        <?php
        $foundData = [];
        $karlsruheFile = "yelp_karlsruhe_businesses";
        $choosenCategory = "NOTHING";
        if(!empty($_GET)) {
          $choosenCategory = $_GET["cat"];
          $handle = fopen("data/" . $karlsruheFile . ".json", "r");
          // $handle = fopen("data/smalltest.json", "r");

          $counter = 1;
          $categoryCounter = 0;
          $outputFile = 'data/' . $karlsruheFile . '_' . $choosenCategory . '.json';
          if (file_exists($outputFile)) { unlink ($outputFile); }
          if ($handle) {
            while (($line = fgets($handle)) !== false) {

              $currentObjectLine = json_decode($line);
              $recentState = $currentObjectLine->state;
              if(in_array($choosenCategory, $currentObjectLine->categories) != false) {
                $categoryCounter++;
                file_put_contents($outputFile, $line, FILE_APPEND | LOCK_EX);
              }
              $counter++;
            }
            fclose($handle);
          } else {
            echo '<script type="text/javascript">console.log("Error on PHP parsing, see LOG");</script>';
          }
          echo "<h3>In $counter Karlsruhe-Einträgen $categoryCounter $choosenCategory-Einträge gefunden!</h3>";
        } else {
          $karlsruheFile = "yelp_karlsruhe_businesses";
          $handle = fopen("data/" . $karlsruheFile . ".json", "r");
          $counter = 1;
          // Hier Weiter nur foreach über jede Vat in Zeile!
          if ($handle) {
            while (($line = fgets($handle)) !== false) {
              $currentObjectLine = json_decode($line);
              foreach ($currentObjectLine->categories as $category) {
                $category = str_replace(" ", "-", $category);
                $category = str_replace("/", "_", $category);
                $outputFile = 'data/' . $karlsruheFile . '_' . $category . '.json';
                // if (!file_exists($outputFile)) {
                //     fopen($outputFile, "w");
                // }
                file_put_contents($outputFile, $line, FILE_APPEND | LOCK_EX);
              }
              $counter++;
            }
            fclose($handle);
          } else {
            echo '<script type="text/javascript">console.log("Error on PHP parsing, see LOG");</script>';
          }
          echo "<h3>$counter Karlsruhe-Einträgen komplett auf Kategorien aufgeteilt!</h3>";

        }
        ?>
      </div>
		</div>
	</div> <!-- /.container -->

	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/fmapp_yelp.js"></script>
</body>
</html>
