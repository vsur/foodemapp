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
    <p>
        <strong style="color: #1798A5">ID</strong> <?= h($participant->id) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color: #1798A5">Alter</strong> <?= h($participant['612158X3X5']) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color: #1798A5">Geschlecht</strong>  <?= h($this->Participants->getSex($participant)) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color:  #1798A5">Zeitpunkt</strong> <?= h($this->Time->format($participant->startdate)) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color:  #1798A5">Dauer</strong> <?= h($this->Participants->getShortestInterviewDuration($participant)) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color:  #1798A5">Video-Dauer</strong> <?= h($this->Participants->getFormatedVideoDuration($participant)) ?>
        <span style="padding-left: 1em"></span>
        <strong style="color:  #1798A5">Internet-Level</strong> 
        <?php
            $iLevel = $participant['612158X6X21'];
            switch ($iLevel) {
                case 'AO01':
                    echo "Beginner";
                    break;
                case 'AO02':
                    echo "Middle";
                    break;
                case 'AO03':
                    echo "Expert";
                    break;
            }
        ?>
        <span style="padding-left: 1em"></span>
        <strong style="color:  #1798A5">Mood</strong> 
        <?php
                    $moodStart = "NOT SET";
                    switch ($participant['612158X3X8']) {
                        case 'AO01':
                            $moodStart = "Schlecht";
                            break;
                        case 'AO02':
                            $moodStart = "Nicht gut";
                            break;
                        case 'AO03':
                            $moodStart = "Neutral";
                            break;
                        case 'AO04':
                            $moodStart = "Gut";
                            break;
                        case 'AO05':
                            $moodStart = "Sehr gut";
                            break;
                    }

                    $moodEnd = "NOT SET";
                    switch ($participant['612158X8X55']) {
                        case 'AO01':
                            $moodEnd = "Schlecht";
                            break;
                        case 'AO02':
                            $moodEnd = "Nicht gut";
                            break;
                        case 'AO03':
                            $moodEnd = "Neutral";
                            break;
                        case 'AO04':
                            $moodEnd = "Gut";
                            break;
                        case 'AO05':
                            $moodEnd = "Sehr gut";
                            break;
                    }

                    echo "Start: $moodStart | Ende: $moodEnd";
                ?>
    </p>
    <p>
        <strong style="color: #1798A5">Task-Reihenfolge und Dauer</strong> <br> <?= $this->Participants->getOrderedTaskDurations($participant) ?>
    </p>
    <div class="row">
        <h4><?= __('Chord und Map besser als Liste:') ?></h4>
        <?php 
            switch ($participant['612158X10X70']) {
                case 'Y':
                    echo '<h5 style="color:green">&check; Chord und Map besser.</h5>';
                    break;
                case 'N':
                    echo '<h5 style="color:red">&#10060; Liste besser.</h5>';
                    break;
            }
        ?>
        <?= $this->Text->autoParagraph(h($participant['612158X10X50'])); ?>
        <h6><?= __('Kodierung') ?></h6>
        <?= "TBA" ?>
    </div>
    <hr>
    <div class="row">
        <h4><?= __('Listenfeedback') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X53'])); ?>
        <h6><?= __('Kodierung') ?></h6>
        <?= "TBA" ?>
    </div>
    <hr>
    <div class="row">
        <h4><?= __('Chordfeedback') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X52'])); ?>
        <h6><?= __('Kodierung') ?></h6>
        <?= "TBA" ?>
    </div>
    <hr>
    <div class="row">
        <h4><?= __('Mapfeedback') ?></h4>
        <?= $this->Text->autoParagraph(h($participant['612158X10X71'])); ?>
        <h6><?= __('Kodierung') ?></h6>
        <?= "TBA" ?>
    </div>
    <hr>

<?php 
    $currentParticipantIdKey = array_search($participant->id, $idsWhoFinished);
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
