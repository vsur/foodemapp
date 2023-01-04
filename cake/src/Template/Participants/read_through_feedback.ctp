<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participant'), ['action' => 'edit', $participant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participant'), ['action' => 'delete', $participant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participant'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participants view large-9 medium-8 columns content">
    <h3><?= h("Participant ID: " . $participant->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('ID') ?></th>
            <td><?= h($participant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zeitpunkt') ?></th>
            <td><?= h($this->Time->format($participant->startdate)) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dauer') ?></th>
            <td><?= h($participant->submitdate->diff($participant->startdate)->format('%H:%i:%s h')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Geschlecht') ?></th>
            <td>
                <?php
                    $sex = $participant['612158X3X75'];
                    switch ($sex) {
                        case 'F':
                            echo "♀";
                            break;
                        case 'M':
                            echo "♂";
                            break;
                        case '':
                            echo "X";
                            break;
                    }
                ?>
            </td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('612158X3X6') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X3X6'])); ?>
    </div>

<?php 
    $currentParticipantIdKey = array_search($participant->id, $idsWhoFinished);
    echo $currentParticipantIdKey-1;

?>

    <div class="paginator" style="text-align: left;">
        <ul class="pagination">
            <li>
                <?= $this->Html->link('‹‹ ', ['action' => 'readThroughFeedback', $idsWhoFinished[0]]) ?>
            </li>
            <li>
                <?= $this->Html->link('‹ ', ['action' => 'readThroughFeedback', ($currentParticipantIdKey-1 > 0 ? $idsWhoFinished[$currentParticipantIdKey-1] : $idsWhoFinished[0])]) ?>
            </li>
            <li>
                <?= $this->Html->link("Aktuelle ID: $participant->id ", ['action' => 'readThroughFeedback', $participant->id]) ?>
            </li>
            <li>
                <?= $this->Html->link('› ', ['action' => 'readThroughFeedback', ($currentParticipantIdKey+1 < array_key_last($idsWhoFinished) ? $idsWhoFinished[$currentParticipantIdKey+1] : $idsWhoFinished[array_key_last($idsWhoFinished)])]) ?>
            </li>
            <li>
            </li>
            <li>
                <?= $this->Html->link('›› ', ['action' => 'readThroughFeedback', $idsWhoFinished[array_key_last($idsWhoFinished)]]) ?>
            </li>
        </ul>
        <p style="text-align: left;"><?= __("Participant " . (intval($currentParticipantIdKey)+1 ) . " von " . count($idsWhoFinished)) ?></p>
    </div>

    <div class="related">
        <h4><?= __('Related Codes') ?></h4>
        <?php if (!empty($participant->codes)): ?>
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
            <?php foreach ($participant->codes as $codes): ?>
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
