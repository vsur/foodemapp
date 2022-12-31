<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant[]|\Cake\Collection\CollectionInterface $participants
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participants index large-9 medium-8 columns content">
    <h3><?= __('Participants') ?></h3>
    <div style="overflow-x:auto;">
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('token') ?></th>
                <th scope="col"><?= $this->Paginator->sort('submitdate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastpage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('startlanguage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('startdate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('datestamp') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X1X2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X2X4') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X5') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X75') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X7') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X8') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ007') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ008') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ009') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ010') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ011') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ012') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ013') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ014') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ015') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ016') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ017') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ018') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ019') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ020') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ021') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ022') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ023') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ024') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108SQ026') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X19') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X21') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X9') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X10') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X11') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X12') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X13') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X14') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X18X15') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X23') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X24') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X25') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X16') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X17') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X18') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X26') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X27') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X28') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ001') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ002') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ003') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ004') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ005') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ006') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ007') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ008') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ009') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30SQ010') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ002') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ003') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ004') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ005') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ006') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41SQ007') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X70') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X8X55') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X9X74') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?= $this->Number->format($participant['id']) ?></td>
                <td><?= h($participant['token']) ?></td>
                <td><?= h($participant['submitdate']) ?></td>
                <td><?= $this->Number->format($participant['lastpage']) ?></td>
                <td><?= h($participant['startlanguage']) ?></td>
                <td><?= h($participant['seed']) ?></td>
                <td><?= h($participant['startdate']) ?></td>
                <td><?= h($participant['datestamp']) ?></td>
                <td><?= h($participant['612158X1X2']) ?></td>
                <td><?= h($participant['612158X2X4']) ?></td>
                <td><?= $this->Number->format($participant['612158X3X5']) ?></td>
                <td><?= h($participant['612158X3X75']) ?></td>
                <td><?= h($participant['612158X3X7']) ?></td>
                <td><?= h($participant['612158X3X8']) ?></td>
                <td><?= h($participant['612158X6X108SQ007']) ?></td>
                <td><?= h($participant['612158X6X108SQ008']) ?></td>
                <td><?= h($participant['612158X6X108SQ009']) ?></td>
                <td><?= h($participant['612158X6X108SQ010']) ?></td>
                <td><?= h($participant['612158X6X108SQ011']) ?></td>
                <td><?= h($participant['612158X6X108SQ012']) ?></td>
                <td><?= h($participant['612158X6X108SQ013']) ?></td>
                <td><?= h($participant['612158X6X108SQ014']) ?></td>
                <td><?= h($participant['612158X6X108SQ015']) ?></td>
                <td><?= h($participant['612158X6X108SQ016']) ?></td>
                <td><?= h($participant['612158X6X108SQ017']) ?></td>
                <td><?= h($participant['612158X6X108SQ018']) ?></td>
                <td><?= h($participant['612158X6X108SQ019']) ?></td>
                <td><?= h($participant['612158X6X108SQ020']) ?></td>
                <td><?= h($participant['612158X6X108SQ021']) ?></td>
                <td><?= h($participant['612158X6X108SQ022']) ?></td>
                <td><?= h($participant['612158X6X108SQ023']) ?></td>
                <td><?= h($participant['612158X6X108SQ024']) ?></td>
                <td><?= h($participant['612158X6X108SQ026']) ?></td>
                <td><?= h($participant['612158X6X19']) ?></td>
                <td><?= h($participant['612158X6X21']) ?></td>
                <td><?= h($participant['612158X4X9']) ?></td>
                <td><?= h($participant['612158X4X10']) ?></td>
                <td><?= h($participant['612158X4X11']) ?></td>
                <td><?= h($participant['612158X4X12']) ?></td>
                <td><?= h($participant['612158X4X13']) ?></td>
                <td><?= h($participant['612158X4X14']) ?></td>
                <td><?= h($participant['612158X18X15']) ?></td>
                <td><?= h($participant['612158X16X23']) ?></td>
                <td><?= h($participant['612158X16X24']) ?></td>
                <td><?= h($participant['612158X16X25']) ?></td>
                <td><?= h($participant['612158X5X16']) ?></td>
                <td><?= h($participant['612158X5X17']) ?></td>
                <td><?= h($participant['612158X5X18']) ?></td>
                <td><?= h($participant['612158X17X26']) ?></td>
                <td><?= h($participant['612158X17X27']) ?></td>
                <td><?= h($participant['612158X17X28']) ?></td>
                <td><?= h($participant['612158X7X30SQ001']) ?></td>
                <td><?= h($participant['612158X7X30SQ002']) ?></td>
                <td><?= h($participant['612158X7X30SQ003']) ?></td>
                <td><?= h($participant['612158X7X30SQ004']) ?></td>
                <td><?= h($participant['612158X7X30SQ005']) ?></td>
                <td><?= h($participant['612158X7X30SQ006']) ?></td>
                <td><?= h($participant['612158X7X30SQ007']) ?></td>
                <td><?= h($participant['612158X7X30SQ008']) ?></td>
                <td><?= h($participant['612158X7X30SQ009']) ?></td>
                <td><?= h($participant['612158X7X30SQ010']) ?></td>
                <td><?= h($participant['612158X10X41SQ002']) ?></td>
                <td><?= h($participant['612158X10X41SQ003']) ?></td>
                <td><?= h($participant['612158X10X41SQ004']) ?></td>
                <td><?= h($participant['612158X10X41SQ005']) ?></td>
                <td><?= h($participant['612158X10X41SQ006']) ?></td>
                <td><?= h($participant['612158X10X41SQ007']) ?></td>
                <td><?= h($participant['612158X10X70']) ?></td>
                <td><?= h($participant['612158X8X55']) ?></td>
                <td><?= h($participant['612158X9X74']) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participant->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participant->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
