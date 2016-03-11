<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pois'), ['action' => 'edit', $pois->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pois'), ['action' => 'delete', $pois->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pois->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pois'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pois'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pois view large-9 medium-8 columns content">
    <h3><?= h($pois->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($pois->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Google Place') ?></th>
            <td><?= h($pois->google_place) ?></td>
        </tr>
        <tr>
            <th><?= __('Icon') ?></th>
            <td><?= h($pois->icon) ?></td>
        </tr>
        <tr>
            <th><?= __('Vicinity') ?></th>
            <td><?= h($pois->vicinity) ?></td>
        </tr>
        <tr>
            <th><?= __('Formatted Phone Number') ?></th>
            <td><?= h($pois->formatted_phone_number) ?></td>
        </tr>
        <tr>
            <th><?= __('Mail') ?></th>
            <td><?= h($pois->mail) ?></td>
        </tr>
        <tr>
            <th><?= __('Website') ?></th>
            <td><?= h($pois->website) ?></td>
        </tr>
        <tr>
            <th><?= __('Social') ?></th>
            <td><?= h($pois->social) ?></td>
        </tr>
        <tr>
            <th><?= __('Opening Hours') ?></th>
            <td><?= h($pois->opening_hours) ?></td>
        </tr>
        <tr>
            <th><?= __('Weekday Text') ?></th>
            <td><?= h($pois->weekday_text) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($pois->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= $this->Number->format($pois->lat) ?></td>
        </tr>
        <tr>
            <th><?= __('Lng') ?></th>
            <td><?= $this->Number->format($pois->lng) ?></td>
        </tr>
        <tr>
            <th><?= __('Rating') ?></th>
            <td><?= $this->Number->format($pois->rating) ?></td>
        </tr>
        <tr>
            <th><?= __('User Ratings Total') ?></th>
            <td><?= $this->Number->format($pois->user_ratings_total) ?></td>
        </tr>
        <tr>
            <th><?= __('Photos') ?></th>
            <td><?= $this->Number->format($pois->photos) ?></td>
        </tr>
        <tr>
            <th><?= __('Reviews') ?></th>
            <td><?= $this->Number->format($pois->reviews) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($pois->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($pois->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($pois->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <?php if (!empty($pois->tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($pois->tags as $tags): ?>
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
