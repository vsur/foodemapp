<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes Ypois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ordinalAttributesYpois form large-9 medium-8 columns content">
    <?= $this->Form->create($ordinalAttributesYpois) ?>
    <fieldset>
        <legend><?= __('Add Ordinal Attributes Ypois') ?></legend>
        <?php
            echo $this->Form->control('ordinal_attribute_id', ['options' => $ordinalAttributes]);
            echo $this->Form->control('ypoi_id', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
