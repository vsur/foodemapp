<?=
  $this->element('navbar',
  [
    "step" => "Trefferanzeige",
    "vizElement" => '<li>' . $this->Html->link(__('‹ Komponenten'), ['controller' => 'Components', 'action' => 'choose', '_full' => true]) . "</li>\n" .
                    '<li><a href="../matchesPie/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Scheibendiagramme">‹ Scheiben</a>' . "</li>\n" .
                    '<li><a href="../matchesBar/?' . $_SERVER['QUERY_STRING'] .  '" title="Anzeige als Balkendiagramme">‹ Balken</a>' . "</li>\n" .
                    "<li class=\"active\"><a href=\"#\">POIs</a></li>\n"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<script type="text/javascript">
  var pois = <?= json_encode($pois) ?>;
  console.log(pois);
  var treemapData = {
    "name": "TreemapMatches",
    "children": []
  };
  // for (var i = 0; i < pois.length; i++) {
  for (var i in pois) {
    var childComponents = [];
    console.log(pois[i]);

    for (var j in pois[i].components) {
      childComponents.push(
        {
          "name": pois[i].components[j].name,
          "rating": pois[i].components[j]._joinData.rating
        }
      );
    }
    treemapData.children.push(
      {
        "name": pois[i].name,
        "children": childComponents
      }
    );
  }
  console.log(JSON.stringify(treemapData, null, 4));
</script>


<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>

<div class="container" role="main">




<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Step 3  Block ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<div class="row">
  <div class="col-md-12">
    <h1>Hier steht das Treemap</h1>
    <div id="poisTreemap">
    </div>
  </div>
</div> <!-- /.row -->
<?= $this->Html->script('treemapChart.js') ?>
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
