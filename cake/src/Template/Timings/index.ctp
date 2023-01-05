<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Timing[]|\Cake\Collection\CollectionInterface $timings
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Timing'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['controller' => 'Participants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Participant'), ['controller' => 'Participants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="timings index large-9 medium-8 columns content">
    <h3><?= __('Timings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('interviewtime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X1time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X1X2time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X2time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X2X4time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X5time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X75time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X7time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X6time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X3X8time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X108time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X19time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X6X21time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X9time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X10time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X11time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X12time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X13time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X4X14time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X18time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X18X15time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X262time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X16time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X93time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X94time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X95time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X17time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X5X18time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X263time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X23time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X96time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X97time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X98time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X99time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X100time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X24time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X16X25time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X264time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X26time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X101time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X102time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X103time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X104time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X105time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X106time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X107time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X27time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X17X28time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X7X30time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X41time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X70time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X50time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X52time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X71time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X53time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X10X265time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X8time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X8X54time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X8X55time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X9time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X9X72time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X9X73time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('612158X9X74time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($timings as $timing): ?>
            <tr>
                <td><?= $this->Number->format($timing->id) ?></td>
                <td><?= $this->Number->format($timing->interviewtime) ?></td>
                <td><?= $this->Number->format($timing->612158X1time) ?></td>
                <td><?= $this->Number->format($timing->612158X1X2time) ?></td>
                <td><?= $this->Number->format($timing->612158X2time) ?></td>
                <td><?= $this->Number->format($timing->612158X2X4time) ?></td>
                <td><?= $this->Number->format($timing->612158X3time) ?></td>
                <td><?= $this->Number->format($timing->612158X3X5time) ?></td>
                <td><?= $this->Number->format($timing->612158X3X75time) ?></td>
                <td><?= $this->Number->format($timing->612158X3X7time) ?></td>
                <td><?= $this->Number->format($timing->612158X3X6time) ?></td>
                <td><?= $this->Number->format($timing->612158X3X8time) ?></td>
                <td><?= $this->Number->format($timing->612158X6time) ?></td>
                <td><?= $this->Number->format($timing->612158X6X108time) ?></td>
                <td><?= $this->Number->format($timing->612158X6X19time) ?></td>
                <td><?= $this->Number->format($timing->612158X6X21time) ?></td>
                <td><?= $this->Number->format($timing->612158X4time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X9time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X10time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X11time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X12time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X13time) ?></td>
                <td><?= $this->Number->format($timing->612158X4X14time) ?></td>
                <td><?= $this->Number->format($timing->612158X18time) ?></td>
                <td><?= $this->Number->format($timing->612158X18X15time) ?></td>
                <td><?= $this->Number->format($timing->612158X5time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X262time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X16time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X93time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X94time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X95time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X17time) ?></td>
                <td><?= $this->Number->format($timing->612158X5X18time) ?></td>
                <td><?= $this->Number->format($timing->612158X16time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X263time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X23time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X96time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X97time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X98time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X99time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X100time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X24time) ?></td>
                <td><?= $this->Number->format($timing->612158X16X25time) ?></td>
                <td><?= $this->Number->format($timing->612158X17time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X264time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X26time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X101time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X102time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X103time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X104time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X105time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X106time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X107time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X27time) ?></td>
                <td><?= $this->Number->format($timing->612158X17X28time) ?></td>
                <td><?= $this->Number->format($timing->612158X7time) ?></td>
                <td><?= $this->Number->format($timing->612158X7X30time) ?></td>
                <td><?= $this->Number->format($timing->612158X10time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X41time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X70time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X50time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X52time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X71time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X53time) ?></td>
                <td><?= $this->Number->format($timing->612158X10X265time) ?></td>
                <td><?= $this->Number->format($timing->612158X8time) ?></td>
                <td><?= $this->Number->format($timing->612158X8X54time) ?></td>
                <td><?= $this->Number->format($timing->612158X8X55time) ?></td>
                <td><?= $this->Number->format($timing->612158X9time) ?></td>
                <td><?= $this->Number->format($timing->612158X9X72time) ?></td>
                <td><?= $this->Number->format($timing->612158X9X73time) ?></td>
                <td><?= $this->Number->format($timing->612158X9X74time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $timing->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $timing->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $timing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timing->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
