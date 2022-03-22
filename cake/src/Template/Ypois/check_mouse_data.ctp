<?php
if(!$eval) {
    echo $this->element(
        'navbar',
        [
            "step" => "Anzeige der Ergebnisse",
            "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>"
        ]
    );

}
if ($displayVariant == 'map') {
    echo $this->element(
        'mapnavbar',
        [
            "step" => "Anzeige der Ergebnisse",
            "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>",
            "eval" => $eval
        ]
    );
}
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<?php
if ($displayVariant == 'debug') {

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

<?php if(!$eval) : ?>
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
<?php endif; ?>

<?php if (!$eval) : ?>
    <?php if ($displayVariant != 'map') : ?>
        <div class="row">
            <div class="col-md-12">
                <?=
                // $this->Html->image('isac-header.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); 
                $this->Html->image('wordcloud.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']);
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>

<?php
if ($displayVariant == 'debug' || is_null($displayVariant)) {
    echo $this->element('findMatches/debug');
}
if ($displayVariant == 'selectViz') {
    echo $this->element('findMatches/select_viz');
}
if ($displayVariant == 'list') {
    echo $this->element('findMatches/list');
    if(!$eval) {
        echo $this->element(
            'findMatches/heatmapbar',
            [
                "displayVariant" => $displayVariant
            ]
        );
    }
}
if ($displayVariant == 'map') {
    echo $this->element('findMatches/map');
    if(!$eval) {
        echo $this->element(
            'findMatches/heatmapbar',
            [
                "displayVariant" => $displayVariant
            ]
        );
    }
}
if ($displayVariant == 'chord') {
    echo $this->element('findMatches/chord');
    if(!$eval) {
        echo $this->element(
            'findMatches/heatmapbar',
            [
                "displayVariant" => $displayVariant
            ]
        );
    }
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