<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Component'), ['action' => 'edit', $component->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Component'), ['action' => 'delete', $component->id], ['confirm' => __('Are you sure you want to delete # {0}?', $component->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stages'), ['controller' => 'Stages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stage'), ['controller' => 'Stages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="components view large-9 medium-8 columns content">
    <h3><?= h($component->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($component->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($component->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($component->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($component->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Stages') ?></h4>
        <?php if (!empty($component->stages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Component Id') ?></th>
                <th><?= __('Poi Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Rating') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($component->stages as $stages): ?>
            <tr>
                <td><?= h($stages->id) ?></td>
                <td><?= h($stages->component_id) ?></td>
                <td><?= h($stages->poi_id) ?></td>
                <td><?= h($stages->created) ?></td>
                <td><?= h($stages->modified) ?></td>
                <td><?= h($stages->rating) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Stages', 'action' => 'view', $stages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Stages', 'action' => 'edit', $stages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Stages', 'action' => 'delete', $stages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Scenarios') ?></h4>
        <?php if (!empty($component->scenarios)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Thumbnail') ?></th>
                <th><?= __('Counter') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($component->scenarios as $scenarios): ?>
            <tr>
                <td><?= h($scenarios->id) ?></td>
                <td><?= h($scenarios->created) ?></td>
                <td><?= h($scenarios->modified) ?></td>
                <td><?= h($scenarios->name) ?></td>
                <td><?= h($scenarios->description) ?></td>
                <td><?= h($scenarios->thumbnail) ?></td>
                <td><?= h($scenarios->counter) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Scenarios', 'action' => 'view', $scenarios->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Scenarios', 'action' => 'edit', $scenarios->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Scenarios', 'action' => 'delete', $scenarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenarios->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
