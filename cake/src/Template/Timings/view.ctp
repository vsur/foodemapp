<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Timing $timing
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Timing'), ['action' => 'edit', $timing->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Timing'), ['action' => 'delete', $timing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timing->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Timings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Timing'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="timings view large-9 medium-8 columns content">
    <h3><?= h($timing->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($timing->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Interviewtime') ?></th>
            <td><?= $this->Number->format($timing->interviewtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X1time') ?></th>
            <td><?= $this->Number->format($timing->612158X1time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X1X2time') ?></th>
            <td><?= $this->Number->format($timing->612158X1X2time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X2time') ?></th>
            <td><?= $this->Number->format($timing->612158X2time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X2X4time') ?></th>
            <td><?= $this->Number->format($timing->612158X2X4time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3time') ?></th>
            <td><?= $this->Number->format($timing->612158X3time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X5time') ?></th>
            <td><?= $this->Number->format($timing->612158X3X5time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X75time') ?></th>
            <td><?= $this->Number->format($timing->612158X3X75time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X7time') ?></th>
            <td><?= $this->Number->format($timing->612158X3X7time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X6time') ?></th>
            <td><?= $this->Number->format($timing->612158X3X6time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X3X8time') ?></th>
            <td><?= $this->Number->format($timing->612158X3X8time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6time') ?></th>
            <td><?= $this->Number->format($timing->612158X6time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X108time') ?></th>
            <td><?= $this->Number->format($timing->612158X6X108time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X19time') ?></th>
            <td><?= $this->Number->format($timing->612158X6X19time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X6X21time') ?></th>
            <td><?= $this->Number->format($timing->612158X6X21time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4time') ?></th>
            <td><?= $this->Number->format($timing->612158X4time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X9time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X9time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X10time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X10time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X11time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X11time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X12time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X12time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X13time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X13time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X4X14time') ?></th>
            <td><?= $this->Number->format($timing->612158X4X14time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X18time') ?></th>
            <td><?= $this->Number->format($timing->612158X18time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X18X15time') ?></th>
            <td><?= $this->Number->format($timing->612158X18X15time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5time') ?></th>
            <td><?= $this->Number->format($timing->612158X5time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X262time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X262time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X16time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X16time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X93time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X93time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X94time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X94time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X95time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X95time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X17time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X17time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X5X18time') ?></th>
            <td><?= $this->Number->format($timing->612158X5X18time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16time') ?></th>
            <td><?= $this->Number->format($timing->612158X16time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X263time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X263time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X23time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X23time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X96time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X96time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X97time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X97time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X98time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X98time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X99time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X99time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X100time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X100time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X24time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X24time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X16X25time') ?></th>
            <td><?= $this->Number->format($timing->612158X16X25time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17time') ?></th>
            <td><?= $this->Number->format($timing->612158X17time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X264time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X264time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X26time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X26time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X101time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X101time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X102time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X102time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X103time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X103time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X104time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X104time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X105time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X105time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X106time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X106time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X107time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X107time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X27time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X27time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X17X28time') ?></th>
            <td><?= $this->Number->format($timing->612158X17X28time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7time') ?></th>
            <td><?= $this->Number->format($timing->612158X7time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X7X30time') ?></th>
            <td><?= $this->Number->format($timing->612158X7X30time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10time') ?></th>
            <td><?= $this->Number->format($timing->612158X10time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X41time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X41time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X70time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X70time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X50time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X50time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X52time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X52time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X71time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X71time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X53time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X53time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X10X265time') ?></th>
            <td><?= $this->Number->format($timing->612158X10X265time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X8time') ?></th>
            <td><?= $this->Number->format($timing->612158X8time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X8X54time') ?></th>
            <td><?= $this->Number->format($timing->612158X8X54time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X8X55time') ?></th>
            <td><?= $this->Number->format($timing->612158X8X55time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X9time') ?></th>
            <td><?= $this->Number->format($timing->612158X9time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X9X72time') ?></th>
            <td><?= $this->Number->format($timing->612158X9X72time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X9X73time') ?></th>
            <td><?= $this->Number->format($timing->612158X9X73time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('612158X9X74time') ?></th>
            <td><?= $this->Number->format($timing->612158X9X74time) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Participants') ?></h4>
        <?php if (!empty($timing->participants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Timing Id') ?></th>
                <th scope="col"><?= __('Token') ?></th>
                <th scope="col"><?= __('Submitdate') ?></th>
                <th scope="col"><?= __('Lastpage') ?></th>
                <th scope="col"><?= __('Startlanguage') ?></th>
                <th scope="col"><?= __('Seed') ?></th>
                <th scope="col"><?= __('Startdate') ?></th>
                <th scope="col"><?= __('Datestamp') ?></th>
                <th scope="col"><?= __('612158X1X2') ?></th>
                <th scope="col"><?= __('612158X2X4') ?></th>
                <th scope="col"><?= __('612158X3X5') ?></th>
                <th scope="col"><?= __('612158X3X75') ?></th>
                <th scope="col"><?= __('612158X3X7') ?></th>
                <th scope="col"><?= __('612158X3X6') ?></th>
                <th scope="col"><?= __('612158X3X8') ?></th>
                <th scope="col"><?= __('612158X6X108SQ007') ?></th>
                <th scope="col"><?= __('612158X6X108SQ008') ?></th>
                <th scope="col"><?= __('612158X6X108SQ009') ?></th>
                <th scope="col"><?= __('612158X6X108SQ010') ?></th>
                <th scope="col"><?= __('612158X6X108SQ011') ?></th>
                <th scope="col"><?= __('612158X6X108SQ012') ?></th>
                <th scope="col"><?= __('612158X6X108SQ013') ?></th>
                <th scope="col"><?= __('612158X6X108SQ014') ?></th>
                <th scope="col"><?= __('612158X6X108SQ015') ?></th>
                <th scope="col"><?= __('612158X6X108SQ016') ?></th>
                <th scope="col"><?= __('612158X6X108SQ017') ?></th>
                <th scope="col"><?= __('612158X6X108SQ018') ?></th>
                <th scope="col"><?= __('612158X6X108SQ019') ?></th>
                <th scope="col"><?= __('612158X6X108SQ020') ?></th>
                <th scope="col"><?= __('612158X6X108SQ021') ?></th>
                <th scope="col"><?= __('612158X6X108SQ022') ?></th>
                <th scope="col"><?= __('612158X6X108SQ023') ?></th>
                <th scope="col"><?= __('612158X6X108SQ024') ?></th>
                <th scope="col"><?= __('612158X6X108SQ026') ?></th>
                <th scope="col"><?= __('612158X6X19') ?></th>
                <th scope="col"><?= __('612158X6X21') ?></th>
                <th scope="col"><?= __('612158X4X9') ?></th>
                <th scope="col"><?= __('612158X4X10') ?></th>
                <th scope="col"><?= __('612158X4X11') ?></th>
                <th scope="col"><?= __('612158X4X11other') ?></th>
                <th scope="col"><?= __('612158X4X12') ?></th>
                <th scope="col"><?= __('612158X4X12other') ?></th>
                <th scope="col"><?= __('612158X4X13') ?></th>
                <th scope="col"><?= __('612158X4X13other') ?></th>
                <th scope="col"><?= __('612158X4X14') ?></th>
                <th scope="col"><?= __('612158X18X15') ?></th>
                <th scope="col"><?= __('612158X5X262') ?></th>
                <th scope="col"><?= __('612158X5X16') ?></th>
                <th scope="col"><?= __('612158X5X93') ?></th>
                <th scope="col"><?= __('612158X5X94') ?></th>
                <th scope="col"><?= __('612158X5X95') ?></th>
                <th scope="col"><?= __('612158X5X17') ?></th>
                <th scope="col"><?= __('612158X5X18') ?></th>
                <th scope="col"><?= __('612158X16X263') ?></th>
                <th scope="col"><?= __('612158X16X23') ?></th>
                <th scope="col"><?= __('612158X16X96') ?></th>
                <th scope="col"><?= __('612158X16X97') ?></th>
                <th scope="col"><?= __('612158X16X98') ?></th>
                <th scope="col"><?= __('612158X16X99') ?></th>
                <th scope="col"><?= __('612158X16X100') ?></th>
                <th scope="col"><?= __('612158X16X24') ?></th>
                <th scope="col"><?= __('612158X16X25') ?></th>
                <th scope="col"><?= __('612158X17X264') ?></th>
                <th scope="col"><?= __('612158X17X26') ?></th>
                <th scope="col"><?= __('612158X17X101') ?></th>
                <th scope="col"><?= __('612158X17X102') ?></th>
                <th scope="col"><?= __('612158X17X103') ?></th>
                <th scope="col"><?= __('612158X17X104') ?></th>
                <th scope="col"><?= __('612158X17X105') ?></th>
                <th scope="col"><?= __('612158X17X106') ?></th>
                <th scope="col"><?= __('612158X17X107') ?></th>
                <th scope="col"><?= __('612158X17X27') ?></th>
                <th scope="col"><?= __('612158X17X28') ?></th>
                <th scope="col"><?= __('612158X7X30SQ001') ?></th>
                <th scope="col"><?= __('612158X7X30SQ002') ?></th>
                <th scope="col"><?= __('612158X7X30SQ003') ?></th>
                <th scope="col"><?= __('612158X7X30SQ004') ?></th>
                <th scope="col"><?= __('612158X7X30SQ005') ?></th>
                <th scope="col"><?= __('612158X7X30SQ006') ?></th>
                <th scope="col"><?= __('612158X7X30SQ007') ?></th>
                <th scope="col"><?= __('612158X7X30SQ008') ?></th>
                <th scope="col"><?= __('612158X7X30SQ009') ?></th>
                <th scope="col"><?= __('612158X7X30SQ010') ?></th>
                <th scope="col"><?= __('612158X10X41SQ002') ?></th>
                <th scope="col"><?= __('612158X10X41SQ003') ?></th>
                <th scope="col"><?= __('612158X10X41SQ004') ?></th>
                <th scope="col"><?= __('612158X10X41SQ005') ?></th>
                <th scope="col"><?= __('612158X10X41SQ006') ?></th>
                <th scope="col"><?= __('612158X10X41SQ007') ?></th>
                <th scope="col"><?= __('612158X10X70') ?></th>
                <th scope="col"><?= __('612158X10X50') ?></th>
                <th scope="col"><?= __('612158X10X52') ?></th>
                <th scope="col"><?= __('612158X10X71') ?></th>
                <th scope="col"><?= __('612158X10X53') ?></th>
                <th scope="col"><?= __('612158X10X265') ?></th>
                <th scope="col"><?= __('612158X8X54') ?></th>
                <th scope="col"><?= __('612158X8X55') ?></th>
                <th scope="col"><?= __('612158X9X72') ?></th>
                <th scope="col"><?= __('612158X9X72other') ?></th>
                <th scope="col"><?= __('612158X9X73') ?></th>
                <th scope="col"><?= __('612158X9X74') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($timing->participants as $participants): ?>
            <tr>
                <td><?= h($participants->id) ?></td>
                <td><?= h($participants->timing_id) ?></td>
                <td><?= h($participants->token) ?></td>
                <td><?= h($participants->submitdate) ?></td>
                <td><?= h($participants->lastpage) ?></td>
                <td><?= h($participants->startlanguage) ?></td>
                <td><?= h($participants->seed) ?></td>
                <td><?= h($participants->startdate) ?></td>
                <td><?= h($participants->datestamp) ?></td>
                <td><?= h($participants->612158X1X2) ?></td>
                <td><?= h($participants->612158X2X4) ?></td>
                <td><?= h($participants->612158X3X5) ?></td>
                <td><?= h($participants->612158X3X75) ?></td>
                <td><?= h($participants->612158X3X7) ?></td>
                <td><?= h($participants->612158X3X6) ?></td>
                <td><?= h($participants->612158X3X8) ?></td>
                <td><?= h($participants->612158X6X108SQ007) ?></td>
                <td><?= h($participants->612158X6X108SQ008) ?></td>
                <td><?= h($participants->612158X6X108SQ009) ?></td>
                <td><?= h($participants->612158X6X108SQ010) ?></td>
                <td><?= h($participants->612158X6X108SQ011) ?></td>
                <td><?= h($participants->612158X6X108SQ012) ?></td>
                <td><?= h($participants->612158X6X108SQ013) ?></td>
                <td><?= h($participants->612158X6X108SQ014) ?></td>
                <td><?= h($participants->612158X6X108SQ015) ?></td>
                <td><?= h($participants->612158X6X108SQ016) ?></td>
                <td><?= h($participants->612158X6X108SQ017) ?></td>
                <td><?= h($participants->612158X6X108SQ018) ?></td>
                <td><?= h($participants->612158X6X108SQ019) ?></td>
                <td><?= h($participants->612158X6X108SQ020) ?></td>
                <td><?= h($participants->612158X6X108SQ021) ?></td>
                <td><?= h($participants->612158X6X108SQ022) ?></td>
                <td><?= h($participants->612158X6X108SQ023) ?></td>
                <td><?= h($participants->612158X6X108SQ024) ?></td>
                <td><?= h($participants->612158X6X108SQ026) ?></td>
                <td><?= h($participants->612158X6X19) ?></td>
                <td><?= h($participants->612158X6X21) ?></td>
                <td><?= h($participants->612158X4X9) ?></td>
                <td><?= h($participants->612158X4X10) ?></td>
                <td><?= h($participants->612158X4X11) ?></td>
                <td><?= h($participants->612158X4X11other) ?></td>
                <td><?= h($participants->612158X4X12) ?></td>
                <td><?= h($participants->612158X4X12other) ?></td>
                <td><?= h($participants->612158X4X13) ?></td>
                <td><?= h($participants->612158X4X13other) ?></td>
                <td><?= h($participants->612158X4X14) ?></td>
                <td><?= h($participants->612158X18X15) ?></td>
                <td><?= h($participants->612158X5X262) ?></td>
                <td><?= h($participants->612158X5X16) ?></td>
                <td><?= h($participants->612158X5X93) ?></td>
                <td><?= h($participants->612158X5X94) ?></td>
                <td><?= h($participants->612158X5X95) ?></td>
                <td><?= h($participants->612158X5X17) ?></td>
                <td><?= h($participants->612158X5X18) ?></td>
                <td><?= h($participants->612158X16X263) ?></td>
                <td><?= h($participants->612158X16X23) ?></td>
                <td><?= h($participants->612158X16X96) ?></td>
                <td><?= h($participants->612158X16X97) ?></td>
                <td><?= h($participants->612158X16X98) ?></td>
                <td><?= h($participants->612158X16X99) ?></td>
                <td><?= h($participants->612158X16X100) ?></td>
                <td><?= h($participants->612158X16X24) ?></td>
                <td><?= h($participants->612158X16X25) ?></td>
                <td><?= h($participants->612158X17X264) ?></td>
                <td><?= h($participants->612158X17X26) ?></td>
                <td><?= h($participants->612158X17X101) ?></td>
                <td><?= h($participants->612158X17X102) ?></td>
                <td><?= h($participants->612158X17X103) ?></td>
                <td><?= h($participants->612158X17X104) ?></td>
                <td><?= h($participants->612158X17X105) ?></td>
                <td><?= h($participants->612158X17X106) ?></td>
                <td><?= h($participants->612158X17X107) ?></td>
                <td><?= h($participants->612158X17X27) ?></td>
                <td><?= h($participants->612158X17X28) ?></td>
                <td><?= h($participants->612158X7X30SQ001) ?></td>
                <td><?= h($participants->612158X7X30SQ002) ?></td>
                <td><?= h($participants->612158X7X30SQ003) ?></td>
                <td><?= h($participants->612158X7X30SQ004) ?></td>
                <td><?= h($participants->612158X7X30SQ005) ?></td>
                <td><?= h($participants->612158X7X30SQ006) ?></td>
                <td><?= h($participants->612158X7X30SQ007) ?></td>
                <td><?= h($participants->612158X7X30SQ008) ?></td>
                <td><?= h($participants->612158X7X30SQ009) ?></td>
                <td><?= h($participants->612158X7X30SQ010) ?></td>
                <td><?= h($participants->612158X10X41SQ002) ?></td>
                <td><?= h($participants->612158X10X41SQ003) ?></td>
                <td><?= h($participants->612158X10X41SQ004) ?></td>
                <td><?= h($participants->612158X10X41SQ005) ?></td>
                <td><?= h($participants->612158X10X41SQ006) ?></td>
                <td><?= h($participants->612158X10X41SQ007) ?></td>
                <td><?= h($participants->612158X10X70) ?></td>
                <td><?= h($participants->612158X10X50) ?></td>
                <td><?= h($participants->612158X10X52) ?></td>
                <td><?= h($participants->612158X10X71) ?></td>
                <td><?= h($participants->612158X10X53) ?></td>
                <td><?= h($participants->612158X10X265) ?></td>
                <td><?= h($participants->612158X8X54) ?></td>
                <td><?= h($participants->612158X8X55) ?></td>
                <td><?= h($participants->612158X9X72) ?></td>
                <td><?= h($participants->612158X9X72other) ?></td>
                <td><?= h($participants->612158X9X73) ?></td>
                <td><?= h($participants->612158X9X74) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Participants', 'action' => 'view', $participants->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Participants', 'action' => 'edit', $participants->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Participants', 'action' => 'delete', $participants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participants->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
