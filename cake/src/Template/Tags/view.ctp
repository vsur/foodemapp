<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tags view large-9 medium-8 columns content">
    <h3><?= h($tag->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($tag->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($tag->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($tag->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($tag->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Locations') ?></h4>
        <?php if (!empty($tag->locations)): ?>
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
            <?php foreach ($tag->locations as $locations): ?>
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
</div>
