<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Code $code
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Code'), ['action' => 'edit', $code->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Code'), ['action' => 'delete', $code->id], ['confirm' => __('Are you sure you want to delete # {0}?', $code->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Codes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Code'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Field Types'), ['controller' => 'FieldTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field Type'), ['controller' => 'FieldTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="codes view large-9 medium-8 columns content">
    <h3><?= h($code->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Field Type') ?></th>
            <td><?= $code->has('field_type') ? $this->Html->link($code->field_type->name, ['controller' => 'FieldTypes', 'action' => 'view', $code->field_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($code->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($code->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($code->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($code->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($code->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Participants') ?></h4>
        <?php if (!empty($code->participants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
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
            <?php foreach ($code->participants as $participants): ?>
            <tr>
                <td><?= h($participants->id) ?></td>
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
