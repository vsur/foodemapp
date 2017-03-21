<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ypois->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ypois->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ypois'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ypois form large-9 medium-8 columns content">
    <?= $this->Form->create($ypois) ?>
    <fieldset>
        <legend><?= __('Edit Ypois') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('lat');
            echo $this->Form->control('lng');
            echo $this->Form->control('google_place');
            echo $this->Form->control('businessid');
            echo $this->Form->control('icon');
            echo $this->Form->control('rating');
            echo $this->Form->control('vicinity');
            echo $this->Form->control('city');
            echo $this->Form->control('state');
            echo $this->Form->control('full_address');
            echo $this->Form->control('formatted_phone_number');
            echo $this->Form->control('mail');
            echo $this->Form->control('website');
            echo $this->Form->control('social');
            echo $this->Form->control('description');
            echo $this->Form->control('user_ratings_total');
            echo $this->Form->control('stars');
            echo $this->Form->control('opening_hours');
            echo $this->Form->control('weekday_text');
            echo $this->Form->control('photos');
            echo $this->Form->control('reviews');
            echo $this->Form->control('review_count');
            echo $this->Form->control('binary_components._ids', ['options' => $binaryComponents]);
            echo $this->Form->control('nominal_attributes._ids', ['options' => $nominalAttributes]);
            echo $this->Form->control('ordinal_attributes._ids', ['options' => $ordinalAttributes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
