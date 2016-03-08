<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Components Pois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="componentsPois index large-9 medium-8 columns content">
    <h3><?= __('Components Pois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('component_id') ?></th>
                <th><?= $this->Paginator->sort('poi_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modiefied') ?></th>
                <th><?= $this->Paginator->sort('stage') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componentsPois as $componentsPois): ?>
            <tr>
                <td><?= $this->Number->format($componentsPois->component_id) ?></td>
                <td><?= $this->Number->format($componentsPois->poi_id) ?></td>
                <td><?= h($componentsPois->created) ?></td>
                <td><?= h($componentsPois->modiefied) ?></td>
                <td><?= $this->Number->format($componentsPois->stage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $componentsPois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $componentsPois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $componentsPois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $componentsPois->id)]) ?>
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
