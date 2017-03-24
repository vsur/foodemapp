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
                ['action' => 'delete', $binaryComponentsYpois->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $binaryComponentsYpois->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Binary Components Ypois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="binaryComponentsYpois form large-9 medium-8 columns content">
    <?= $this->Form->create($binaryComponentsYpois) ?>
    <fieldset>
        <legend><?= __('Edit Binary Components Ypois') ?></legend>
        <?php
            echo $this->Form->control('binary_component_id', ['options' => $binaryComponents]);
            echo $this->Form->control('ypoi_id', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
