<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Scenario'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="scenarios index large-9 medium-8 columns content">
    <h3><?= __('Scenarios') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('thumbnail') ?></th>
                <th><?= $this->Paginator->sort('counter') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($scenarios as $scenario): ?>
            <tr>
                <td><?= $this->Number->format($scenario->id) ?></td>
                <td><?= h($scenario->created) ?></td>
                <td><?= h($scenario->modified) ?></td>
                <td><?= h($scenario->name) ?></td>
                <td><?= h($scenario->description) ?></td>
                <td><?= h($scenario->thumbnail) ?></td>
                <td><?= $this->Number->format($scenario->counter) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $scenario->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $scenario->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $scenario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenario->id)]) ?>
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
