<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Nominal Attributes Ypois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nominalAttributesYpois index large-9 medium-8 columns content">
    <h3><?= __('Nominal Attributes Ypois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nominal_attribute_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ypoi_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nominalAttributesYpois as $nominalAttributesYpois): ?>
            <tr>
                <td><?= $this->Number->format($nominalAttributesYpois->id) ?></td>
                <td><?= $nominalAttributesYpois->has('nominal_attribute') ? $this->Html->link($nominalAttributesYpois->nominal_attribute->name, ['controller' => 'NominalAttributes', 'action' => 'view', $nominalAttributesYpois->nominal_attribute->id]) : '' ?></td>
                <td><?= $nominalAttributesYpois->has('ypois') ? $this->Html->link($nominalAttributesYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $nominalAttributesYpois->ypois->id]) : '' ?></td>
                <td><?= h($nominalAttributesYpois->created) ?></td>
                <td><?= h($nominalAttributesYpois->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $nominalAttributesYpois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $nominalAttributesYpois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $nominalAttributesYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttributesYpois->id)]) ?>
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
