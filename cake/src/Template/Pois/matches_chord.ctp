<?=
  $this->element('navbar',
  [
    "step" => "Trefferanzeige",
    "vizElement" => '<li>' . $this->Html->link(__('‹ Komponenten'), ['controller' => 'Components', 'action' => 'choose', '_full' => true]) . "</li>\n" .
                    '<li><a href="../matchesPie/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Donutdiagramme">‹ Donut</a>' . "</li>\n" .
                    '<li><a href="../matchesAster/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Aster-Plot-Diagramme">‹ Aster</a>' . "</li>\n" .
                    '<li><a href="../matchesBar/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Balkendiagramme">‹ Balken</a>' . "</li>\n" .
                    '<li><a href="../matchesTreemap/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Treemapvisualisierung">‹ Treemap</a>' . "</li>\n" .
                    "<li class=\"active\"><a href=\"#\">POIs</a></li>\n" .
                    '<li><a href="../matchesSunburst/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Sunburst-Diagramm-Visualisierung">Sunburst-Diagramm ›</a>' . "</li>\n" .
                    '<li><a href="../matchesMapDia/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Karte">Kartenansicht ›</a>' . "</li>\n"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<script type="text/javascript">
  var pois = <?= json_encode($pois) ?>;
  var componentsList = [];
  var poiComponentMatrix = [];
  console.log(pois);
  for (var i in pois) {
    var poisComponents = pois[i].components;
    for (var j in poisComponents) {
      if (componentsList.indexOf(poisComponents[j].name) < 0) {
        componentsList.push(poisComponents[j].name);
      }
    }
  }
  // Vorsicht hier stimmt Logik nicht!
  // Iterate over all POIs again
  for (var i in pois) {
    var recentPoisMatrixEntries = [];
    var poisComponents = pois[i].components;
    // Iterate over all items of componentsList
    // To get any kind of matrix similar to this
    /*
    poi_1, componentslist_1, rating if exist in poi_1
    poi_2, componentsList_2, rating if exist in poi_2
    poi_3, componentsList_3, rating if exist in poi_3
    */
    for (var j in componentsList) {
      // Check if recent componentsList entry is present in any pois component
      // Iterate over Compents and save indexOf
      var presentComponent = null;
      for (var k in poisComponents) {
        if (componentsList[j] == poisComponents[k].name) {
          presentComponent = poisComponents[k];
        }
      }
      if (presentComponent != null) {
        // console.log("Aktueller Component " + componentsList[j] + " in " + pois[i].name + " enthalten." );
        recentPoisMatrixEntries.push([
          pois[i].name, componentsList[j], presentComponent._joinData.rating
        ]);
      } else {
        recentPoisMatrixEntries.push([
          pois[i].name, componentsList[j], 0.0
        ]);
      }
    }
    poiComponentMatrix.push([
      pois[i].name, recentPoisMatrixEntries
    ]);
  }
  // console.log(poiComponentMatrix);
  // TODO
  // Nun ein o0-Array für alle Pois bauen
  // Dann ein 0-Array für alle Components bauen und dann über der poiComponentMatrix iterrieren und alles befüllen
  var helpMatrix = [];
  var poisNames = [];
  var poisFillArray = [];
  for (var i = 0; i < pois.length; i++) {
    poisNames.push(pois[i].name);
    poisFillArray.push(0.0);
  }
  helpMatrix.push(poisNames, poisFillArray);
  // console.log(helpMatrix);
  var componentsFillArray = []
  for (var i = 0; i < componentsList.length; i++) {
    componentsFillArray.push(0.0);
  }
  helpMatrix = [];
  helpMatrix.push(componentsList, componentsFillArray);
  // console.log(helpMatrix);
  var matrix = [
    [12000, 10000, 8916, 2868],
    [ 1951, 10048, 2060, 6171],
    [ 8010, 16145, 8090, 8045],
    [ 1013,   990,  940, 6907]
  ];
  helpMatrix = [];
  // Create all rows for pois
  poiComponentMatrix.forEach(function(poiArray) {
    var recentPoiRow = [];
    var componentRows = poiArray[1];
    poisFillArray.forEach(function(i) {
      recentPoiRow.push(i);
    });
    componentRows.forEach(function(singleRow) {
      recentPoiRow.push(singleRow[2]);
    });
    helpMatrix.push(recentPoiRow);
  });
  // Create rows for components
  componentsList.forEach(function(componentName, i) {
    var poiComponentMatrixComponentsIndex = i + poisFillArray.length;
    // console.log(poiComponentMatrixComponentsIndex);
    // console.log(poiComponentMatrix);
    var poiValueArray = [];
    poiComponentMatrix.forEach(function(poiArray, j) {
      poiValueArray.push(poiArray[1][i][2]);
    });
    console.log(poiValueArray);
    var recentComponentRow = [];
    // recentComponentRow = poisFillArray.concat(componentsFillArray);
    recentComponentRow = poiValueArray.concat(componentsFillArray);
    helpMatrix.push(recentComponentRow)
  });
  console.log(helpMatrix);
  matrix = helpMatrix;

</script>


<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>

<div class="container" role="main">



<!-- ///////////////////////////
// Sortierungs-Block //
/////////////////////////// -->
<div class="row">
  <div class="col-md-3">
    <p><a href="#" class="btn btn-default disabled"  style="width:100%;" role="button">Sortierung<span class="hidden-md">(Standard = Rating) →</span></a><p>
    </div>
  <div class="col-md-3">
    <?=
      $this->Html->link(
        'Rating',
        // Create Link
        [
          'controller' => 'Pois',
          'action' => 'matchesChord',
          // "OR",
          "Rating",
          "?" => $this->request->query
        ],
        // Optoins array
        [
          'class' => ( ( !(array_key_exists(0, $this->request->pass)) ) ? true : $this->request->pass[0] == "Rating" ) ? 'btn btn-success' : 'btn btn-warning',
          'style' => 'width:100%;'
        ]
      );
    ?>
    </div>
  <div class="col-md-3">
    <?=
      $this->Html->link(
        'A-Z',
        // Create Link
        [
          'controller' => 'Pois',
          'action' => 'matchesChord',
          // "OR",
          "AlphaASC",
          "?" => $this->request->query
        ],
        // Optoins array
        [
          'class' => ( ( !(array_key_exists(0, $this->request->pass)) ) ? false : $this->request->pass[0] == "AlphaASC" ) ? 'btn btn-success' : 'btn btn-warning',
          'style' => 'width:100%;'
        ]
      );
    ?>
    </div>
  <div class="col-md-3">
    <?=
      $this->Html->link(
        'Z-A',
        // Create Link
        [
          'controller' => 'Pois',
          'action' => 'matchesChord',
          // "OR",
          "AlphaDESC",
          "?" => $this->request->query
        ],
        // Optoins array
        [
          'class' => ( ( !(array_key_exists(0, $this->request->pass)) ) ? false : $this->request->pass[0] == "AlphaDESC" ) ? 'btn btn-success' : 'btn btn-warning',
          'style' => 'width:100%;'
        ]
      );
    ?>
  </div>
</div>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Step 3  Block ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->

<div class="row">
  <div class="col-md-12">
    <h1 class="text-center">Chorddiagrammvisualisierung</h1>
    <div id="poisChord">
    </div>
  </div>
</div> <!-- /.row -->
<?= $this->Html->script('chordChart.js') ?>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑ Step 3  Block ↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->

<?php $showRow = 3; ?>
<?php foreach ($pois as $poi): ?>
    <?php
      if( ($showRow % 3) == 0) {
        echo '<div class="row">';
      }
    ?>
    <div class="col-md-4">
      <div id="poi_<?= h($poi->google_place)?>_Info">
        <h3 class="text-center"><?= h($poi->name) ?></h3>
        <dl class="dl-horizontal">
          <dt>Name</dt>
          <dd><img src="<?= h($poi->icon) ?>" alt="<?= h($poi->name) ?> Icon" width="24px" /><?= h($poi->name)?></dd>
          <dt>Adresse</dt>
          <dd><?= h($poi->vicinity) ?></dd>
          <dt>GMapp Link</dt>
          <?php
            $gMapString = "https://www.google.de/maps/place/";
            $gMapString .= str_replace(' ', '+', trim( str_replace(',', '', h($poi->vicinity) )));
            $gMapString .= "/@" . h($poi->lat) . "," . h($poi->lng);
          ?>
          <dd>
            <a href="<?= $gMapString ?>" titel="Google Maps Link für <?= h($poi->name) ?>" target="_blank">
              <img src="http://mt.google.com/vt/icon?color=ff004C13&amp;name=icons/spotlight/spotlight-waypoint-b.png" height="18px"> <?= h($poi->name) ?> auf der Karte anzeigen
            </a>
          </dd>
          <dt>Google Places ID</dt>
          <dd><?= h($poi->google_place) ?></dd>
        </dl>
      </div>
    </div>
    <?php
      if( ($showRow % 3) == 2) {
        echo '</div> <!-- /.row -->';
      }
      $showRow++;
    ?>
<?php endforeach; ?>


<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓↓ Cake  Block ↓↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pois index large-9 medium-8 columns content">
    <h3><?= __('Pois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('lat') ?></th>
                <th><?= $this->Paginator->sort('lng') ?></th>
                <th><?= $this->Paginator->sort('google_place') ?></th>
                <th><?= $this->Paginator->sort('icon') ?></th>
                <th><?= $this->Paginator->sort('rating') ?></th>
                <th><?= $this->Paginator->sort('vicinity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pois as $pois): ?>
            <tr>
                <td><?= $this->Number->format($pois->id) ?></td>
                <td><?= h($pois->created) ?></td>
                <td><?= h($pois->modified) ?></td>
                <td><?= h($pois->name) ?></td>
                <td><?= $this->Number->format($pois->lat) ?></td>
                <td><?= $this->Number->format($pois->lng) ?></td>
                <td><abbr title="<?= h($pois->google_place) ?>">GP_ID</abbr></td>
                <td><img src="<?= h($pois->icon) ?>" alt="<?= h($pois->name) ?> Icon" width="24px" /></td>
                <td><?= $this->Number->format($pois->rating) ?></td>
                <td><?= h($pois->vicinity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pois->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
-->
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Cake  Block ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->

</div> <!-- /.container -->
