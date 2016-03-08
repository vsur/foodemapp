<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $poisTag->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $poisTag->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Pois Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="poisTags form large-9 medium-8 columns content">
    <?= $this->Form->create($poisTag) ?>
    <fieldset>
        <legend><?= __('Edit Pois Tag') ?></legend>
        <?php
            echo $this->Form->input('poi_id');
            echo $this->Form->input('tag_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
