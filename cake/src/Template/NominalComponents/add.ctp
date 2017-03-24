<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Nominal Components'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nominalComponents form large-9 medium-8 columns content">
    <?= $this->Form->create($nominalComponent) ?>
    <fieldset>
        <legend><?= __('Add Nominal Component') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('display_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
