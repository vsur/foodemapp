<div class="row">
  <div class="col-md-12">
    <h1 class="text-center">Chorddiagrammvisualisierung</h1>
    <div id="ypoisChord">
    </div>
  </div>
</div> <!-- /.row -->
<script type="text/javascript">
  var chordDiagramMatrixData = <?= json_encode($chordDiagramMatrixData) ?>;
  var matrix = <?= json_encode($chordDiagramMatrixData->adjacencyMatrix) ?>;
</script>
<?= $this->Html->script('d3.stretched.chord.js') ?>
<?= $this->Html->script('d3.layout.chord.sort.js') ?>
<?= $this->Html->script('chord-diagram.js') ?>

<?= $this->Html->script('heatmap-std.js', ['block' => 'scriptAfterfmApp']) ?>
<?= $this->Html->script('aoi-chord.js', ['block' => 'scriptAfterfmApp']) ?>