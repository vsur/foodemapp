<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ordinal Component'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalComponents index large-9 medium-8 columns content">
    <h3><?= __('Ordinal Components') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ordinalComponents as $ordinalComponent): ?>
            <tr>
                <td><?= $this->Number->format($ordinalComponent->id) ?></td>
                <td><?= h($ordinalComponent->name) ?></td>
                <td><?= h($ordinalComponent->display_name) ?></td>
                <td><?= h($ordinalComponent->created) ?></td>
                <td><?= h($ordinalComponent->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ordinalComponent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ordinalComponent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ordinalComponent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalComponent->id)]) ?>
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
