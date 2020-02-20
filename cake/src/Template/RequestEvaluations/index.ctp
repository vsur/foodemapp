<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Request Evaluation'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requestEvaluations index large-9 medium-8 columns content">
    <h3><?= __('Request Evaluations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('query_parameters') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ypois_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('choosen_components_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('other_components_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comming_from_view') ?></th>
                <th scope="col"><?= $this->Paginator->sort('view_to_evaluate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grade') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requestEvaluations as $requestEvaluation): ?>
            <tr>
                <td><?= $this->Number->format($requestEvaluation->id) ?></td>
                <td><?= h($requestEvaluation->query_parameters) ?></td>
                <td><?= $this->Number->format($requestEvaluation->ypois_count) ?></td>
                <td><?= $this->Number->format($requestEvaluation->choosen_components_count) ?></td>
                <td><?= $this->Number->format($requestEvaluation->other_components_count) ?></td>
                <td><?= h($requestEvaluation->comming_from_view) ?></td>
                <td><?= h($requestEvaluation->view_to_evaluate) ?></td>
                <td><?= h($requestEvaluation->name) ?></td>
                <td><?= h($requestEvaluation->email) ?></td>
                <td><?= $this->Number->format($requestEvaluation->grade) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $requestEvaluation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $requestEvaluation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $requestEvaluation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requestEvaluation->id)]) ?>
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
