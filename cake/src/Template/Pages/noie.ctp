<?=
$this->element(
  'navbar',
  [
    "step" => "Bitte anderen Browser nutzen",
    // "vizElement" => "<li class=\"active\"><a href=\"#\">Wünsche</a></li>"
  ]
);
?>

<!-- ↑↑↑↑↑↑↑↑↑
↑↑↑ Navbar ↑↑↑
↑↑↑↑↑↑↑↑↑↑ -->

<?= $this->Flash->render() ?>

<div class="row">
  <div class="col-md-12">
    <?php
    // echo $this->Html->image('isac-header.png', ['alt' => 'Header Bilder der ISAC Anwendung', 'class' => 'thumbnail img-rounded img-responsive']);
    echo $this->Html->image('wordcloud.png', ['alt' => 'Header Bilder der FoodMAPP Anwendung', 'class' => 'thumbnail img-rounded img-responsive']);
    ?>
  </div>
</div>

<?php $this->assign('title', 'Bitte anderen Browser nutzen'); ?>

<!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
↓↓↓↓ Cake  Block ↓↓↓↓
↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->

<div class="row">
  <div class="col-md-12">
    <h1>Ja nein … bitte kein Internet Explorer</h1>
    <p>Diese Anwendung nutzt modernes JavaScript in der Version ES6 ECMAScript 2015. Der Internet Explorer ist leider dafür nicht ausgelegt.</p>
    <p>Bitte verwenden Sie einen der Browser in der mindest Version aus der folgenden Tabelle.</p>
    <table class="table table-striped">
      <tbody>
        <tr>
          <th>Browser</th>
          <th>Version</th>
          <th>Veröffentlichungsdatum</th>
        </tr>
        <tr>
          <td>Chrome</td>
          <td>51</td>
          <td>Mai 2016</td>
        </tr>
        <tr>
          <td>Firefox</td>
          <td>52</td>
          <td>März 2017</td>
        </tr>
        <tr>
          <td>Edge</td>
          <td>14</td>
          <td>August 2016</td>
        </tr>
        <tr>
          <td>Safari</td>
          <td>10</td>
          <td>September 2016</td>
        </tr>
        <tr>
          <td>Opera</td>
          <td>38</td>
          <td>Juni 2016</td>
        </tr>
      </tbody>
    </table>

    <p>Für mehr Informationen zu JavaScript und den verschiedenen Versionen, informieren Sie sich bei <a href="https://www.w3schools.com/js/js_versions.asp" target="_blank" title="Infos zu den verschiedenen JS Versionen">W3CSchools</a></p>

    <p>Warum Sie derzeit besser auf die Verwendung der Internet Explorers verzichten sollten, erfahren sie bei <a href="https://www.techbook.de/apps/software/microsoft-warnt-vor-ie" target="_blank" title="Warum man den Internet Explorer nicht mehr nutzen sollte.">Techbook</a></p>
  </div>
</div> <!-- /.row -->
<!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
↑↑↑↑ Cake  Block ↑↑↑↑
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
