<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stages'), ['controller' => 'Stages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stage'), ['controller' => 'Stages', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Components'), ['controller' => 'Components', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Component'), ['controller' => 'Components', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="locations view large-9 medium-8 columns content">
    <h3><?= h($location->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($location->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Google Place') ?></th>
            <td><?= h($location->google_place) ?></td>
        </tr>
        <tr>
            <th><?= __('Icon') ?></th>
            <td><?= h($location->icon) ?></td>
        </tr>
        <tr>
            <th><?= __('Vicinity') ?></th>
            <td><?= h($location->vicinity) ?></td>
        </tr>
        <tr>
            <th><?= __('Formatted Phone Number') ?></th>
            <td><?= h($location->formatted_phone_number) ?></td>
        </tr>
        <tr>
            <th><?= __('Mail') ?></th>
            <td><?= h($location->mail) ?></td>
        </tr>
        <tr>
            <th><?= __('Website') ?></th>
            <td><?= h($location->website) ?></td>
        </tr>
        <tr>
            <th><?= __('Social') ?></th>
            <td><?= h($location->social) ?></td>
        </tr>
        <tr>
            <th><?= __('Opening Hours') ?></th>
            <td><?= h($location->opening_hours) ?></td>
        </tr>
        <tr>
            <th><?= __('Weekday Text') ?></th>
            <td><?= h($location->weekday_text) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($location->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= $this->Number->format($location->lat) ?></td>
        </tr>
        <tr>
            <th><?= __('Lng') ?></th>
            <td><?= $this->Number->format($location->lng) ?></td>
        </tr>
        <tr>
            <th><?= __('Rating') ?></th>
            <td><?= $this->Number->format($location->rating) ?></td>
        </tr>
        <tr>
            <th><?= __('User Ratings Total') ?></th>
            <td><?= $this->Number->format($location->user_ratings_total) ?></td>
        </tr>
        <tr>
            <th><?= __('Photos') ?></th>
            <td><?= $this->Number->format($location->photos) ?></td>
        </tr>
        <tr>
            <th><?= __('Reviews') ?></th>
            <td><?= $this->Number->format($location->reviews) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($location->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($location->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($location->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Stages') ?></h4>
        <?php if (!empty($location->stages)): ?>
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
            <?php foreach ($location->stages as $stages): ?>
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
        <h4><?= __('Related Components') ?></h4>
        <?php if (!empty($location->components)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->components as $components): ?>
            <tr>
                <td><?= h($components->id) ?></td>
                <td><?= h($components->created) ?></td>
                <td><?= h($components->modified) ?></td>
                <td><?= h($components->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Components', 'action' => 'view', $components->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Components', 'action' => 'edit', $components->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Components', 'action' => 'delete', $components->id], ['confirm' => __('Are you sure you want to delete # {0}?', $components->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <?php if (!empty($location->tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($location->tags as $tags): ?>
            <tr>
                <td><?= h($tags->id) ?></td>
                <td><?= h($tags->title) ?></td>
                <td><?= h($tags->created) ?></td>
                <td><?= h($tags->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
