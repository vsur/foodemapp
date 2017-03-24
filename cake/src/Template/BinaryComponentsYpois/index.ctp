<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Binary Components Ypois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="binaryComponentsYpois index large-9 medium-8 columns content">
    <h3><?= __('Binary Components Ypois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('binary_component_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ypoi_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($binaryComponentsYpois as $binaryComponentsYpois): ?>
            <tr>
                <td><?= $this->Number->format($binaryComponentsYpois->id) ?></td>
                <td><?= $binaryComponentsYpois->has('binary_component') ? $this->Html->link($binaryComponentsYpois->binary_component->name, ['controller' => 'BinaryComponents', 'action' => 'view', $binaryComponentsYpois->binary_component->id]) : '' ?></td>
                <td><?= $binaryComponentsYpois->has('ypois') ? $this->Html->link($binaryComponentsYpois->ypois->name, ['controller' => 'Ypois', 'action' => 'view', $binaryComponentsYpois->ypois->id]) : '' ?></td>
                <td><?= h($binaryComponentsYpois->created) ?></td>
                <td><?= h($binaryComponentsYpois->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $binaryComponentsYpois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $binaryComponentsYpois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $binaryComponentsYpois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binaryComponentsYpois->id)]) ?>
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
