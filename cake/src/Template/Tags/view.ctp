<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['controller' => 'Pois', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['controller' => 'Pois', 'action' => 'add']) ?> </li>
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
        <h4><?= __('Related Pois') ?></h4>
        <?php if (!empty($tag->pois)): ?>
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
            <?php foreach ($tag->pois as $pois): ?>
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
</div>
