<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FieldType $fieldType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fieldType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fieldType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Field Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fieldTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($fieldType) ?>
    <fieldset>
        <legend><?= __('Edit Field Type') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
