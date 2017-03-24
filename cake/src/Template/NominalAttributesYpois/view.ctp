<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Nominal Attributes Ypois'), ['action' => 'edit', $nominalAttributesYpois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Nominal Attributes Ypois'), ['action' => 'delete', $nominalAttributesYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttributesYpois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Nominal Attributes Ypois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nominal Attributes Ypois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="nominalAttributesYpois view large-9 medium-8 columns content">
    <h3><?= h($nominalAttributesYpois->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nominal Attribute') ?></th>
            <td><?= $nominalAttributesYpois->has('nominal_attribute') ? $this->Html->link($nominalAttributesYpois->nominal_attribute->name, ['controller' => 'NominalAttributes', 'action' => 'view', $nominalAttributesYpois->nominal_attribute->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ypois') ?></th>
            <td><?= $nominalAttributesYpois->has('ypois') ? $this->Html->link($nominalAttributesYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $nominalAttributesYpois->ypois->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($nominalAttributesYpois->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($nominalAttributesYpois->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($nominalAttributesYpois->modified) ?></td>
        </tr>
    </table>
</div>
