

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Hint Area ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<?php 
  $session = $this->request->session();
?>

<?php if (!$session->check('Config.hasSeenMatchesHint')) : ?>
<div class="row">
  <div class="col-md-12">
    <?php
      echo $this->element('hints/findMatches/selectViz');
      $session->write([
        'Config.hasSeenMatchesHint' => true
      ]);
    ?>
  </div>
</div>
<?php endif; ?>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑ Hint Area ↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑ -->


<div class="row">
    <div class="col-md-4">
        <h3>
            
            <span id="poiCount" class="badge <?= (count($ypois) == 0) ? 'danger' : 'success' ?>">
                Gefundene Orte <br>
                <span class="actualPoiNumber"><?= count($ypois) ?></span>
            </span>
        </h3>
    </div>
    <div class="col-md-4">
        <h3>Aktuelle Auswahl an Kategorien</h3>
        <div id="selectViz-rankedSelectionList">
            <?= $this->element('findMatches/ranked_selection_list'); ?>
        </div>
    </div>
    <div class="col-md-4">
        <h3>Kategorien-Übersicht</h3>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td>Gefundene Orte</td>
                    <td><?= count($ypois) ?></td>
                </tr>
                <tr>
                    <td>Insgesamt vorhandene Kategorien</td>
                    <td><?= $overallComponentCount ?></td>
                </tr>
                <tr>
                    <td>Summe gewählter Kategorien</td>
                    <td><?= count($configuredSelection) ?></td>
                </tr>
                <tr>
                    <td>Summe übriger Kategorien</td>
                    <td><?= (count($ypois) == 0) ? 0 : ( $overallComponentCount - count($configuredSelection) ) ?></td>
                </tr>
                <tr>
                    <td>5 ★ Auswahl</td>
                    <td><?= $this->Selection->getNStarAggregatedItemsNumber($rankedSelection->rating5) ?></td>
                </tr>
                <tr>
                    <td>4 ★ Auswahl</td>
                    <td><?= $this->Selection->getNStarAggregatedItemsNumber($rankedSelection->rating4) ?></td>
                </tr>
                <tr>
                    <td>3 ★ Auswahl</td>
                    <td><?= $this->Selection->getNStarAggregatedItemsNumber($rankedSelection->rating3) ?></td>
                </tr>
                <tr>
                    <td>2 ★ Auswahl</td>
                    <td><?= $this->Selection->getNStarAggregatedItemsNumber($rankedSelection->rating2) ?></td>
                </tr>
                <tr>
                    <td>1 ★ Auswahl</td>
                    <td><?= $this->Selection->getNStarAggregatedItemsNumber($rankedSelection->rating1) ?></td>
                </tr>
                <tr>
                    <td>Alle Binären Kategorien</td>
                    <td><?= $componentTypesComponentsCount->binaryCount ?></td>
                </tr>
                <tr>
                    <td>Alle Nominalen Kategorien</td>
                    <td><?= $componentTypesComponentsCount->nominalCount ?></td>
                </tr>
                <tr>
                    <td>Alle Ordinalen Kategorien</td>
                    <td><?= $componentTypesComponentsCount->ordinalCount ?></td>
                </tr>
                </tbody>
        </table>
    </div>
</div>
<?php if(count($ypois) > 0) : ?>
    <div class="row">
        <div class="col-md-4 viewLinkBlock">
            <a href="<?= $this->Url->build(["controller" => "ypois", "action" => "findMatches", "list", "?" => $this->request->query]);?>">
                <h2>Listenanzeige</h2>
                <?= $this->Html->image('list-view.png', ['alt' => 'Ihre Ergebnisse als Listenansicht', 'class' => 'thumbnail img-rounded img-responsive']); ?>
            </a>
        </div>
        <div class="col-md-4 viewLinkBlock">
            <a href="<?= $this->Url->build(["controller" => "ypois", "action" => "findMatches", "chord", "?" => $this->request->query]);?>">
                <h2>Chord-Diagram</h2>
                <?= $this->Html->image('chord-view.png', ['alt' => 'Ihre Ergebnisse als Chord-Diagramm', 'class' => 'thumbnail img-rounded img-responsive']); ?>
            </a>
        </div>
        <div class="col-md-4 viewLinkBlock">
            <a href="<?= $this->Url->build(["controller" => "ypois", "action" => "findMatches", "map", "?" => $this->request->query]);?>">
                <h2>Kartendarstellung</h2>
                <?= $this->Html->image('map-view.png', ['alt' => 'Ihre Ergebnisse als Kartendarstellung', 'class' => 'thumbnail img-rounded img-responsive']); ?>
            </a>
        </div>
    </div>
    <?php else : ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <?= $this->Html->link(
                'Bitte passen Sie Ihr Auswahl an, damit Sie auch Ergebnisse erhalten <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>',
                ["controller" => "ypois", "action" => "setScenario", "?" => $this->request->query],
                [
                  'class' => 'btn btn-warning navbar-btn', 
                  'id' => 'noResultButton',
                  'aria-label' => 'Passen Sie ihre Auswahl an', 
                  'escape' => false
                ]
            ); ?>
            </div>
        </div>

<?php endif; ?>
