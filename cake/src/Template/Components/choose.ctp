<?=
  $this->element('navbar',
  [
    "step" => "Auswahl der Kategorien",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Komponenten</a></li>"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<?php
  $componentsNames = array();
  foreach ($components as $component) {
    array_push($componentsNames, $component->name);
  }
?>

<div class="container" role="main">

<?php $this->assign('title', 'Auswahl'); ?>
<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Step 2  Block ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label for="componentInput"><?= __('Kategorie') ?></label>
      <input style="width: 100%;" type="text" class="awesomplete" id="componentInput" placeholder="Essen">
    </div>
    <button id="chooseAction" style="width: 100%;" type="button" class="btn btn-default" onclick="fmApp.checkInput()"><?= __('Auswählen') ?></button>
  </div>

  <div class="col-md-4">
    <div id="componentChoice">
      <label class="text-success" for="componentChoice"><?= __('Ihre Auswahl an Kategorien') ?></label>

    </div>
  </div>

  <div class="col-md-6">
    <div id="componentOutput">

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
var components = <?= json_encode($components) ?>;
var componentsNames = <?= '["' . implode('", "', $componentsNames) . '"]' ?>;
var input = document.getElementById("componentInput");
var awesomplete = new Awesomplete(input, {
  minChars: 1,
  autoFirst: true,
  maxItems: 10
});
awesomplete.list = componentsNames;
</script>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓↓ Cake  Block ↓↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<div class="row">
  <div class="col-md-2">
    <h3><?= __('Actions') ?></h3>
    <nav id="actions-sidebar">
        <ul class="nav nav-pills nav-stacked">
            <li><?= $this->Html->link(__('New Component'), ['action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List Stages'), ['controller' => 'Stages', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Stage'), ['controller' => 'Stages', 'action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?></li>
        </ul>
    </nav>
  </div>
  <div class="col-md-10">
    <div class="components choose content">
        <h3><?= __('Components') ?></h3>
        <table class="table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($components as $component): ?>
                <tr>
                    <td><?= $this->Number->format($component->id) ?></td>
                    <td><?= h($component->created) ?></td>
                    <td><?= h($component->modified) ?></td>
                    <td><?= h($component->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $component->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $component->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $component->id], ['confirm' => __('Are you sure you want to delete # {0}?', $component->id)]) ?>
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
