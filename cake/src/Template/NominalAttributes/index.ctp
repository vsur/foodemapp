<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Components'), ['controller' => 'NominalComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Component'), ['controller' => 'NominalComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nominalAttributes index large-9 medium-8 columns content">
    <h3><?= __('Nominal Attributes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nominal_component_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('icon_path') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nominalAttributes as $nominalAttribute): ?>
            <tr>
                <td><?= $this->Number->format($nominalAttribute->id) ?></td>
                <td><?= $nominalAttribute->has('nominal_component') ? $this->Html->link($nominalAttribute->nominal_component->name, ['controller' => 'NominalComponents', 'action' => 'view', $nominalAttribute->nominal_component->id]) : '' ?></td>
                <td><?= h($nominalAttribute->name) ?></td>
                <td><?= h($nominalAttribute->display_name) ?></td>
                <td><?= h($nominalAttribute->icon_path) ?></td>
                <td><?= h($nominalAttribute->created) ?></td>
                <td><?= h($nominalAttribute->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $nominalAttribute->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $nominalAttribute->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $nominalAttribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttribute->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
