<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Components Scenario'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="componentsScenarios index large-9 medium-8 columns content">
    <h3><?= __('Components Scenarios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('component_id') ?></th>
                <th><?= $this->Paginator->sort('scenario_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentsScenarios as $componentsScenario): ?>
            <tr>
                <td><?= $componentsScenario->has('component') ? $this->Html->link($componentsScenario->component->name, ['controller' => 'Components', 'action' => 'view', $componentsScenario->component->id]) : '' ?></td>
                <td><?= $componentsScenario->has('scenario') ? $this->Html->link($componentsScenario->scenario->name, ['controller' => 'Scenarios', 'action' => 'view', $componentsScenario->scenario->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $componentsScenario->component_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $componentsScenario->component_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $componentsScenario->component_id], ['confirm' => __('Are you sure you want to delete # {0}?', $componentsScenario->component_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
