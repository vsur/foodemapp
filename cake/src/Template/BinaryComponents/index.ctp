<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Binary Component'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="binaryComponents index large-9 medium-8 columns content">
    <h3><?= __('Binary Components') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('display_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($binaryComponents as $binaryComponent): ?>
            <tr>
                <td><?= $this->Number->format($binaryComponent->id) ?></td>
                <td><?= h($binaryComponent->name) ?></td>
                <td><?= h($binaryComponent->display_name) ?></td>
                <td><?= h($binaryComponent->created) ?></td>
                <td><?= h($binaryComponent->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $binaryComponent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $binaryComponent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $binaryComponent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binaryComponent->id)]) ?>
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
