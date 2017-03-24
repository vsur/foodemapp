<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attributes Ypois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalAttributesYpois index large-9 medium-8 columns content">
    <h3><?= __('Ordinal Attributes Ypois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ordinal_attribute_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ypoi_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ordinalAttributesYpois as $ordinalAttributesYpois): ?>
            <tr>
                <td><?= $this->Number->format($ordinalAttributesYpois->id) ?></td>
                <td><?= $ordinalAttributesYpois->has('ordinal_attribute') ? $this->Html->link($ordinalAttributesYpois->ordinal_attribute->name, ['controller' => 'OrdinalAttributes', 'action' => 'view', $ordinalAttributesYpois->ordinal_attribute->id]) : '' ?></td>
                <td><?= $ordinalAttributesYpois->has('ypois') ? $this->Html->link($ordinalAttributesYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $ordinalAttributesYpois->ypois->id]) : '' ?></td>
                <td><?= h($ordinalAttributesYpois->created) ?></td>
                <td><?= h($ordinalAttributesYpois->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ordinalAttributesYpois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ordinalAttributesYpois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ordinalAttributesYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttributesYpois->id)]) ?>
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
