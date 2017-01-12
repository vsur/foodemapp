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

    <?php
    $foundData = [];
    /* $handle = fopen("data/yelp_academic_dataset_business.json", "r"); */
    $handle = fopen("data/yelp_karlsruhe_businesses.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Restaurants.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Shopping.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Nightlife.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Bars.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Cafes.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Event-Planning-&-Services.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Active-Life.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Fashion.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Beauty-&-Spas.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Arts-&-Entertainment.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Health-&-Medical.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Hair-Salons.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Home-&-Garden.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Doctors.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Dance-Clubs.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Asian-Fusion.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Mediterranean.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Cocktail-Bars.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_International.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_International.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Bed-&-Breakfast.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Caterers.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Modern-European.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Dive-Bars.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Gastropubs.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Ethnic-Grocery.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Cooking-Schools.json", "r");
    // $handle = fopen("data/yelp_karlsruhe_businesses_Food.json", "r");
    // $handle = fopen("data/smalltest.json", "r");

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

        $recentCategories = $currentObjectLine->categories;

        // Sow Categorization
        /*
        echo '<pre>';
        print_r($recentCategories);
        echo '</pre>';
        */

        foreach ($recentCategories as $category) {
          if(!key_exists($category, $foundData['categories'])) {
            $foundData['categories'][$category] = array(
              'name' => $category,
              'count' => 1
            );
          } else {
            $foundData['categories'][$category]['count'] += 1;
          }
        }

        $recentCity = $currentObjectLine->city;
        if(!key_exists($recentCity, $foundData['cities'])) {
          $foundData['cities'][$recentCity] = array(
            'name' => $recentCity,
            'state' => $currentObjectLine->state,
            'count' => 1
          );
        } else {
          $foundData['cities'][$recentCity]['count'] += 1;
        }

        $recentAttrs = $currentObjectLine->attributes;
        foreach ($recentAttrs as $attrKey => $attrValue) {
          // Add Type if not present yet
          if(!in_array(gettype($attrValue), $foundData['attributes']['types'])) {
            array_push($foundData['attributes']['types'], gettype($attrValue));
          }
          // Add Attribute if not present yet
          if(!key_exists($attrKey, $foundData['attributes']['values'])) {
            switch (gettype($attrValue)) {
              case 'boolean':
              case 'string':
              case 'integer':
              $foundData['attributes']['values'][$attrKey] = array(
              'name' => $attrKey,
              'type' => gettype($attrValue),
              'values' => []
              );
              array_push($foundData['attributes']['values'][$attrKey]['values'], $attrValue);
              break;

              case 'object':
              $foundData['attributes']['values'][$attrKey] = array(
              'name' => $attrKey,
              'type' => gettype($attrValue),
              'values' => [],
              'keys' => []
              );
              foreach ($attrValue as $objectKey => $objectValue) {
                if(!in_array($objectKey, $foundData['attributes']['values'][$attrKey]['keys'])) {
                  array_push($foundData['attributes']['values'][$attrKey]['keys'], $objectKey);
                }
                if(!in_array($objectValue, $foundData['attributes']['values'][$attrKey]['values'])) {
                  array_push($foundData['attributes']['values'][$attrKey]['values'], $objectValue);
                }
              }
              break;

              default:
              array_push($foundData['attributes']['fallOut'], (object)array(
              $attrKey => (object)array(
              'name'  =>  $attrKey,
              'type'  =>  gettype($attrValue),
              'value' =>  $attrValue,
              'count' => 1
              )
              ));
              break;
            }
          } else {
            switch (gettype($attrValue)) {
              case 'boolean':
              case 'string':
              case 'integer':
              if(!in_array($attrValue, $foundData['attributes']['values'][$attrKey]['values'])) {
                array_push($foundData['attributes']['values'][$attrKey]['values'], $attrValue);
              }
              break;

              case 'object':
              foreach ($attrValue as $objectKey => $objectValue) {
                if(!in_array($objectKey, $foundData['attributes']['values'][$attrKey]['keys'])) {
                  array_push($foundData['attributes']['values'][$attrKey]['keys'], $objectKey);
                }
                if(!in_array($objectValue, $foundData['attributes']['values'][$attrKey]['values'])) {
                  array_push($foundData['attributes']['values'][$attrKey]['values'], $objectValue);
                }
              }
              break;

              default:
              $foundData['attributes']['values'][$attrKey]['count'] += 1;
              break;
            }
          }

        }
      }
      fclose($handle);
    } else {
      echo '<script type="text/javascript">console.log("Error on PHP parsing, see LOG");</script>';
    }
    ?>

    <script type="text/javascript">
      var phpParsedJSON = <?php echo json_encode($foundData); ?>;
    </script>

		<div class="row">
			<div id="getCities" class="col-md-6">
        <h3>List of <?php echo count($foundData['cities']); ?> found Cities and apperance</h3>
        <ol type="1" id="cities">
          <?php
            usort($foundData['cities'], function($a, $b) {
              return $b['count'] - $a['count'];
            });
            foreach ($foundData['cities'] as $city) {
              echo '<li>' . $city['name'] . ' in ' . $city['state'] . ' <span class="badge">' .   $city['count']  . '</span></li>';
            }
          ?>
        </ol>
			</div>
			<div id="getCats" class="col-md-6">
        <h3>List of <?php echo count($foundData['categories']); ?> found Categories and apperance</h3>
        <ol type="1" id="categories">
          <?php
            usort($foundData['categories'], function($a, $b) {
              return $b['count'] - $a['count'];
            });
            foreach ($foundData['categories'] as $category) {
              echo '<li>' . $category['name'] . ' <span class="badge">' .  $category['count']  . '</span></li>';
            }
          ?>
        </ol>
			</div>
			<div id="getAttrs" class="col-md-12">
        <h3>Overview about <?php echo count($foundData['attributes']['values']); ?> found Attributes</h3>
        <div class="table-responsive">
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Attribute</th>
                <th>Type</th>
                <th>Values</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $valueIndex = 1;
                foreach ($foundData['attributes']['values'] as $attribute) {
                  echo '<tr>';
                    echo '<td>' . $valueIndex . '</td>';
                    echo '<td>' . $attribute['name'] .'</td>';
                    echo '<td><code class="text-primary">' . $attribute['type'] . '</code></td>';
                    echo '<td>';
                      if( $attribute['type'] == 'boolean') {
                        echo '<p>Found Values</p>';
                        echo '<ul>';
                        foreach ($attribute['values'] as $value) {
                          if($value == 1) {
                            echo '<li><code>TRUE</code></li>';
                          } else {
                            echo '<li><code>FALSE</code></li>';
                          }
                        }
                        echo '</ul>';
                      } else {
                        if( $attribute['type'] == 'object') {
                          echo '<p>Found Object Keys</p>';
                          echo '<ul>';

                          /*
                          echo '<pre>';
                          print_r($attribute);
                          echo '</pre>';
                          */

                          foreach ($attribute['keys'] as $objectKeyValue) {
                            echo '<li>' . $objectKeyValue . '</li>';
                          }
                          echo '</ul>';

                          echo '<hr>';

                          echo '<p>Found Object Value Entries</p>';
                          echo '<ul>';
                          foreach ($attribute['values'] as $objectValueEntry) {
                            if($objectValueEntry == '') {
                              echo '<li><code>FALSE</code></li>';
                            } elseif ($objectValueEntry == 1) {
                              echo '<li><code>TRUE</code></li>';
                            } else {
                              echo '<li>' . $objectValueEntry . '</li>';
                            }
                          }
                          echo '</ul>';
                        } else {
                          echo '<p>Found Values</p>';
                          echo '<ul>';
                          foreach ($attribute['values'] as $value) {
                            echo '<li>' . $value . '</li>';
                          }
                          echo '</ul>';
                        }
                      }
                    echo '</td>';
                  echo '</tr>';
                  $valueIndex++;
                }
              ?>
            </tbody>
          </table>
        </div>
			</div>
      <div id="missedData" class="col-md-12">
        <?php
          echo '<pre>';
          print_r("Found Types");
          print_r($foundData['attributes']['types']);
          if(!empty($foundData['attributes']['fallOut'])) {
            print_r($foundData['attributes']['fallOut']);
          } else {
            echo "No Entries Missed";
          }
          echo '</pre>';
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
