<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ordinal Attribute'), ['action' => 'edit', $ordinalAttribute->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ordinal Attribute'), ['action' => 'delete', $ordinalAttribute->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttribute->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Components'), ['controller' => 'OrdinalComponents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Component'), ['controller' => 'OrdinalComponents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ypois'), ['controller' => 'Ypois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ypois'), ['controller' => 'Ypois', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ordinalAttributes view large-9 medium-8 columns content">
    <h3><?= h($ordinalAttribute->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Ordinal Component') ?></th>
            <td><?= $ordinalAttribute->has('ordinal_component') ? $this->Html->link($ordinalAttribute->ordinal_component->name, ['controller' => 'OrdinalComponents', 'action' => 'view', $ordinalAttribute->ordinal_component->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($ordinalAttribute->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Name') ?></th>
            <td><?= h($ordinalAttribute->display_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ordinalAttribute->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Meter') ?></th>
            <td><?= $this->Number->format($ordinalAttribute->meter) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($ordinalAttribute->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($ordinalAttribute->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ypois') ?></h4>
        <?php if (!empty($ordinalAttribute->ypois)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Lat') ?></th>
                <th scope="col"><?= __('Lng') ?></th>
                <th scope="col"><?= __('Google Place') ?></th>
                <th scope="col"><?= __('Businessid') ?></th>
                <th scope="col"><?= __('Icon') ?></th>
                <th scope="col"><?= __('Rating') ?></th>
                <th scope="col"><?= __('Vicinity') ?></th>
                <th scope="col"><?= __('City') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Full Address') ?></th>
                <th scope="col"><?= __('Formatted Phone Number') ?></th>
                <th scope="col"><?= __('Mail') ?></th>
                <th scope="col"><?= __('Website') ?></th>
                <th scope="col"><?= __('Social') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('User Ratings Total') ?></th>
                <th scope="col"><?= __('Stars') ?></th>
                <th scope="col"><?= __('Opening Hours') ?></th>
                <th scope="col"><?= __('Weekday Text') ?></th>
                <th scope="col"><?= __('Photos') ?></th>
                <th scope="col"><?= __('Reviews') ?></th>
                <th scope="col"><?= __('Review Count') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ordinalAttribute->ypois as $ypois): ?>
            <tr>
                <td><?= h($ypois->id) ?></td>
                <td><?= h($ypois->created) ?></td>
                <td><?= h($ypois->modified) ?></td>
                <td><?= h($ypois->name) ?></td>
                <td><?= h($ypois->lat) ?></td>
                <td><?= h($ypois->lng) ?></td>
                <td><?= h($ypois->google_place) ?></td>
                <td><?= h($ypois->businessid) ?></td>
                <td><?= h($ypois->icon) ?></td>
                <td><?= h($ypois->rating) ?></td>
                <td><?= h($ypois->vicinity) ?></td>
                <td><?= h($ypois->city) ?></td>
                <td><?= h($ypois->state) ?></td>
                <td><?= h($ypois->full_address) ?></td>
                <td><?= h($ypois->formatted_phone_number) ?></td>
                <td><?= h($ypois->mail) ?></td>
                <td><?= h($ypois->website) ?></td>
                <td><?= h($ypois->social) ?></td>
                <td><?= h($ypois->description) ?></td>
                <td><?= h($ypois->user_ratings_total) ?></td>
                <td><?= h($ypois->stars) ?></td>
                <td><?= h($ypois->opening_hours) ?></td>
                <td><?= h($ypois->weekday_text) ?></td>
                <td><?= h($ypois->photos) ?></td>
                <td><?= h($ypois->reviews) ?></td>
                <td><?= h($ypois->review_count) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ypois', 'action' => 'view', $ypois->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ypois', 'action' => 'edit', $ypois->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ypois', 'action' => 'delete', $ypois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ypois->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
