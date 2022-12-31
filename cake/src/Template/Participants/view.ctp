<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participant'), ['action' => 'edit', $participant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participant'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participants view large-9 medium-8 columns content">
    <h3><?= h($participant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($participant->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Startlanguage') ?></th>
            <td><?= h($participant->startlanguage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seed') ?></th>
            <td><?= h($participant->seed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X1X2') ?></th>
            <td><?= h($participant['612158X1X2']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X2X4') ?></th>
            <td><?= h($participant['612158X2X4']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X75') ?></th>
            <td><?= h($participant['612158X3X75']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X7') ?></th>
            <td><?= h($participant['612158X3X7']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X8') ?></th>
            <td><?= h($participant['612158X3X8']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ007') ?></th>
            <td><?= h($participant['612158X6X108SQ007']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ008') ?></th>
            <td><?= h($participant['612158X6X108SQ008']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ009') ?></th>
            <td><?= h($participant['612158X6X108SQ009']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ010') ?></th>
            <td><?= h($participant['612158X6X108SQ010']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ011') ?></th>
            <td><?= h($participant['612158X6X108SQ011']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ012') ?></th>
            <td><?= h($participant['612158X6X108SQ012']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ013') ?></th>
            <td><?= h($participant['612158X6X108SQ013']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ014') ?></th>
            <td><?= h($participant['612158X6X108SQ014']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ015') ?></th>
            <td><?= h($participant['612158X6X108SQ015']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ016') ?></th>
            <td><?= h($participant['612158X6X108SQ016']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ017') ?></th>
            <td><?= h($participant['612158X6X108SQ017']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ018') ?></th>
            <td><?= h($participant['612158X6X108SQ018']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ019') ?></th>
            <td><?= h($participant['612158X6X108SQ019']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ020') ?></th>
            <td><?= h($participant['612158X6X108SQ020']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ021') ?></th>
            <td><?= h($participant['612158X6X108SQ021']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ022') ?></th>
            <td><?= h($participant['612158X6X108SQ022']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ023') ?></th>
            <td><?= h($participant['612158X6X108SQ023']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ024') ?></th>
            <td><?= h($participant['612158X6X108SQ024']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108SQ026') ?></th>
            <td><?= h($participant['612158X6X108SQ026']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X19') ?></th>
            <td><?= h($participant['612158X6X19']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X21') ?></th>
            <td><?= h($participant['612158X6X21']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X9') ?></th>
            <td><?= h($participant['612158X4X9']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X10') ?></th>
            <td><?= h($participant['612158X4X10']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X11') ?></th>
            <td><?= h($participant['612158X4X11']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X12') ?></th>
            <td><?= h($participant['612158X4X12']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X13') ?></th>
            <td><?= h($participant['612158X4X13']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X14') ?></th>
            <td><?= h($participant['612158X4X14']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X18X15') ?></th>
            <td><?= h($participant['612158X18X15']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X23') ?></th>
            <td><?= h($participant['612158X16X23']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X24') ?></th>
            <td><?= h($participant['612158X16X24']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X25') ?></th>
            <td><?= h($participant['612158X16X25']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X16') ?></th>
            <td><?= h($participant['612158X5X16']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X17') ?></th>
            <td><?= h($participant['612158X5X17']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X18') ?></th>
            <td><?= h($participant['612158X5X18']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X26') ?></th>
            <td><?= h($participant['612158X17X26']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X27') ?></th>
            <td><?= h($participant['612158X17X27']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X28') ?></th>
            <td><?= h($participant['612158X17X28']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ001') ?></th>
            <td><?= h($participant['612158X7X30SQ001']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ002') ?></th>
            <td><?= h($participant['612158X7X30SQ002']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ003') ?></th>
            <td><?= h($participant['612158X7X30SQ003']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ004') ?></th>
            <td><?= h($participant['612158X7X30SQ004']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ005') ?></th>
            <td><?= h($participant['612158X7X30SQ005']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ006') ?></th>
            <td><?= h($participant['612158X7X30SQ006']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ007') ?></th>
            <td><?= h($participant['612158X7X30SQ007']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ008') ?></th>
            <td><?= h($participant['612158X7X30SQ008']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ009') ?></th>
            <td><?= h($participant['612158X7X30SQ009']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30SQ010') ?></th>
            <td><?= h($participant['612158X7X30SQ010']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ002') ?></th>
            <td><?= h($participant['612158X10X41SQ002']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ003') ?></th>
            <td><?= h($participant['612158X10X41SQ003']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ004') ?></th>
            <td><?= h($participant['612158X10X41SQ004']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ005') ?></th>
            <td><?= h($participant['612158X10X41SQ005']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ006') ?></th>
            <td><?= h($participant['612158X10X41SQ006']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41SQ007') ?></th>
            <td><?= h($participant['612158X10X41SQ007']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X70') ?></th>
            <td><?= h($participant['612158X10X70']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X8X55') ?></th>
            <td><?= h($participant['612158X8X55']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X9X74') ?></th>
            <td><?= h($participant['612158X9X74']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lastpage') ?></th>
            <td><?= $this->Number->format($participant->lastpage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X5') ?></th>
            <td><?= $this->Number->format($participant['612158X3X5']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Submitdate') ?></th>
            <td><?= h($participant->submitdate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Startdate') ?></th>
            <td><?= h($participant->startdate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Datestamp') ?></th>
            <td><?= h($participant->datestamp) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('612158X3X6') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X3X6'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X4X11other') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X4X11other'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X4X12other') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X4X12other'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X4X13other') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X4X13other'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X16X96') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X16X9'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X16X97') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X16X97'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X16X98') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X16X98'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X16X99') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X16X99'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X16X100') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X16X100'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X5X93') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X5X93'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X5X94') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X5X94'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X5X95') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X5X95'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X101') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X101'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X102') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X102'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X103') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X103'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X104') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X104'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X105') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X105'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X106') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X106'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X17X107') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X17X107'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X10X50') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X50'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X10X52') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X52'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X10X71') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X71'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X10X53') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X53'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X8X54') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X8X54'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X9X72') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X9X72'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X9X72other') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X9X72other'])); ?>
    </div>
    <div class="row">
        <h4><?= __('612158X9X73') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X9X73'])); ?>
    </div>
</div>
