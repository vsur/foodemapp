<!-- <div id="analyzeContainer"> -->
  <div class="row">
    <div class="col-md-12">
      <div id="ypoisChord" class="evalMode">
        </div>
      </div>
    </div> <!-- /.row -->
<!-- </div> -->
<script type="text/javascript">
  var chordDiagramMatrixData = <?= json_encode($chordDiagramMatrixData) ?>;
  var matrix = <?= json_encode($chordDiagramMatrixData->adjacencyMatrix) ?>;
</script>
<?= $this->Html->script('d3.stretched.chord.js') ?>
<?= $this->Html->script('d3.layout.chord.sort.js') ?>
<?= $this->Html->script('chord-diagram.js') ?>

<?= $this->Html->script('heatmap-std-analyze.js', ['block' => 'scriptAfterfmApp']) ?>
<?= $this->Html->script('aoi-chord-analyze.js', ['block' => 'scriptAfterfmApp']) ?>

<script>
  $(document).ready(function() {
    // Init Heatmap
    fmApp.heatmap.init();
  });
</script>