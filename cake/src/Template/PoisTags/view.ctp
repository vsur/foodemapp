<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pois Tag'), ['action' => 'edit', $poisTag->poi_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pois Tag'), ['action' => 'delete', $poisTag->poi_id], ['confirm' => __('Are you sure you want to delete # {0}?', $poisTag->poi_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pois Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="poisTags view large-9 medium-8 columns content">
    <h3><?= h($poisTag->poi_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Pois') ?></th>
            <td><?= $poisTag->has('pois') ? $this->Html->link($poisTag->pois->name, ['controller' => 'Pois', 'action' => 'view', $poisTag->pois->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Tag') ?></th>
            <td><?= $poisTag->has('tag') ? $this->Html->link($poisTag->tag->title, ['controller' => 'Tags', 'action' => 'view', $poisTag->tag->id]) : '' ?></td>
        </tr>
    </table>
</div>
