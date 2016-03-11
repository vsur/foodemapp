<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Pois Tag'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="poisTags index large-9 medium-8 columns content">
    <h3><?= __('Pois Tags') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('poi_id') ?></th>
                <th><?= $this->Paginator->sort('tag_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($poisTags as $poisTag): ?>
            <tr>
                <td><?= $poisTag->has('pois') ? $this->Html->link($poisTag->pois->name, ['controller' => 'Pois', 'action' => 'view', $poisTag->pois->id]) : '' ?></td>
                <td><?= $poisTag->has('tag') ? $this->Html->link($poisTag->tag->title, ['controller' => 'Tags', 'action' => 'view', $poisTag->tag->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $poisTag->poi_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $poisTag->poi_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $poisTag->poi_id], ['confirm' => __('Are you sure you want to delete # {0}?', $poisTag->poi_id)]) ?>
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
