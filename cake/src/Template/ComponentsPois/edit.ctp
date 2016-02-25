<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $componentsPois->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $componentsPois->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Components Pois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="componentsPois form large-9 medium-8 columns content">
    <?= $this->Form->create($componentsPois) ?>
    <fieldset>
        <legend><?= __('Edit Components Pois') ?></legend>
        <?php
            echo $this->Form->input('modiefied');
            echo $this->Form->input('stage');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
