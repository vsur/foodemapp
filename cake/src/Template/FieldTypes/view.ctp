<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FieldType $fieldType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Field Type'), ['action' => 'edit', $fieldType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Field Type'), ['action' => 'delete', $fieldType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fieldType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Field Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Field Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fieldTypes view large-9 medium-8 columns content">
    <h3><?= h($fieldType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($fieldType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fieldType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($fieldType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($fieldType->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($fieldType->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Codes') ?></h4>
        <?php if (!empty($fieldType->codes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Field Type Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($fieldType->codes as $codes): ?>
            <tr>
                <td><?= h($codes->id) ?></td>
                <td><?= h($codes->field_type_id) ?></td>
                <td><?= h($codes->name) ?></td>
                <td><?= h($codes->description) ?></td>
                <td><?= h($codes->created) ?></td>
                <td><?= h($codes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Codes', 'action' => 'view', $codes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Codes', 'action' => 'edit', $codes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Codes', 'action' => 'delete', $codes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $codes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
