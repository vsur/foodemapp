<?php
    echo $this->Html->css(['MarkerCluster', 'MarkerCluster.Default'], ['block' => true]);
    echo $this->Html->script('leaflet.markercluster', ['block' => true]);
?>

<div class="row">
    <div class="col-md-12">
        <h1>Ihre Ergebnisse auf einer Karte</h1>
        <ul id="mapComponentsChoice" class="nav nav-pills">
            <?php if ( isset($configuredSelection) ) : ?>
                <li role="presentation" class="active"><a href="#" id="mapComponentsChosen" data-component-presentation="chosen">Gesuchte Komponenten</a></li>
            <?php endif;?>

            <?php if ( $this->request->session()->check('Config.geolocation')) : ?>
                <li role="presentation" ><a href="#" id="mapComponentsOther" data-component-presentation="distance">Entfernung Anzeigen</a></li>
            <?php endif;?>

            <li role="presentation" class="<?= isset($configuredSelection) ? '': 'active' ?>"><a href="#" id="mapComponentsHide" data-component-presentation="none">Komponenten ausblenden</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="other">Übrige Komponenten</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justBinary">Binär</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justNominal">Nominal</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justOrdinal">Ordinal</a></li>
        </ul>
        <div id="ypoisMap"></div>
    </div>
</div>
<script type="text/javascript">
    var ypois = <?= json_encode($ypois) ?>;
    var rankedSelection = <?= json_encode($rankedSelection) ?>;
</script>
<?= $this->Html->css('L.Icon.Pulse.css') ?>
<?= $this->Html->script('L.Icon.Pulse.js') ?>
<?= $this->Html->script('leaflet-map.js', ['block' => 'scriptAfterfmApp']) ?>
