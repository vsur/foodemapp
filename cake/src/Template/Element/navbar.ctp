<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
        <?php
        if($this->request->action == 'findMatches' && !empty($this->request->query)) {
            if(!$evalAppMode) {
              echo $this->Html->link(
                '<span class="hidden-xs">Filterung anpassen</span> <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>',
                ["controller" => "ypois", "action" => "setScenario", "?" => $this->request->query],
                [
                  'class' => 'btn btn-default navbar-btn',
                  'id' => 'filter',
                  'aria-label' => 'Öffnen Sie die Filter',
                  'escape' => false
                ]
              );
            }
        }
        if( $this->request->action  != 'setScenario' && !empty($this->request->query)) {
            if(!$evalAppMode) {
              if(!empty($this->request->pass)) {
                if( $this->request->pass[0] != 'selectViz' || $this->request->controller  == 'RequestEvaluations' ) {
                  echo $this->Html->link(
                    '<span class="hidden-xs">Ansicht ändern</span> <span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span>',
                    ["controller" => "ypois", "action" => "findMatches", "selectViz", "?" => $this->request->query],
                    [
                      'class' => 'btn btn-default navbar-btn',
                      'id' => 'changeView',
                      'aria-label' => 'Passen Sie die Ansicht an',
                      'escape' => false
                    ]
                  );
                }
              }
              if ($this->request->controller == 'Ypois') {
                echo '<button id="componentWheel" type="button" class="btn btn-default navbar-btn" aria-label="Öffnen Sie das Kategorien-Rad"><span class="hidden-xs">Kategorien browsen</span> <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span></button>';
              }
            }
          }
          ?>
      <!-- <button type="button" class="navbar-toggle collapsed"
        data-toggle="collapse" data-target="#navbar" aria-expanded="false"
        aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span> <span
          class="icon-bar"></span> <span class="icon-bar"></span> <span
          class="icon-bar"></span>
      </button> -->
      <a class="navbar-brand hidden-xs hidden-sm" href="#"><?= $step; ?></a >
      <?php
    //   No for Live Preview Purposes
    //   if($this->request->controller  != 'RequestEvaluations' && $this->request->action  != 'setScenario' && !empty($this->request->query)) {
    //         if(!empty($this->request->pass)) {

    //           echo $this->Html->link(
    //             '<span class="hidden-xs hidden-sm hidden-md">Query bewerten 132 </span> <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>',
    //             ["controller" => "RequestEvaluations", "action" => "new", $this->request->pass[0], "?" => $this->request->query],
    //             [
    //               'class' => 'btn btn-default navbar-btn',
    //               'id' => 'requestEval',
    //               'aria-label' => 'Bewerten Sie die aktuelle Suchanfrage',
    //               'escape' => false
    //             ]
    //           );
    //         }
    //   }
      ?>
    </div>
    <!-- <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <?= $vizElement; ?>
      </ul>
    </div> -->
    <!--/.nav-collapse -->
  </div>
</nav>
