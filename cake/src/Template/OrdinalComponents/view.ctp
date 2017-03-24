<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ordinal Component'), ['action' => 'edit', $ordinalComponent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ordinal Component'), ['action' => 'delete', $ordinalComponent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalComponent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Components'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Component'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ordinalComponents view large-9 medium-8 columns content">
    <h3><?= h($ordinalComponent->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($ordinalComponent->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Name') ?></th>
            <td><?= h($ordinalComponent->display_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ordinalComponent->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($ordinalComponent->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($ordinalComponent->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ordinal Attributes') ?></h4>
        <?php if (!empty($ordinalComponent->ordinal_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ordinal Component Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Display Name') ?></th>
                <th scope="col"><?= __('Meter') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ordinalComponent->ordinal_attributes as $ordinalAttributes): ?>
            <tr>
                <td><?= h($ordinalAttributes->id) ?></td>
                <td><?= h($ordinalAttributes->ordinal_component_id) ?></td>
                <td><?= h($ordinalAttributes->name) ?></td>
                <td><?= h($ordinalAttributes->display_name) ?></td>
                <td><?= h($ordinalAttributes->meter) ?></td>
                <td><?= h($ordinalAttributes->created) ?></td>
                <td><?= h($ordinalAttributes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrdinalAttributes', 'action' => 'view', $ordinalAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrdinalAttributes', 'action' => 'edit', $ordinalAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrdinalAttributes', 'action' => 'delete', $ordinalAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
