<?=
  $this->element('navbar',
  [
    "step" => "Anzeige der Ergebnisse",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<?php
    if($displayVariant == 'debug') {

        if ($configuredSelection) {
            debug("Configured Selection from URL");
            debug($configuredSelection);
        }
        if ($filterSelection) {
            debug("Build Filter Array");
            debug($filterSelection);
        }
        if ($rankedSelection) {
            debug("Ranked Filter Object");
            debug($rankedSelection);
        }
    }
?>

<div id="compnentWheelContainer">
    <div id="wheelBlock">
        <script type="text/javascript">
            var componentWheelJSONData = <?= $componentWheelJSONData ?>;
        </script>
        <?= $this->Html->script('sunburst-translations') ?>
        <?= $this->Html->script('componentwheelsunburst') ?>
    </div>
    <div id="componentTextContainer">
        <div id="coponentTextInfo">
            <span></span>
        </div>
    </div>
</div>


<div class="row">
  <div class="col-md-12">
    <?= 
        // $this->Html->image('isac-header.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); 
        $this->Html->image('wordcloud.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); 
    ?>
  </div>
</div>

<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>

<?php
    if($displayVariant == 'debug' || is_null($displayVariant) ) {
        echo $this->element('findMatches/debug');
    }
    if($displayVariant == 'selectViz' ) {
        echo $this->element('findMatches/select_viz');
    }
    if($displayVariant == 'list' ) {
        echo $this->element('findMatches/list');
    }
    if($displayVariant == 'map' ) {
        echo $this->element('findMatches/map');
    }
    if($displayVariant == 'chord' ) {
        echo $this->element('findMatches/chord');
    }
?>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Criteria Block for JS ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<script type="text/javascript">
    var criteria = <?= json_encode($criteria) ?>;
    var configuredSelection = <?= json_encode($configuredSelection) ?>;
    
</script>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Criteria Block for JS ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
