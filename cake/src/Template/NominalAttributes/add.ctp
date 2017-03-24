<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Components'), ['controller' => 'NominalComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Component'), ['controller' => 'NominalComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nominalAttributes form large-9 medium-8 columns content">
    <?= $this->Form->create($nominalAttribute) ?>
    <fieldset>
        <legend><?= __('Add Nominal Attribute') ?></legend>
        <?php
            echo $this->Form->control('nominal_component_id', ['options' => $nominalComponents]);
            echo $this->Form->control('name');
            echo $this->Form->control('display_name');
            echo $this->Form->control('icon_path');
            echo $this->Form->control('ypois._ids', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
