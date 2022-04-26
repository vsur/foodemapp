<?php
    echo $this->element(
        'participantchoicebar',
        [
            "step" => "Auswahl der Teilnehmer:in",
            "allParticipants" => $allParticipants->toArray(),
            "participantData" => $participantData
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

<script type="text/javascript">
    var evalMode = true;
</script>

<?= $this->Flash->render() ?>


<?php $this->assign('title', 'Mousedaten analysieren'); ?>

<?php

if ($displayVariant == 'list') {
    echo $this->element('findMatches/listanalyze');
    echo $this->element(
        'findMatches/heatmapbar',
        [
            "displayVariant" => $displayVariant 
        ]
    );
}
if ($displayVariant == 'map') {
    echo $this->element('findMatches/mapanalyze');
    echo $this->element(
        'findMatches/heatmapbar',
        [
            "displayVariant" => $displayVariant
        ]
    );
}
if ($displayVariant == 'chord') {
    echo $this->element('findMatches/chordanalyze');
    echo $this->element(
        'findMatches/heatmapbar',
        [
            "displayVariant" => $displayVariant
        ]
    );
}
?>
<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Criteria Block for JS ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<script type="text/javascript">
    var criteria = <?= json_encode($criteria) ?>;
    var configuredSelection = <?= json_encode($configuredSelection) ?>;
    var participantData = <?= ( !empty($participantData) ? $participantData : json_encode([]) ) ?>;
</script>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Criteria Block for JS ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->