<?php
    echo $this->Html->css(['MarkerCluster', 'MarkerCluster.Default'], ['block' => true]);
    echo $this->Html->script('leaflet.markercluster', ['block' => true]);
?>

<div id="ypoisMap"></div>

<script type="text/javascript">
    var ypois = <?= json_encode($ypois) ?>;
    var rankedSelection = <?= json_encode($rankedSelection) ?>;
</script>
<?= $this->Html->css('L.Icon.Pulse.css') ?>
<?= $this->Html->script('L.Icon.Pulse.js') ?>
<?= $this->Html->script('leaflet-map.js', ['block' => 'scriptAfterfmApp']) ?>
