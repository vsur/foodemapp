<?=
  $this->element('navbar',
  [
    "step" => "Anzeige der Ergebnisse",
    "vizElement" => "<li class=\"active\"><a href=\"#\">Möglichkeiten</a></li>"
  ]);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>
<!--
<div id="loadingSpinnerContainer">
    <div class="spinner">
      <div class="cube1"></div>
      <div class="cube2"></div>
    </div>
    <h1>Ihre Auwahl wird analysiert</h1>
</div>
-->
<div class="row">
  <div class="col-md-12">
    <?= $this->Html->image('wordcloud.png', ['alt' => 'Wordcloud von Themenfeldern dieser Anwendung', 'class' => 'thumbnail img-rounded img-responsive']); ?>
  </div>
</div>

<?php $this->assign('title', 'Vergleichen Sie Ihre Auswahl'); ?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Binary</th>
                    <th>Nominal</th>
                    <th>Ordinal</th>
                    <th>Stars</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ypois as $nr => $ypoi): ?>
                <tr>
                    <td><?= $this->Number->format($nr + 1) ?></td>
                    <td><?= h($ypoi->name) ?></td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->binary_components as $binaryComponent): ?>
                                <li><?= $binaryComponent->display_name != '' ? $binaryComponent->display_name : ('<span class="text-muted">' . $binaryComponent->name . '</span>')  ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->nominal_attributes as $nomnialAttribute): ?>
                                <li><?= $nomnialAttribute->nominal_component->display_name != '' ? ($nomnialAttribute->nominal_component->display_name . '.') : ('<span class="text-muted">' . $nomnialAttribute->nominal_component->name . ':</span>') ?> <?= $nomnialAttribute->display_name != '' ? $nomnialAttribute->display_name : ('<span class="text-muted">' . $nomnialAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->ordinal_attributes as $ordinalAttribute): ?>
                                <li><?= $ordinalAttribute->ordinal_component->display_name != '' ? ($ordinalAttribute->ordinal_component->display_name . ':') : ('<span class="text-muted">' . $ordinalAttribute->ordinal_component->meter . ':</span>') ?> <?= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : ('<span class="text-muted">' . $ordinalAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td><?= $this->Number->format($ypoi->stars) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- /.col-md-12 -->
</div>

<script type="text/javascript">
    var criterionNames = <?= json_encode($criterionNames) ?>;
    var input = document.getElementById("criteriaInput");
    var awesomplete = new Awesomplete(input, {
      minChars: 1,
      autoFirst: true,
      maxItems: 10
    });
    awesomplete.list = criterionNames;
</script>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓ Criteria Block for JS ↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
<script type="text/javascript">
    var criteria = <?= json_encode($criteria) ?>;
    var configuredSelection = <?= json_encode($configuredSelection) ?>;
</script>
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Criteria Block for JS ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
