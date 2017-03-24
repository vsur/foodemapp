<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Binary Components'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="binaryComponents form large-9 medium-8 columns content">
    <?= $this->Form->create($binaryComponent) ?>
    <fieldset>
        <legend><?= __('Add Binary Component') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('display_name');
            echo $this->Form->control('ypois._ids', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
