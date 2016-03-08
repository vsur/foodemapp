<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Pois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pois form large-9 medium-8 columns content">
    <?= $this->Form->create($pois) ?>
    <fieldset>
        <legend><?= __('Add Pois') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('lat');
            echo $this->Form->input('lng');
            echo $this->Form->input('google_place');
            echo $this->Form->input('icon');
            echo $this->Form->input('rating');
            echo $this->Form->input('vicinity');
            echo $this->Form->input('formatted_phone_number');
            echo $this->Form->input('mail');
            echo $this->Form->input('website');
            echo $this->Form->input('social');
            echo $this->Form->input('description');
            echo $this->Form->input('user_ratings_total');
            echo $this->Form->input('opening_hours');
            echo $this->Form->input('weekday_text');
            echo $this->Form->input('photos');
            echo $this->Form->input('reviews');
            echo $this->Form->input('components._ids', ['options' => $components]);
            echo $this->Form->input('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
