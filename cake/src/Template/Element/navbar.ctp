<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
        <?php
        if($this->request->action == 'findMatches' && !empty($this->request->query)) {
            echo $this->Html->link(
                '<span class="hidden-xs">Filterung anpassen</span> <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>',
                ["controller" => "ypois", "action" => "setScenario", "?" => $this->request->query],
                [
                  'class' => 'btn btn-default navbar-btn', 
                  'id' => 'filter', 
                  'escape' => false
                ]
            );
            // echo '<button id="filter" type="button" class="btn btn-default navbar-btn" aria-label="Öffnen Sie die Filter"></button>';
        }
        if($this->request->action  != 'setScenario' && !empty($this->request->query)) {
            echo '<button id="componentWheel" type="button" class="btn btn-default navbar-btn" aria-label="Öffnen Sie das Komonenten Rad"><span class="hidden-xs">Komponenten browsen</span> <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span></button>';
          }
          ?>
      <button type="button" class="navbar-toggle collapsed"
        data-toggle="collapse" data-target="#navbar" aria-expanded="false"
        aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span> <span
          class="icon-bar"></span> <span class="icon-bar"></span> <span
          class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?= $step; ?></a >
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <?= $vizElement; ?>
      </ul>
    </div>
    <!--/.nav-collapse -->
  </div>
</nav>
