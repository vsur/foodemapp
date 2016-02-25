<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $component->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $component->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Components'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="components form large-9 medium-8 columns content">
    <?= $this->Form->create($component) ?>
    <fieldset>
        <legend><?= __('Edit Component') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('pois._ids', ['options' => $pois]);
            echo $this->Form->input('scenarios._ids', ['options' => $scenarios]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
