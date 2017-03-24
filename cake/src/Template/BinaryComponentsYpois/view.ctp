<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Binary Components Ypois'), ['action' => 'edit', $binaryComponentsYpois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Binary Components Ypois'), ['action' => 'delete', $binaryComponentsYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binaryComponentsYpois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Binary Components Ypois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Binary Components Ypois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="binaryComponentsYpois view large-9 medium-8 columns content">
    <h3><?= h($binaryComponentsYpois->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Binary Component') ?></th>
            <td><?= $binaryComponentsYpois->has('binary_component') ? $this->Html->link($binaryComponentsYpois->binary_component->name, ['controller' => 'BinaryComponents', 'action' => 'view', $binaryComponentsYpois->binary_component->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ypois') ?></th>
            <td><?= $binaryComponentsYpois->has('ypois') ? $this->Html->link($binaryComponentsYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $binaryComponentsYpois->ypois->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($binaryComponentsYpois->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($binaryComponentsYpois->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($binaryComponentsYpois->modified) ?></td>
        </tr>
    </table>
</div>
