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
                
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($code->participants as $participants): ?>
            <tr>
                <td><?= h($participants->id) ?></td>
                
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
