<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ordinal Attributes Ypois'), ['action' => 'edit', $ordinalAttributesYpois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ordinal Attributes Ypois'), ['action' => 'delete', $ordinalAttributesYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttributesYpois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Attributes Ypois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Attributes Ypois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ordinalAttributesYpois view large-9 medium-8 columns content">
    <h3><?= h($ordinalAttributesYpois->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Ordinal Attribute') ?></th>
            <td><?= $ordinalAttributesYpois->has('ordinal_attribute') ? $this->Html->link($ordinalAttributesYpois->ordinal_attribute->name, ['controller' => 'OrdinalAttributes', 'action' => 'view', $ordinalAttributesYpois->ordinal_attribute->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ypois') ?></th>
            <td><?= $ordinalAttributesYpois->has('ypois') ? $this->Html->link($ordinalAttributesYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $ordinalAttributesYpois->ypois->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ordinalAttributesYpois->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($ordinalAttributesYpois->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($ordinalAttributesYpois->modified) ?></td>
        </tr>
    </table>
</div>
