<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Component'), ['action' => 'edit', $component->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Component'), ['action' => 'delete', $component->id], ['confirm' => __('Are you sure you want to delete # {0}?', $component->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Scenarios'), ['controller' => 'Scenarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Scenario'), ['controller' => 'Scenarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="components view large-9 medium-8 columns content">
    <h3><?= h($component->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($component->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($component->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($component->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($component->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Pois') ?></h4>
        <?php if (!empty($component->pois)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Lat') ?></th>
                <th><?= __('Lng') ?></th>
                <th><?= __('Google Place') ?></th>
                <th><?= __('Icon') ?></th>
                <th><?= __('Rating') ?></th>
                <th><?= __('Vicinity') ?></th>
                <th><?= __('Formatted Phone Number') ?></th>
                <th><?= __('Mail') ?></th>
                <th><?= __('Website') ?></th>
                <th><?= __('Social') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('User Ratings Total') ?></th>
                <th><?= __('Opening Hours') ?></th>
                <th><?= __('Weekday Text') ?></th>
                <th><?= __('Photos') ?></th>
                <th><?= __('Reviews') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($component->pois as $pois): ?>
            <tr>
                <td><?= h($pois->id) ?></td>
                <td><?= h($pois->created) ?></td>
                <td><?= h($pois->modified) ?></td>
                <td><?= h($pois->name) ?></td>
                <td><?= h($pois->lat) ?></td>
                <td><?= h($pois->lng) ?></td>
                <td><?= h($pois->google_place) ?></td>
                <td><?= h($pois->icon) ?></td>
                <td><?= h($pois->rating) ?></td>
                <td><?= h($pois->vicinity) ?></td>
                <td><?= h($pois->formatted_phone_number) ?></td>
                <td><?= h($pois->mail) ?></td>
                <td><?= h($pois->website) ?></td>
                <td><?= h($pois->social) ?></td>
                <td><?= h($pois->description) ?></td>
                <td><?= h($pois->user_ratings_total) ?></td>
                <td><?= h($pois->opening_hours) ?></td>
                <td><?= h($pois->weekday_text) ?></td>
                <td><?= h($pois->photos) ?></td>
                <td><?= h($pois->reviews) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Pois', 'action' => 'view', $pois->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Pois', 'action' => 'edit', $pois->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pois', 'action' => 'delete', $pois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pois->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Scenarios') ?></h4>
        <?php if (!empty($component->scenarios)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Thumbnail') ?></th>
                <th><?= __('Counter') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($component->scenarios as $scenarios): ?>
            <tr>
                <td><?= h($scenarios->id) ?></td>
                <td><?= h($scenarios->created) ?></td>
                <td><?= h($scenarios->modified) ?></td>
                <td><?= h($scenarios->name) ?></td>
                <td><?= h($scenarios->description) ?></td>
                <td><?= h($scenarios->thumbnail) ?></td>
                <td><?= h($scenarios->counter) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Scenarios', 'action' => 'view', $scenarios->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Scenarios', 'action' => 'edit', $scenarios->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Scenarios', 'action' => 'delete', $scenarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $scenarios->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
