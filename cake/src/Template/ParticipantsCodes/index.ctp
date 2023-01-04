<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ParticipantsCode[]|\Cake\Collection\CollectionInterface $participantsCodes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Participants Code'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participantsCodes index large-9 medium-8 columns content">
    <h3><?= __('Participants Codes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('participant_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('vizvar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participantsCodes as $participantsCode): ?>
            <tr>
                <td><?= $this->Number->format($participantsCode->id) ?></td>
                <td><?= $participantsCode->has('participant') ? $this->Html->link($participantsCode->participant->id, ['controller' => 'Participants', 'action' => 'view', $participantsCode->participant->id]) : '' ?></td>
                <td><?= $participantsCode->has('code') ? $this->Html->link($participantsCode->code->name, ['controller' => 'Codes', 'action' => 'view', $participantsCode->code->id]) : '' ?></td>
                <td><?= h($participantsCode->vizvar) ?></td>
                <td><?= h($participantsCode->created) ?></td>
                <td><?= h($participantsCode->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participantsCode->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participantsCode->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participantsCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participantsCode->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
