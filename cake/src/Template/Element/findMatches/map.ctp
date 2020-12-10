<?php
    echo $this->Html->css(['MarkerCluster', 'MarkerCluster.Default'], ['block' => true]);
    echo $this->Html->script('leaflet.markercluster', ['block' => true]);
?>

<div class="row">
    <div class="col-md-12">
        <h1>Ihre Ergebnisse auf einer Karte</h1>
        <ul id="mapComponentsChoice" class="nav nav-pills">
            <li role="presentation" class="active"><a href="#" id="mapComponentsChosen" data-component-presentation="chosen">Gesuchte Komponenten</a></li>
            <li role="presentation" ><a href="#" id="mapComponentsHide" data-component-presentation="none">Komponenten ausblenden</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="other">Übrige Komponenten</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justBinary">Nur Binär</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justNominal">Nur Nominal</a></li>
            <li role="presentation"><a href="#" id="mapComponentsOther" data-component-presentation="justOrdinal">Nur Ordinal</a></li>
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
<?= $this->Html->script('leaflet-map.js') ?>
