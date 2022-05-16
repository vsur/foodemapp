<?php
echo $this->Html->css(['MarkerCluster', 'MarkerCluster.Default'], ['block' => true]);
echo $this->Html->script('leaflet.markercluster', ['block' => true]);
echo $this->Html->script('snap.svg-min', ['block' => true]);
echo $this->Html->script('leaflet.bezier', ['block' => true]);
?>


<div id="ypoisMap" class="evalPos"></div>

<script type="text/javascript">
    var ypois = <?= json_encode($ypois) ?>;
    var rankedSelection = <?= json_encode($rankedSelection) ?>;
</script>
<?= $this->Html->css('L.Icon.Pulse.css') ?>
<?= $this->Html->script('L.Icon.Pulse.js') ?>
<?= $this->Html->script('leaflet-heatmap.js', ['block' => 'scriptAfterHeatmap']) ?>
<?= $this->Html->script('leaflet-map.js', ['block' => 'scriptAfterfmApp']) ?>
<?= $this->Html->script('heatmap-map.js', ['block' => 'scriptAfterfmApp']) ?>
<?= $this->Html->script('aoi-map.js', ['block' => 'scriptAfterfmApp']) ?>