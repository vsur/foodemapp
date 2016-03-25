<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>
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

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓↓ Cake  Block ↓↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pois index large-9 medium-8 columns content">
    <h3><?= __('Pois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('lat') ?></th>
                <th><?= $this->Paginator->sort('lng') ?></th>
                <th><?= $this->Paginator->sort('google_place') ?></th>
                <th><?= $this->Paginator->sort('icon') ?></th>
                <th><?= $this->Paginator->sort('rating') ?></th>
                <th><?= $this->Paginator->sort('vicinity') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pois as $pois): ?>
            <tr>
                <td><?= $this->Number->format($pois->id) ?></td>
                <td><?= h($pois->created) ?></td>
                <td><?= h($pois->modified) ?></td>
                <td><?= h($pois->name) ?></td>
                <td><?= $this->Number->format($pois->lat) ?></td>
                <td><?= $this->Number->format($pois->lng) ?></td>
                <td><abbr title="<?= h($pois->google_place) ?>">GP_ID</abbr></td>
                <td><img src="<?= h($pois->icon) ?>" alt="<?= h($pois->name) ?> Icon" width="24px" /></td>
                <td><?= $this->Number->format($pois->rating) ?></td>
                <td><?= h($pois->vicinity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pois->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Cake  Block ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
