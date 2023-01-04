<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participants form large-9 medium-8 columns content">
    <?= $this->Form->create($participant) ?>
    <fieldset>
        <legend><?= __('Edit Participant') ?></legend>
        <?php
            echo $this->Form->control('token');
            echo $this->Form->control('submitdate', ['empty' => true]);
            echo $this->Form->control('lastpage');
            echo $this->Form->control('startlanguage');
            echo $this->Form->control('seed');
            echo $this->Form->control('startdate');
            echo $this->Form->control('datestamp');
            echo $this->Form->control('612158X1X2');
            echo $this->Form->control('612158X2X4');
            echo $this->Form->control('612158X3X5');
            echo $this->Form->control('612158X3X75');
            echo $this->Form->control('612158X3X7');
            echo $this->Form->control('612158X3X6');
            echo $this->Form->control('612158X3X8');
            echo $this->Form->control('612158X6X108SQ007');
            echo $this->Form->control('612158X6X108SQ008');
            echo $this->Form->control('612158X6X108SQ009');
            echo $this->Form->control('612158X6X108SQ010');
            echo $this->Form->control('612158X6X108SQ011');
            echo $this->Form->control('612158X6X108SQ012');
            echo $this->Form->control('612158X6X108SQ013');
            echo $this->Form->control('612158X6X108SQ014');
            echo $this->Form->control('612158X6X108SQ015');
            echo $this->Form->control('612158X6X108SQ016');
            echo $this->Form->control('612158X6X108SQ017');
            echo $this->Form->control('612158X6X108SQ018');
            echo $this->Form->control('612158X6X108SQ019');
            echo $this->Form->control('612158X6X108SQ020');
            echo $this->Form->control('612158X6X108SQ021');
            echo $this->Form->control('612158X6X108SQ022');
            echo $this->Form->control('612158X6X108SQ023');
            echo $this->Form->control('612158X6X108SQ024');
            echo $this->Form->control('612158X6X108SQ026');
            echo $this->Form->control('612158X6X19');
            echo $this->Form->control('612158X6X21');
            echo $this->Form->control('612158X4X9');
            echo $this->Form->control('612158X4X10');
            echo $this->Form->control('612158X4X11');
            echo $this->Form->control('612158X4X11other');
            echo $this->Form->control('612158X4X12');
            echo $this->Form->control('612158X4X12other');
            echo $this->Form->control('612158X4X13');
            echo $this->Form->control('612158X4X13other');
            echo $this->Form->control('612158X4X14');
            echo $this->Form->control('612158X18X15');
            echo $this->Form->control('612158X5X262');
            echo $this->Form->control('612158X5X16');
            echo $this->Form->control('612158X5X93');
            echo $this->Form->control('612158X5X94');
            echo $this->Form->control('612158X5X95');
            echo $this->Form->control('612158X5X17');
            echo $this->Form->control('612158X5X18');
            echo $this->Form->control('612158X16X263');
            echo $this->Form->control('612158X16X23');
            echo $this->Form->control('612158X16X96');
            echo $this->Form->control('612158X16X97');
            echo $this->Form->control('612158X16X98');
            echo $this->Form->control('612158X16X99');
            echo $this->Form->control('612158X16X100');
            echo $this->Form->control('612158X16X24');
            echo $this->Form->control('612158X16X25');
            echo $this->Form->control('612158X17X264');
            echo $this->Form->control('612158X17X26');
            echo $this->Form->control('612158X17X101');
            echo $this->Form->control('612158X17X102');
            echo $this->Form->control('612158X17X103');
            echo $this->Form->control('612158X17X104');
            echo $this->Form->control('612158X17X105');
            echo $this->Form->control('612158X17X106');
            echo $this->Form->control('612158X17X107');
            echo $this->Form->control('612158X17X27');
            echo $this->Form->control('612158X17X28');
            echo $this->Form->control('612158X7X30SQ001');
            echo $this->Form->control('612158X7X30SQ002');
            echo $this->Form->control('612158X7X30SQ003');
            echo $this->Form->control('612158X7X30SQ004');
            echo $this->Form->control('612158X7X30SQ005');
            echo $this->Form->control('612158X7X30SQ006');
            echo $this->Form->control('612158X7X30SQ007');
            echo $this->Form->control('612158X7X30SQ008');
            echo $this->Form->control('612158X7X30SQ009');
            echo $this->Form->control('612158X7X30SQ010');
            echo $this->Form->control('612158X10X41SQ002');
            echo $this->Form->control('612158X10X41SQ003');
            echo $this->Form->control('612158X10X41SQ004');
            echo $this->Form->control('612158X10X41SQ005');
            echo $this->Form->control('612158X10X41SQ006');
            echo $this->Form->control('612158X10X41SQ007');
            echo $this->Form->control('612158X10X70');
            echo $this->Form->control('612158X10X50');
            echo $this->Form->control('612158X10X52');
            echo $this->Form->control('612158X10X71');
            echo $this->Form->control('612158X10X53');
            echo $this->Form->control('612158X10X265');
            echo $this->Form->control('612158X8X54');
            echo $this->Form->control('612158X8X55');
            echo $this->Form->control('612158X9X72');
            echo $this->Form->control('612158X9X72other');
            echo $this->Form->control('612158X9X73');
            echo $this->Form->control('612158X9X74');
            echo $this->Form->control('codes._ids', ['options' => $codes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
