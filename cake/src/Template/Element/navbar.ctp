<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
        <?php
        if($this->request->action == 'findMatches' && !empty($this->request->query)) {
            echo '<button id="filterWheelSwitch" type="button" class="btn btn-default navbar-btn" aria-label="Öffnen Sie die Filter"><span class="hidden-xs">Filteranzeige</span> <span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>';
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
