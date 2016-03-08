<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Components Scenario'), ['action' => 'edit', $componentsScenario->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Components Scenario'), ['action' => 'delete', $componentsScenario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $componentsScenario->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components Scenarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Components Scenario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="componentsScenarios view large-9 medium-8 columns content">
    <h3><?= h($componentsScenario->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Component Id') ?></th>
            <td><?= $this->Number->format($componentsScenario->component_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Scenario Id') ?></th>
            <td><?= $this->Number->format($componentsScenario->scenario_id) ?></td>
        </tr>
    </table>
</div>
