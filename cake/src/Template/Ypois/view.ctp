<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ypois'), ['action' => 'edit', $ypois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ypois'), ['action' => 'delete', $ypois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ypois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ypois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ypois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Binary Components'), ['controller' => 'BinaryComponents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Binary Component'), ['controller' => 'BinaryComponents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Nominal Attributes'), ['controller' => 'NominalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nominal Attribute'), ['controller' => 'NominalAttributes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ordinal Attributes'), ['controller' => 'OrdinalAttributes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ordinal Attribute'), ['controller' => 'OrdinalAttributes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ypois view large-9 medium-8 columns content">
    <h3><?= h($ypois->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($ypois->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Google Place') ?></th>
            <td><?= h($ypois->google_place) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Businessid') ?></th>
            <td><?= h($ypois->businessid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($ypois->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vicinity') ?></th>
            <td><?= h($ypois->vicinity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= h($ypois->state) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Full Address') ?></th>
            <td><?= h($ypois->full_address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Formatted Phone Number') ?></th>
            <td><?= h($ypois->formatted_phone_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mail') ?></th>
            <td><?= h($ypois->mail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Website') ?></th>
            <td><?= h($ypois->website) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Social') ?></th>
            <td><?= h($ypois->social) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Opening Hours') ?></th>
            <td><?= h($ypois->opening_hours) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Weekday Text') ?></th>
            <td><?= h($ypois->weekday_text) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ypois->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lat') ?></th>
            <td><?= $this->Number->format($ypois->lat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lng') ?></th>
            <td><?= $this->Number->format($ypois->lng) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td><?= $this->Number->format($ypois->rating) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $this->Number->format($ypois->city) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Ratings Total') ?></th>
            <td><?= $this->Number->format($ypois->user_ratings_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stars') ?></th>
            <td><?= $this->Number->format($ypois->stars) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photos') ?></th>
            <td><?= $this->Number->format($ypois->photos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reviews') ?></th>
            <td><?= $this->Number->format($ypois->reviews) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Review Count') ?></th>
            <td><?= $this->Number->format($ypois->review_count) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($ypois->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($ypois->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($ypois->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Binary Components') ?></h4>
        <?php if (!empty($ypois->binary_components)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Display Name') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ypois->binary_components as $binaryComponents): ?>
            <tr>
                <td><?= h($binaryComponents->id) ?></td>
                <td><?= h($binaryComponents->name) ?></td>
                <td><?= h($binaryComponents->display_name) ?></td>
                <td><?= h($binaryComponents->created) ?></td>
                <td><?= h($binaryComponents->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BinaryComponents', 'action' => 'view', $binaryComponents->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BinaryComponents', 'action' => 'edit', $binaryComponents->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BinaryComponents', 'action' => 'delete', $binaryComponents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $binaryComponents->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Nominal Attributes') ?></h4>
        <?php if (!empty($ypois->nominal_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nominal Component Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Display Name') ?></th>
                <th scope="col"><?= __('Icon Path') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ypois->nominal_attributes as $nominalAttributes): ?>
            <tr>
                <td><?= h($nominalAttributes->id) ?></td>
                <td><?= h($nominalAttributes->nominal_component_id) ?></td>
                <td><?= h($nominalAttributes->name) ?></td>
                <td><?= h($nominalAttributes->display_name) ?></td>
                <td><?= h($nominalAttributes->icon_path) ?></td>
                <td><?= h($nominalAttributes->created) ?></td>
                <td><?= h($nominalAttributes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'NominalAttributes', 'action' => 'view', $nominalAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'NominalAttributes', 'action' => 'edit', $nominalAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'NominalAttributes', 'action' => 'delete', $nominalAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nominalAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ordinal Attributes') ?></h4>
        <?php if (!empty($ypois->ordinal_attributes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ordinal Component Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Display Name') ?></th>
                <th scope="col"><?= __('Meter') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ypois->ordinal_attributes as $ordinalAttributes): ?>
            <tr>
                <td><?= h($ordinalAttributes->id) ?></td>
                <td><?= h($ordinalAttributes->ordinal_component_id) ?></td>
                <td><?= h($ordinalAttributes->name) ?></td>
                <td><?= h($ordinalAttributes->display_name) ?></td>
                <td><?= h($ordinalAttributes->meter) ?></td>
                <td><?= h($ordinalAttributes->created) ?></td>
                <td><?= h($ordinalAttributes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrdinalAttributes', 'action' => 'view', $ordinalAttributes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrdinalAttributes', 'action' => 'edit', $ordinalAttributes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrdinalAttributes', 'action' => 'delete', $ordinalAttributes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordinalAttributes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
