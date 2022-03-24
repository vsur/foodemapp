<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand hidden-xs hidden-sm" href="#"><?= $step; ?></a >
      <span>Dropdown einbauen</span>
      <?php
          
          echo $this->Html->link(
            '<span class="hidden-xs hidden-sm hidden-md">Query bewerten </span> <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>',
            ["controller" => "RequestEvaluations", "action" => "new", $this->request->pass[0], "?" => $this->request->query],
            [
              'class' => 'btn btn-default navbar-btn', 
              'id' => 'requestEval',
              'aria-label' => 'Datenanzeigen', 
              'escape' => false
            ]
          );
      ?>
    </div>
    <!--/.nav-collapse -->
  </div>
</nav>
