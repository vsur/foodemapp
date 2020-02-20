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

        <?= $this->Form->create($requestEvaluation) ?>
            <legend><?= __('Add Request Evaluation') ?></legend>
            <fieldset disabled>
                <div class="form-group">
                    <?php
                        echo $this->Form->label('query_parameters', 'Paraemter Ihrer Suchanfrage');
                        echo $this->Form->text('query_parameters', ['class' => 'form-control', 'value' => 'sdjkhfg']); 
                    ?>
                </div>
            </fieldset>

            <?=  $this->Form->hidden('ypois_count', ['value' => 5]); ?>
            <?=  $this->Form->hidden('choosen_components_count', ['value' => 10]); ?>
            <?=  $this->Form->hidden('other_components_count', ['value' => 15]); ?>

            <?=  $this->Form->hidden('comming_from_view', ['value' => 'list']); ?>
                        
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
                    echo $this->Form->control('name', ['label' => 'E-Mail-Adresse', 'class' => 'form-control']); 
                ?>
            </div>
            <?php
                echo $this->Form->label('grade', 'Vergeben Sie eine Schulnote für die Qualität der Suchanfrage');
                $options = [1, 2, 3, 4, 5, 6];
                echo $this->Form->select('grade', $options, ['class' => 'form-control', 'empty' => true]);
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
