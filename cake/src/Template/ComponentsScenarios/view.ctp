<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Components Scenario'), ['action' => 'edit', $componentsScenario->component_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Components Scenario'), ['action' => 'delete', $componentsScenario->component_id], ['confirm' => __('Are you sure you want to delete # {0}?', $componentsScenario->component_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components Scenarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Components Scenario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="componentsScenarios view large-9 medium-8 columns content">
    <h3><?= h($componentsScenario->component_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Component') ?></th>
            <td><?= $componentsScenario->has('component') ? $this->Html->link($componentsScenario->component->name, ['controller' => 'Components', 'action' => 'view', $componentsScenario->component->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Scenario') ?></th>
            <td><?= $componentsScenario->has('scenario') ? $this->Html->link($componentsScenario->scenario->name, ['controller' => 'Scenarios', 'action' => 'view', $componentsScenario->scenario->id]) : '' ?></td>
        </tr>
    </table>
</div>
