<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Component'), ['action' => 'edit', $component->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Component'), ['action' => 'delete', $component->id], ['confirm' => __('Are you sure you want to delete # {0}?', $component->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stages'), ['controller' => 'Stages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stage'), ['controller' => 'Stages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
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
        <h4><?= __('Related Stages') ?></h4>
        <?php if (!empty($component->stages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Component Id') ?></th>
                <th><?= __('Location Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Rating') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($component->stages as $stages): ?>
            <tr>
                <td><?= h($stages->id) ?></td>
                <td><?= h($stages->component_id) ?></td>
                <td><?= h($stages->location_id) ?></td>
                <td><?= h($stages->created) ?></td>
                <td><?= h($stages->modified) ?></td>
                <td><?= h($stages->rating) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Stages', 'action' => 'view', $stages->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Stages', 'action' => 'edit', $stages->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Stages', 'action' => 'delete', $stages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stages->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Locations') ?></h4>
        <?php if (!empty($component->locations)): ?>
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
            <?php foreach ($component->locations as $locations): ?>
            <tr>
                <td><?= h($locations->id) ?></td>
                <td><?= h($locations->created) ?></td>
                <td><?= h($locations->modified) ?></td>
                <td><?= h($locations->name) ?></td>
                <td><?= h($locations->lat) ?></td>
                <td><?= h($locations->lng) ?></td>
                <td><?= h($locations->google_place) ?></td>
                <td><?= h($locations->icon) ?></td>
                <td><?= h($locations->rating) ?></td>
                <td><?= h($locations->vicinity) ?></td>
                <td><?= h($locations->formatted_phone_number) ?></td>
                <td><?= h($locations->mail) ?></td>
                <td><?= h($locations->website) ?></td>
                <td><?= h($locations->social) ?></td>
                <td><?= h($locations->description) ?></td>
                <td><?= h($locations->user_ratings_total) ?></td>
                <td><?= h($locations->opening_hours) ?></td>
                <td><?= h($locations->weekday_text) ?></td>
                <td><?= h($locations->photos) ?></td>
                <td><?= h($locations->reviews) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Locations', 'action' => 'view', $locations->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Locations', 'action' => 'edit', $locations->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Locations', 'action' => 'delete', $locations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locations->id)]) ?>

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
