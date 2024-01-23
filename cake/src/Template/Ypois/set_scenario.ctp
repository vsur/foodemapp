<?=
$this->element(
  'navbar',
  [
    "step" => "Auswahl der Kategorien",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Wünsche</a></li>"
  ]
);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<div id="loadingSpinnerContainer">
  <div class="spinner">
    <div class="cube1"></div>
    <div class="cube2"></div>
  </div>
  <h1>Ihre Auwahl wird analysiert</h1>
</div>

<div class="row">
  <div class="col-md-12">
    <?php
    // echo $this->Html->image('isac-header.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']);
    echo $this->Html->image('wordcloud.png', ['alt' => 'Header Bilder der FoodMAPP Anwendung', 'class' => 'thumbnail img-rounded img-responsive']);
    ?>
  </div>
</div>

<?php $this->assign('title', 'Auswahl'); ?>

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


<!-- ↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Hint Area ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<?php
  $session = $this->request->session();
?>

<?php if (!$session->check('Config.hasSeenScenarioHint')) : ?>
<div class="row">
  <div class="col-md-12">
    <?php
      echo $this->element('hints/setScenario/howToChoose');
      $session->write([
        'Config.hasSeenScenarioHint' => true
      ]);
    ?>
  </div>
</div>
<?php endif; ?>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑ Hint Area ↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑ -->


<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Step 2  Block ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label for="criteriaInput"><?= __('Kategorie') ?></label>
      <input style="width: 100%;" type="text" class="awesomplete" id="criteriaInput" placeholder="Tippen und wählen">
    </div>
    <button id="chooseAction" style="width: 100%;" type="button" class="btn btn-default" onclick="fmApp.checks.input()"><?= __('Auswählen') ?></button>
  </div>

  <div class="col-md-4">
    <div id="criteriaChoice">
      <label class="areaLabel text-success" for="criteriaChoice"><?= __('Ihre Auswahl an Kategorien') ?></label>

    </div>
  </div>

  <div class="col-md-6">
    <div id="criteriaOutput">
      <label class="areaLabel text-info hidden-md hidden-lg"><?= __('Einstellen und Werten der Kategorien') ?></label>
      <div class="row hidden-sm hidden-xs">
        <div class="col-md-6">
          <label class="areaLabel text-info">Kategorien einstellen</label>
        </div>
        <div class="col-md-6">
          <label class="areaLabel text-info">Gewichtung einstellen</label>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /.row -->

<div class="row">
  <div class="col-md-6 col-md-offset-6">
    <button id="showAction" style="width: 100%;" type="button" class="btn btn-default"><?= __('Zeig mir was zu meiner Auswahl passt') ?></button>
  </div>
</div> <!-- /.row -->
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑ Step 2  Block ↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->

<script type="text/javascript">
  var criterionNames = <?= json_encode($criterionNames) ?>;
  var input = document.getElementById("criteriaInput");
  var awesomplete = new Awesomplete(input, {
    minChars: 1,
    autoFirst: true,
    maxItems: 10
  });
  awesomplete.list = criterionNames;
</script>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓↓ Cake  Block ↓↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->

<div id="cakeBlock" class="row">
  <div class="col-md-12">
    <div class="criteria choose content">
      <div id="showAllCriteria">
        <h3>Alle Kategorien <span id="compnentListDisplayState">einblenden ↓</span>
          <h3>
      </div>
      <table id="criteriaListView" class="table" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th><?= __('Name') ?></th>
            <!-- <th><?= __('Erstellungsdatum')  ?></th> -->
            <th><?= __('Art')  ?></th>
            <th class="actions"><?= __('Wählen') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($criteria as $criterion) : ?>
            <?php
            $criterionToken = "";
            switch ($criterion->modelType) {
              case 'BinaryComponents':
                $criterionToken .= "BC";
                $criterionToken .= "_C-ID_" . $criterion->id;
                break;
              case 'NominalComponents':
                $criterionToken .= "NC";
                $criterionToken .= "_C-ID_" . $criterion->id;
                break;
              case 'OrdinalComponents':
                $criterionToken .= "OC";
                $criterionToken .= "_C-ID_" . $criterion->id;
                break;
            }
            ?>
            <tr>
              <td><?= h($criterion->display_name) ?></td>
              <!-- <td><?= h($criterion->modified) ?></td> -->
              <td><?= h($criterion->source()) ?></td>
              <td class="actions">
                <a href="#" class="addFromList" name="<?= h($criterion->display_name) ?>" id="allCriteriaList_<?= $criterionToken ?>">Kriterium auswählen</a>
                <!--
                        <?= $this->Html->link(__('View'), ['action' => 'view', $criterion->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $criterion->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $criterion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $criterion->id)]) ?>
                        -->
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div> <!-- /.row -->
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Cake  Block ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Criteria Block for JS ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<script type="text/javascript">
  var criteria = <?= json_encode($criteria) ?>;
  var configuredSelection = <?= json_encode($configuredSelection) ?>;

  var storeUserPositionInSessionURL = "<?= $this->Url->build(["controller" => "Ypois", "action" => "setGeoInSession"]) ?>";

  $(document).ready(function() {
    fmApp.checks.usersPosition();
    // Set values in Input fields
    $("#latitude").val(fmApp.geoLocation.latLong[0]);
    $("#longitude").val(fmApp.geoLocation.latLong[1]);
    $("#accuracy").val(fmApp.geoLocation.accuracy);
  });
</script>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Criteria Block for JS ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
