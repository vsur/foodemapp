<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Code[]|\Cake\Collection\CollectionInterface $codes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Code'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Field Types'), ['controller' => 'FieldTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Field Type'), ['controller' => 'FieldTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="codes index large-9 medium-8 columns content">
    <h3><?= __('Codes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('field_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($codes as $code): ?>
            <tr>
                <td><?= $this->Number->format($code->id) ?></td>
                <td><?= $code->has('field_type') ? $this->Html->link($code->field_type->name, ['controller' => 'FieldTypes', 'action' => 'view', $code->field_type->id]) : '' ?></td>
                <td><?= h($code->name) ?></td>
                <td><?= h($code->created) ?></td>
                <td><?= h($code->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $code->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $code->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $code->id], ['confirm' => __('Are you sure you want to delete # {0}?', $code->id)]) ?>
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
