<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(__('Delete Request Evaluation'), ['action' => 'delete', $requestEvaluation->id, 'doStuff'], ['confirm' => __('Are you sure you want to delete # {0}?', $requestEvaluation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Request Evaluations'), ['action' => 'index', 'doStuff']) ?> </li>
    </ul>
</nav>
<div class="requestEvaluations view large-9 medium-8 columns content">
    <h3><?= h($requestEvaluation->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Query Parameters') ?></th>
            <td><?= h($requestEvaluation->query_parameters) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comming From View') ?></th>
            <td><?= h($requestEvaluation->comming_from_view) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('View To Evaluate') ?></th>
            <td><?= h($requestEvaluation->view_to_evaluate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($requestEvaluation->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($requestEvaluation->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($requestEvaluation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ypois Count') ?></th>
            <td><?= $this->Number->format($requestEvaluation->ypois_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Choosen Components Count') ?></th>
            <td><?= $this->Number->format($requestEvaluation->choosen_components_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Components Count') ?></th>
            <td><?= $this->Number->format($requestEvaluation->other_components_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grade') ?></th>
            <td><?= $this->Number->format($requestEvaluation->grade) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($requestEvaluation->comment)); ?>
    </div>
</div>
