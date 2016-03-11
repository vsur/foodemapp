<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Scenario'), ['action' => 'edit', $scenario->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Scenario'), ['action' => 'delete', $scenario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenario->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="scenarios view large-9 medium-8 columns content">
    <h3><?= h($scenario->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($scenario->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($scenario->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Thumbnail') ?></th>
            <td><?= h($scenario->thumbnail) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($scenario->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Counter') ?></th>
            <td><?= $this->Number->format($scenario->counter) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($scenario->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($scenario->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Components') ?></h4>
        <?php if (!empty($scenario->components)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($scenario->components as $components): ?>
            <tr>
                <td><?= h($components->id) ?></td>
                <td><?= h($components->created) ?></td>
                <td><?= h($components->modified) ?></td>
                <td><?= h($components->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Components', 'action' => 'view', $components->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Components', 'action' => 'edit', $components->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Components', 'action' => 'delete', $components->id], ['confirm' => __('Are you sure you want to delete # {0}?', $components->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
