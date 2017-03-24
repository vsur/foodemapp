<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Nominal Component'), ['action' => 'edit', $nominalComponent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Nominal Component'), ['action' => 'delete', $nominalComponent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalComponent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Nominal Components'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nominal Component'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="nominalComponents view large-9 medium-8 columns content">
    <h3><?= h($nominalComponent->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($nominalComponent->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Name') ?></th>
            <td><?= h($nominalComponent->display_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($nominalComponent->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($nominalComponent->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($nominalComponent->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Nominal Attributes') ?></h4>
        <?php if (!empty($nominalComponent->nominal_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nominal Component Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Display Name') ?></th>
                <th scope="col"><?= __('Icon Path') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($nominalComponent->nominal_attributes as $nominalAttributes): ?>
            <tr>
                <td><?= h($nominalAttributes->id) ?></td>
                <td><?= h($nominalAttributes->nominal_component_id) ?></td>
                <td><?= h($nominalAttributes->name) ?></td>
                <td><?= h($nominalAttributes->display_name) ?></td>
                <td><?= h($nominalAttributes->icon_path) ?></td>
                <td><?= h($nominalAttributes->created) ?></td>
                <td><?= h($nominalAttributes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'NominalAttributes', 'action' => 'view', $nominalAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'NominalAttributes', 'action' => 'edit', $nominalAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'NominalAttributes', 'action' => 'delete', $nominalAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
