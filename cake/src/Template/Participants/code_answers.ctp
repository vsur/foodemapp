<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participant $participant
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Participants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Codes'), ['controller' => 'Codes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Code'), ['controller' => 'Codes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participants form large-9 medium-8 columns content">
    <?= $this->Form->create($participant) ?>
    <fieldset>
        <legend><?= __('Code Participant Answer') ?></legend>
        
        <h3><?= h("Participant ID: " . $participant->id) ?></h3>
        <p class="participantsAggregatedInfos">
        <span>
            <strong>ID</strong> <?= h($participant->id) ?>
        </span>
        <span>
            <strong>Alter</strong> <?= h($participant['612158X3X5']) ?>
        </span>
        <span>
            <strong>Geschlecht</strong>  <?= h($this->Participants->getSex($participant)) ?>
        </span>
        <span>
            <strong>Zeitpunkt</strong> <?= h($this->Time->format($participant->startdate)) ?>
        </span>
        <span>
            <strong>Dauer</strong> <?= h($this->Participants->getShortestInterviewDuration($participant)) ?>
        </span>
        <span>
            <strong>Video-Dauer</strong> <?= h($this->Participants->getFormatedVideoDuration($participant)) ?>
        </span>
        <span>
            <strong>Internet-Level</strong> <?= h($this->Participants->getInternetLevel($participant)) ?>
        </span>
        <span>
            <strong>Mood</strong> <?= h($this->Participants->getMoods($participant)) ?>
        </span>
    </p>
    <p class="participantsAggregatedInfos">
        <strong>Task-Reihenfolge und Dauer</strong> <?= $this->Participants->getOrderedTaskDurations($participant, $inlineFormatet = TRUE) ?>
        <strong style="color: green">Beste Viz: <?=  $this->Participants->getFavoriteViz($participant) ?></strong> 
    </p>

        <!-- 612158X8X54 -->
        <div class="row">
            <h4><?= __('Chord und Map besser als Liste:') ?></h4>
            <?= $this->Participants->getChordMapOverList($participant) ?>
            <?= $this->Text->autoParagraph(h($participant['612158X10X50'])); ?>
        </div>
        <hr>
        <div class="row">
            <h4>
                <?= __('Listenfeedback') ?>
                <?=
                    $this->Html->link('☰', 
                        [
                            'controller' => 'Ypois',
                            'action' => 'checkMouseData',
                            'list',
                            $participant->id,
                            '?' => [
                                "BC_C-ID_81_BC-STATE_1"=> 4,
                                "BC_C-ID_77_BC-STATE_1"=>5,
                                "BC_C-ID_50_BC-STATE_1"=>5,
                                "NC_C-ID_3_NCATTR-ID_7"=>5,
                                "NC_C-ID_7_NCATTR-ID_26"=>4,
                                "OC_C-ID_1_OCATTR-ID_2"=>3,
                                "OC_C-ID_3_OCATTR-ID_11"=>5
                            ]
                        ], 
                        [
                            'target' => '_blank',
                            'escape' => false
                        ]
                    ) 
                ?>
            </h4>
            <?= $this->Text->autoParagraph(h($participant['612158X10X53'])); ?>
        </div>
        <hr>
        <div class="row">
            <h4>
                <?= __('Chordfeedback') ?>
                <?=
                    $this->Html->link('☼', 
                        [
                            'controller' => 'Ypois',
                            'action' => 'checkMouseData',
                            'chord',
                            $participant->id,
                            '?' => [
                                "BC_C-ID_103_BC-STATE_1"=>5,
                                "NC_C-ID_6_NCATTR-ID_21"=>4,
                                "BC_C-ID_75_BC-STATE_1"=>3,
                                "BC_C-ID_89_BC-STATE_0"=>5
                            ]
                        ], 
                        [
                            'target' => '_blank',
                            'escape' => false
                        ]
                    ) 
                ?>
            </h4>
            <?= $this->Text->autoParagraph(h($participant['612158X10X52'])); ?>
        </div>
        <hr>
        <div class="row">
            <h4>
                <?= __('Mapfeedback') ?>
                <?=
                    $this->Html->link('⦿', 
                        [
                            'controller' => 'Ypois',
                            'action' => 'checkMouseData',
                            'map',
                            $participant->id,
                            '?' => [
                                "NC_C-ID_2_NCATTR-ID_4"=>5,
                                "BC_C-ID_40_BC-STATE_1"=>5,
                                "BC_C-ID_94_BC-STATE_1"=>4,
                                "BC_C-ID_77_BC-STATE_1"=>3
                            ]
                        ], 
                        [
                            'target' => '_blank',
                            'escape' => false
                        ]
                    ) 
                ?>
            </h4>
            <?= $this->Text->autoParagraph(h($participant['612158X10X71'])); ?>
        </div>
        <hr>
        <?php if($participant['612158X8X54']): ?>
            <div class="row">
                <h4><?= __('Abschlusskommentar') ?></h4>
                <?= $this->Text->autoParagraph(h($participant['612158X8X54'])); ?>
            </div>
            <hr>
        <?php endif; ?>

        <div class="row">
            <h6 class="codeBlockHeading"><?= __('Codes') ?></h6>
            <?= $this->Participants->generateCodesList($participant, $codes) ?>
        </div>
       
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <?php 
    $currentParticipantIdKey = array_search($participant->id, $idsWhoFinished);
?>

    <div class="paginator" style="text-align: left;">
        <ul class="pagination">
            <li>
                <?= $this->Html->link('‹‹ ', ['action' => 'codeAnswers', $idsWhoFinished[0]]) ?>
            </li>
            <li>
                <?= $this->Html->link('‹ ', ['action' => 'codeAnswers', ($currentParticipantIdKey-1 > 0 ? $idsWhoFinished[$currentParticipantIdKey-1] : $idsWhoFinished[0])]) ?>
            </li>
            <li>
                <?= $this->Html->link("Aktuelle ID: $participant->id ", ['action' => 'codeAnswers', $participant->id]) ?>
            </li>
            <li>
                <?= $this->Html->link('› ', ['action' => 'codeAnswers', ($currentParticipantIdKey+1 < array_key_last($idsWhoFinished) ? $idsWhoFinished[$currentParticipantIdKey+1] : $idsWhoFinished[array_key_last($idsWhoFinished)])]) ?>
            </li>
            <li>
            </li>
            <li>
                <?= $this->Html->link('›› ', ['action' => 'codeAnswers', $idsWhoFinished[array_key_last($idsWhoFinished)]]) ?>
            </li>
        </ul>
        <p style="text-align: left;"><?= __("Participant " . (intval($currentParticipantIdKey)+1 ) . " von " . count($idsWhoFinished)) ?></p>
    </div>
</div>

<?= $this->Html->css('participants-coding'); ?>
<?= $this->Html->script('jquery-2.1.4.min.js') ?>
<script>
    $(".commentSwitch").click(function(event){
        $(this).siblings("input[type=text]").toggle();
    });
</script>