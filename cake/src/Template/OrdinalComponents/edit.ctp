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
                ['action' => 'delete', $ordinalComponent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalComponent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ordinal Components'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalComponents form large-9 medium-8 columns content">
    <?= $this->Form->create($ordinalComponent) ?>
    <fieldset>
        <legend><?= __('Edit Ordinal Component') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('display_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
