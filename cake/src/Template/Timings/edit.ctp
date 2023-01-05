<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Timing $timing
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $timing->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $timing->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Timings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="timings form large-9 medium-8 columns content">
    <?= $this->Form->create($timing) ?>
    <fieldset>
        <legend><?= __('Edit Timing') ?></legend>
        <?php
            echo $this->Form->control('interviewtime');
            echo $this->Form->control('612158X1time');
            echo $this->Form->control('612158X1X2time');
            echo $this->Form->control('612158X2time');
            echo $this->Form->control('612158X2X4time');
            echo $this->Form->control('612158X3time');
            echo $this->Form->control('612158X3X5time');
            echo $this->Form->control('612158X3X75time');
            echo $this->Form->control('612158X3X7time');
            echo $this->Form->control('612158X3X6time');
            echo $this->Form->control('612158X3X8time');
            echo $this->Form->control('612158X6time');
            echo $this->Form->control('612158X6X108time');
            echo $this->Form->control('612158X6X19time');
            echo $this->Form->control('612158X6X21time');
            echo $this->Form->control('612158X4time');
            echo $this->Form->control('612158X4X9time');
            echo $this->Form->control('612158X4X10time');
            echo $this->Form->control('612158X4X11time');
            echo $this->Form->control('612158X4X12time');
            echo $this->Form->control('612158X4X13time');
            echo $this->Form->control('612158X4X14time');
            echo $this->Form->control('612158X18time');
            echo $this->Form->control('612158X18X15time');
            echo $this->Form->control('612158X5time');
            echo $this->Form->control('612158X5X262time');
            echo $this->Form->control('612158X5X16time');
            echo $this->Form->control('612158X5X93time');
            echo $this->Form->control('612158X5X94time');
            echo $this->Form->control('612158X5X95time');
            echo $this->Form->control('612158X5X17time');
            echo $this->Form->control('612158X5X18time');
            echo $this->Form->control('612158X16time');
            echo $this->Form->control('612158X16X263time');
            echo $this->Form->control('612158X16X23time');
            echo $this->Form->control('612158X16X96time');
            echo $this->Form->control('612158X16X97time');
            echo $this->Form->control('612158X16X98time');
            echo $this->Form->control('612158X16X99time');
            echo $this->Form->control('612158X16X100time');
            echo $this->Form->control('612158X16X24time');
            echo $this->Form->control('612158X16X25time');
            echo $this->Form->control('612158X17time');
            echo $this->Form->control('612158X17X264time');
            echo $this->Form->control('612158X17X26time');
            echo $this->Form->control('612158X17X101time');
            echo $this->Form->control('612158X17X102time');
            echo $this->Form->control('612158X17X103time');
            echo $this->Form->control('612158X17X104time');
            echo $this->Form->control('612158X17X105time');
            echo $this->Form->control('612158X17X106time');
            echo $this->Form->control('612158X17X107time');
            echo $this->Form->control('612158X17X27time');
            echo $this->Form->control('612158X17X28time');
            echo $this->Form->control('612158X7time');
            echo $this->Form->control('612158X7X30time');
            echo $this->Form->control('612158X10time');
            echo $this->Form->control('612158X10X41time');
            echo $this->Form->control('612158X10X70time');
            echo $this->Form->control('612158X10X50time');
            echo $this->Form->control('612158X10X52time');
            echo $this->Form->control('612158X10X71time');
            echo $this->Form->control('612158X10X53time');
            echo $this->Form->control('612158X10X265time');
            echo $this->Form->control('612158X8time');
            echo $this->Form->control('612158X8X54time');
            echo $this->Form->control('612158X8X55time');
            echo $this->Form->control('612158X9time');
            echo $this->Form->control('612158X9X72time');
            echo $this->Form->control('612158X9X73time');
            echo $this->Form->control('612158X9X74time');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
