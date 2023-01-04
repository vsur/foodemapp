<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsCode $participantsCode
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participants Code'), ['action' => 'edit', $participantsCode->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participants Code'), ['action' => 'delete', $participantsCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participantsCode->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participants Codes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participants Code'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participantsCodes view large-9 medium-8 columns content">
    <h3><?= h($participantsCode->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Participant') ?></th>
            <td><?= $participantsCode->has('participant') ? $this->Html->link($participantsCode->participant->id, ['controller' => 'Participants', 'action' => 'view', $participantsCode->participant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= $participantsCode->has('code') ? $this->Html->link($participantsCode->code->name, ['controller' => 'Codes', 'action' => 'view', $participantsCode->code->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vizvar') ?></th>
            <td><?= h($participantsCode->vizvar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participantsCode->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($participantsCode->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($participantsCode->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($participantsCode->description)); ?>
    </div>
</div>
