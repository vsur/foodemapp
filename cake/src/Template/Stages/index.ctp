<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stage'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stages index large-9 medium-8 columns content">
    <h3><?= __('Stages') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('component_id') ?></th>
                <th><?= $this->Paginator->sort('poi_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('rating') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stages as $stage): ?>
            <tr>
                <td><?= $this->Number->format($stage->id) ?></td>
                <td><?= $stage->has('component') ? $this->Html->link($stage->component->name, ['controller' => 'Components', 'action' => 'view', $stage->component->id]) : '' ?></td>
                <td><?= $stage->has('pois') ? $this->Html->link($stage->pois->name, ['controller' => 'Pois', 'action' => 'view', $stage->pois->id]) : '' ?></td>
                <td><?= h($stage->created) ?></td>
                <td><?= h($stage->modified) ?></td>
                <td><?= $this->Number->format($stage->rating) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $stage->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stage->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stage->id)]) ?>
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
