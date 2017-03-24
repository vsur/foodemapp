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
                ['action' => 'delete', $nominalAttributesYpois->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttributesYpois->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes Ypois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="nominalAttributesYpois form large-9 medium-8 columns content">
    <?= $this->Form->create($nominalAttributesYpois) ?>
    <fieldset>
        <legend><?= __('Edit Nominal Attributes Ypois') ?></legend>
        <?php
            echo $this->Form->control('nominal_attribute_id', ['options' => $nominalAttributes]);
            echo $this->Form->control('ypoi_id', ['options' => $ypois]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
