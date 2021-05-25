<!-- NO NAVBAR  -->

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<?php $this->assign('title', 'Ihre Geoposition wird gesetzt'); ?>

<div id="loadingSpinnerContainer" style="display: block;">
  <div class="spinner">
    <div class="cube1"></div>
    <div class="cube2"></div>
  </div>
  <h1>Ihre Position wird analysiert</h1>
</div>


<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ GEO Location Data Storage for later sorting ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->

<div class="row hidden">
  <div class="col-md-12">
    <div class="form-group">
      <label for="latitude"><?= __('Latitude') ?></label>
      <?= $this->Form->hidden('latitude', ['id' => 'latitude', 'value' => '0.0']); ?>

      <label for="longitude"><?= __('Longitude') ?></label>
      <?= $this->Form->hidden('longitude', ['id' => 'longitude', 'value' => '0.0']); ?>

      <label for="accuracy"><?= __('Accuracy') ?></label>
      <?= $this->Form->hidden('accuracy', ['id' => 'accuracy', 'value' => '1000.0']); ?>
    </div>
  </div>
</div>


<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑ GEO Location Data Storage for later sorting ↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Criteria Block for JS ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<script type="text/javascript">
  var criteria = <?= json_encode($criteria) ?>;
  var criterionNames = <?= json_encode($criterionNames) ?>;
  var configuredSelection = <?= json_encode($configuredSelection) ?>;

  var storeUserPositionInSessionURL = "<?= $this->Url->build(["controller" => "Ypois", "action" => "setGeoInSession"]) ?>";

  $(document).ready(function() {
    fmApp.checks.usersPosition();
    // Set values in Input fields
    $("#latitude").val(fmApp.geoLocation.latLong[0]);
    $("#longitude").val(fmApp.geoLocation.latLong[1]);
    $("#accuracy").val(fmApp.geoLocation.accuracy);

    fmApp.sets.sessionGeo('<?= $this->Url->build(["controller" => "Ypois", "action" => "findMatches"]) ?>/<?=  $this->request->pass[0] ?>', window.location.search);
});

</script>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Criteria Block for JS ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
