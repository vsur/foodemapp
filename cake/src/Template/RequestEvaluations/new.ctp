<?=
  $this->element('navbar',
  [
    "step" => "Bewertung der aktuellen Suchanfrage",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Rückmeldung</a></li>"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->


<?= $this->Flash->render() ?>


<div class="row">
  <div class="col-md-12">
        <?php 
             $url =  $this->Url->build([
                "?" => $this->request->query,
            ]);
            if(strpos($url, '?') > -1) {
                $queryString =  html_entity_decode( substr($url, strpos($url, '?')+1 ) );
            } else {
                $queryString =  "NULL";
            }
        ?>
        <?= $this->Form->create($requestEvaluation) ?>
            <legend><?= __('Add Request Evaluation') ?></legend>
            <fieldset disabled>
                <div class="form-group">
                    <?php
                        echo $this->Form->label('parameters', 'Paraemter Ihrer Suchanfrage');
                        echo $this->Form->text('parameters', ['class' => 'form-control', 'value' => $queryString]); 
                        ?>
                </div>
            </fieldset>

            <?=  $this->Form->hidden('query_parameters', ['value' => $queryString]); ?>
            <?php  
                echo $this->Form->hidden('ypois_count', ['value' => count($ypois)]); 
            ?>
            <?=  $this->Form->hidden('choosen_components_count', ['value' => count($this->request->query)]); ?>
            <?=  $this->Form->hidden('other_components_count', ['value' => ( $overallComponentCount - count($this->request->query) ) ]); ?>

            <?=  $this->Form->hidden('comming_from_view', ['value' => $commingFromView]); ?>
                        
            <?=  $this->Form->label('view_to_evaluate', 'Zu bewertende Ansicht'); ?>
            <?= $this->Form->radio('view_to_evaluate', [
            
                ['value' => 'list', 'text' => 'Listenansicht', 'class' => 'viewRadio'],
                ['value' => 'chord', 'text' => 'Chord-Diagramm', 'class' => 'viewRadio'],
                ['value' => 'map', 'text' => 'Kartenansicht', 'class' => 'viewRadio'],
                
            ]); ?>

            <div class="form-group">
                <?php
                    echo $this->Form->label('name', 'Ihr Name');
                    echo $this->Form->text('name', ['class' => 'form-control']); 
                ?>
            </div>
            <div class="form-group">
                <?php
                    echo $this->Form->control('email', ['label' => 'E-Mail-Adresse', 'class' => 'form-control']); 
                ?>
            </div>
            <?php
                echo $this->Form->label('grade', 'Note');
                $options = [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ];
                echo $this->Form->select('grade', $options, ['class' => 'form-control', 'empty' => 'Vergeben Sie eine Schulnote für die Qualität der Suchanfrage']);
            ?>
            <div class="form-group">
                <?php
                    echo $this->Form->control('comment', ['label' => ['text' => 'Ihr Kommentar'], 'class' => 'form-control', 'rows' => '3']);
                ?>
            </div>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-default']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
