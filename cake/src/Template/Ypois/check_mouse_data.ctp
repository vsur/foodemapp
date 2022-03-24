<?php
    echo $this->element(
        'participantchoicebar',
        [
            "step" => "Auswahl der Teilnehmer:in",
            "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>"
        ]
    );

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


<?php $this->assign('title', 'Mousedaten analysieren'); ?>

<?php

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