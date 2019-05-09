
<div class="row">
  <div class="col-md-12">
    <h1 class="text-center">Chorddiagrammvisualisierung</h1>
    <div id="ypoisChord">
    </div>
  </div>
</div> <!-- /.row -->
<script type="text/javascript">
    var matrix = <?= json_encode($chordDiagramMatrixData->adjacencyMatrix) ?>;
    var rankedComponents = <?= json_encode($chordDiagramMatrixData->rankedComponents) ?>;
    var otherComponents = <?= json_encode($chordDiagramMatrixData->otherComponents) ?>;
    console.log("Alle ChorddigramMatrixData");
    console.log( <?= json_encode($chordDiagramMatrixData) ?>);
</script>
<?= $this->Html->script('d3.stretched.chord.js') ?>
<?= $this->Html->script('d3.layout.chord.sort.js') ?>
<?= $this->Html->script('chord-diagram.js') ?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Binary</th>
                <th>Nominal</th>
                <th>Ordinal</th>
                <th>Stars</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ypois as $nr => $ypoi): ?>
                <tr>
                    <td><?= $this->Number->format($nr + 1) ?></td>
                    <td><?= h($ypoi->name) ?></td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->binary_components as $binaryComponent): ?>
                                <li><?= $binaryComponent->display_name != '' ? $binaryComponent->display_name : ('<span class="text-muted">' . $binaryComponent->name . '</span>')  ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->nominal_attributes as $nomnialAttribute): ?>
                                <li><?= $nomnialAttribute->nominal_component->display_name != '' ? ($nomnialAttribute->nominal_component->display_name . '.') : ('<span class="text-muted">' . $nomnialAttribute->nominal_component->name . ':</span>') ?> <?= $nomnialAttribute->display_name != '' ? $nomnialAttribute->display_name : ('<span class="text-muted">' . $nomnialAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->ordinal_attributes as $ordinalAttribute): ?>
                                <li><?= $ordinalAttribute->ordinal_component->display_name != '' ? ($ordinalAttribute->ordinal_component->display_name . ':') : ('<span class="text-muted">' . $ordinalAttribute->ordinal_component->meter . ':</span>') ?> <?= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : ('<span class="text-muted">' . $ordinalAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td><?= $this->Number->format($ypoi->stars) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- /.col-md-12 -->
</div>
