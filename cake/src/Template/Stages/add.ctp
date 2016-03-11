<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Stages'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stages form large-9 medium-8 columns content">
    <?= $this->Form->create($stage) ?>
    <fieldset>
        <legend><?= __('Add Stage') ?></legend>
        <?php
            echo $this->Form->input('component_id', ['options' => $components]);
            echo $this->Form->input('poi_id', ['options' => $pois]);
            echo $this->Form->input('rating');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
