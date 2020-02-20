<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $requestEvaluation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $requestEvaluation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Request Evaluations'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="requestEvaluations form large-9 medium-8 columns content">
    <?= $this->Form->create($requestEvaluation) ?>
    <fieldset>
        <legend><?= __('Edit Request Evaluation') ?></legend>
        <?php
            echo $this->Form->control('query_parameters');
            echo $this->Form->control('ypois_count');
            echo $this->Form->control('choosen_components_count');
            echo $this->Form->control('other_components_count');
            echo $this->Form->control('comming_from_view');
            echo $this->Form->control('view_to_evaluate');
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('grade');
            echo $this->Form->control('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
