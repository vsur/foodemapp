<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsCode $participantsCode
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participantsCode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participantsCode->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Participants Codes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participantsCodes form large-9 medium-8 columns content">
    <?= $this->Form->create($participantsCode) ?>
    <fieldset>
        <legend><?= __('Edit Participants Code') ?></legend>
        <?php
            echo $this->Form->control('participant_id', ['options' => $participants]);
            echo $this->Form->control('code_id', ['options' => $codes]);
            echo $this->Form->control('vizvar');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
