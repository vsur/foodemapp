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
			<h1>Get data from Yelp Categories</h1>
			<p>Yelp Dataset Chalange Offers a 69 MB JSON file Of Business Data.</p>
		</div>
    <div class="row">
      <div class="col-md-12">
        <?php
        $foundData = [];
        $handle = fopen("data/yelp_academic_dataset_business.json", "r");
        // $handle = fopen("data/smalltest.json", "r");

        $counter = 1;
        $karlsruheCounter = 1;
        $outputFile = 'data/yelp_karlsruhe_businesses.json';
        if (file_exists($outputFile)) { unlink ($outputFile); }
        if ($handle) {
          $foundData['categories'] = [];
          $foundData['cities'] = [];
          $foundData['attributes'] = array(
            'types' => [],
            'values' => [],
            'fallOut' => []
          );
          while (($line = fgets($handle)) !== false) {

            $currentObjectLine = json_decode($line);
            $recentState = $currentObjectLine->state;
            if($recentState == "BW") {
              $karlsruheCounter++;
              file_put_contents($outputFile, $line, FILE_APPEND | LOCK_EX);
            }
            $counter++;
          }
          fclose($handle);
        } else {
          echo '<script type="text/javascript">console.log("Error on PHP parsing, see LOG");</script>';
        }
        echo "<h3>In $counter Einträgen $karlsruheCounter Karlsruheeinträge gefunden!</h3>";
        ?>
      </div>
		</div>
	</div> <!-- /.container -->

	<!-- No Bootstrap core JavaScript, cause Polymer shall be integrated
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/fmapp_yelp.js"></script>
</body>
</html>
