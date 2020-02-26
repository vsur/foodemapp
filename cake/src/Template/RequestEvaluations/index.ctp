<?=
  $this->element('navbar',
  [
    "step" => "Liste der bewerteten Queries",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>"
  ]);
?>

<?= $this->Flash->render() ?>

<div class="row">
  <div class="col-md-12">
    <?= 
        // echo $this->Html->image('isac-header.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); 
        $this->Html->image('wordcloud.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); 
    ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <h3><?= __('Beweretete Queries') ?></h3>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ypois_count', 'POIs') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Gesuchte Komp.') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Other Komp.') ?></th>
                <th scope="col"><?= $this->Paginator->sort('view_to_evaluate', 'Anzeige Art') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grade', 'Note') ?></th>
                <th scope="col" class="actions text-center"><?= __('Details') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requestEvaluations as $requestEvaluation): ?>
            <tr>
                <td><?= $this->Number->format($requestEvaluation->id) ?></td>
                <td><?= $this->Number->format($requestEvaluation->ypois_count) ?></td>
                <td><?= $this->Number->format($requestEvaluation->choosen_components_count) ?></td>
                <td><?= $this->Number->format($requestEvaluation->other_components_count) ?></td>
                <td>
                    <?php  
                        $get_string = $requestEvaluation->query_parameters;
                        parse_str($get_string, $get_array);

                        switch ($requestEvaluation->view_to_evaluate) {
                            case 'list':
                                echo $this->Html->link(
                                    '<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>',
                                    [
                                        'controller' => 'Ypois',
                                        'action' => 'findMatches', 
                                        'list',
                                        '?' => $get_array
                                    ],
                                    ['escape' => false]
                                ); 
                            break;
                            
                            case 'chord':
                                echo $this->Html->link(
                                    '<span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>',
                                    [
                                        'controller' => 'Ypois',
                                        'action' => 'findMatches', 
                                        'chord',
                                        '?' => $get_array
                                    ],
                                    ['escape' => false]
                                ); 
                            break;
                            
                            case 'map':
                                echo $this->Html->link(
                                    '<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>',
                                    [
                                        'controller' => 'Ypois',
                                        'action' => 'findMatches', 
                                        'map',
                                        '?' => $get_array
                                    ],
                                    ['escape' => false]
                                ); 
                                break;
                        }
                        h($requestEvaluation->view_to_evaluate) 
                    ?>
                </td>
                <td><?= h($requestEvaluation->name) ?></td>
                <td><?= $this->Number->format($requestEvaluation->grade) ?></td>
                <td class="actions text-center">
                    <? 
                        echo $this->Html->link(
                            '<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', 
                            ['action' => 'view', $requestEvaluation->id, 'doStuff'],
                            ['escape' => false]
                        ); 
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>

