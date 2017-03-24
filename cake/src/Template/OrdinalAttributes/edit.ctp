<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ordinalAttribute->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttribute->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Components'), ['controller' => 'OrdinalComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Component'), ['controller' => 'OrdinalComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalAttributes form large-9 medium-8 columns content">
    <?= $this->Form->create($ordinalAttribute) ?>
    <fieldset>
        <legend><?= __('Edit Ordinal Attribute') ?></legend>
        <?php
            echo $this->Form->control('ordinal_component_id', ['options' => $ordinalComponents]);
            echo $this->Form->control('name');
            echo $this->Form->control('display_name');
            echo $this->Form->control('meter');
            echo $this->Form->control('ypois._ids', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
