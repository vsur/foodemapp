<?=
  $this->element('navbar',
  [
    "step" => "Auswahl der Kategorien",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Wünsche</a></li>"
  ]);
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

<div class="container" role="main">
  <div class="row">
  <div class="col-md-12">
    <?= $this->Html->image('wordcloud.png', ['alt' => 'Wordcloud von Themenfeldern dieser Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); ?>
  </div>
</div>

<?php $this->assign('title', 'Auswahl'); ?>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Step 2  Block ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label for="criteriaInput"><?= __('Kategorie') ?></label>
      <input style="width: 100%;" type="text" class="awesomplete" id="criteriaInput" placeholder="Essen">
    </div>
    <button id="chooseAction" style="width: 100%;" type="button" class="btn btn-default" onclick="fmApp.checkInput()"><?= __('Auswählen') ?></button>
  </div>

  <div class="col-md-4">
    <div id="criteriaChoice">
      <label class="text-success" for="criteriaChoice"><?= __('Ihre Auswahl an Kategorien') ?></label>

    </div>
  </div>

  <div class="col-md-6">
    <div id="criteriaOutput">
      <label class="text-info hidden-md hidden-lg"><?= __('Einstellen und Werten der Kategorien') ?></label>
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
        <h3>Alle Kriterien <span id="compnentListDisplayState">einblenden ↓</span><h3>
      </div>
        <table id="criteriaListView" class="table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Erstellungsdatum')  ?></th>
                    <th><?= __('Art')  ?></th>
                    <th class="actions"><?= __('Wählen') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criteria as $criterion): ?>
                <tr>
                    <td><?= h($criterion->name) ?></td>
                    <td><?= h($criterion->modified) ?></td>
                    <td><?= h($criterion->source()) ?></td>
                    <td class="actions">
                        <a href="#" class="addFromList" name="<?= h($criterion->display_name) ?>">Kriterium auswählen</a>
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

</div> <!-- /.container -->

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
