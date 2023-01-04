<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Code $code
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $code->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $code->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Field Types'), ['controller' => 'FieldTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field Type'), ['controller' => 'FieldTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="codes form large-9 medium-8 columns content">
    <?= $this->Form->create($code) ?>
    <fieldset>
        <legend><?= __('Edit Code') ?></legend>
        <?php
            echo $this->Form->control('field_type_id', ['options' => $fieldTypes]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('participants._ids', ['options' => $participants]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
