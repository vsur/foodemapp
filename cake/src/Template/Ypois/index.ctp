<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ypois'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ypois index large-9 medium-8 columns content">
    <h3><?= __('Ypois') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lng') ?></th>
                <th scope="col"><?= $this->Paginator->sort('google_place') ?></th>
                <th scope="col"><?= $this->Paginator->sort('businessid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('icon') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rating') ?></th>
                <th scope="col"><?= $this->Paginator->sort('vicinity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('full_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('formatted_phone_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('website') ?></th>
                <th scope="col"><?= $this->Paginator->sort('social') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_ratings_total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stars') ?></th>
                <th scope="col"><?= $this->Paginator->sort('opening_hours') ?></th>
                <th scope="col"><?= $this->Paginator->sort('weekday_text') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reviews') ?></th>
                <th scope="col"><?= $this->Paginator->sort('review_count') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ypois as $ypois): ?>
            <tr>
                <td><?= $this->Number->format($ypois->id) ?></td>
                <td><?= h($ypois->created) ?></td>
                <td><?= h($ypois->modified) ?></td>
                <td><?= h($ypois->name) ?></td>
                <td><?= $this->Number->format($ypois->lat) ?></td>
                <td><?= $this->Number->format($ypois->lng) ?></td>
                <td><?= h($ypois->google_place) ?></td>
                <td><?= h($ypois->businessid) ?></td>
                <td><?= h($ypois->icon) ?></td>
                <td><?= $this->Number->format($ypois->rating) ?></td>
                <td><?= h($ypois->vicinity) ?></td>
                <td><?= $this->Number->format($ypois->city) ?></td>
                <td><?= h($ypois->state) ?></td>
                <td><?= h($ypois->full_address) ?></td>
                <td><?= h($ypois->formatted_phone_number) ?></td>
                <td><?= h($ypois->mail) ?></td>
                <td><?= h($ypois->website) ?></td>
                <td><?= h($ypois->social) ?></td>
                <td><?= $this->Number->format($ypois->user_ratings_total) ?></td>
                <td><?= $this->Number->format($ypois->stars) ?></td>
                <td><?= h($ypois->opening_hours) ?></td>
                <td><?= h($ypois->weekday_text) ?></td>
                <td><?= $this->Number->format($ypois->photos) ?></td>
                <td><?= $this->Number->format($ypois->reviews) ?></td>
                <td><?= $this->Number->format($ypois->review_count) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ypois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ypois->id]) ?>

                    <?php
                        /* No Detle Method for Production
                        $this->Form->postLink(__('Delete'), ['action' => 'delete', $ypois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ypois->id)]) */
                    ?>
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
