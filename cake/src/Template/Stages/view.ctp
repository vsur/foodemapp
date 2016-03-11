<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stage'), ['action' => 'edit', $stage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stage'), ['action' => 'delete', $stage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stage'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stages view large-9 medium-8 columns content">
    <h3><?= h($stage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Component') ?></th>
            <td><?= $stage->has('component') ? $this->Html->link($stage->component->name, ['controller' => 'Components', 'action' => 'view', $stage->component->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Pois') ?></th>
            <td><?= $stage->has('pois') ? $this->Html->link($stage->pois->name, ['controller' => 'Pois', 'action' => 'view', $stage->pois->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($stage->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Rating') ?></th>
            <td><?= $this->Number->format($stage->rating) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($stage->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($stage->modified) ?></td>
        </tr>
    </table>
</div>
