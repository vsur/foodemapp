<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $componentsScenario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $componentsScenario->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Components Scenarios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="componentsScenarios form large-9 medium-8 columns content">
    <?= $this->Form->create($componentsScenario) ?>
    <fieldset>
        <legend><?= __('Edit Components Scenario') ?></legend>
        <?php
            echo $this->Form->input('component_id');
            echo $this->Form->input('scenario_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
