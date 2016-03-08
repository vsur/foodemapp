<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Components Pois'), ['action' => 'edit', $componentsPois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Components Pois'), ['action' => 'delete', $componentsPois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $componentsPois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components Pois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Components Pois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="componentsPois view large-9 medium-8 columns content">
    <h3><?= h($componentsPois->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Component Id') ?></th>
            <td><?= $this->Number->format($componentsPois->component_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Poi Id') ?></th>
            <td><?= $this->Number->format($componentsPois->poi_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Stage') ?></th>
            <td><?= $this->Number->format($componentsPois->stage) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($componentsPois->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modiefied') ?></th>
            <td><?= h($componentsPois->modiefied) ?></td>
        </tr>
    </table>
</div>
