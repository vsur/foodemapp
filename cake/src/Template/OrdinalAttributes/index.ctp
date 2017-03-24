<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Components'), ['controller' => 'OrdinalComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Component'), ['controller' => 'OrdinalComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalAttributes index large-9 medium-8 columns content">
    <h3><?= __('Ordinal Attributes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ordinal_component_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('meter') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ordinalAttributes as $ordinalAttribute): ?>
            <tr>
                <td><?= $this->Number->format($ordinalAttribute->id) ?></td>
                <td><?= $ordinalAttribute->has('ordinal_component') ? $this->Html->link($ordinalAttribute->ordinal_component->name, ['controller' => 'OrdinalComponents', 'action' => 'view', $ordinalAttribute->ordinal_component->id]) : '' ?></td>
                <td><?= h($ordinalAttribute->name) ?></td>
                <td><?= h($ordinalAttribute->display_name) ?></td>
                <td><?= $this->Number->format($ordinalAttribute->meter) ?></td>
                <td><?= h($ordinalAttribute->created) ?></td>
                <td><?= h($ordinalAttribute->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ordinalAttribute->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ordinalAttribute->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ordinalAttribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttribute->id)]) ?>
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
