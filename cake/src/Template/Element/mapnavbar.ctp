<!-- Fixed navbar -->
<nav id="mapNavbar" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-mapComponentsChoice" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <p class="navbar-text hidden-xs hidden-sm hidden-md">Kategorien:</p>
    </div>
    <div class="collapse navbar-collapse" id="collapse-mapComponentsChoice">

      <ul id="mapComponentsChoice" class="nav navbar-nav">
        <?php if (isset($configuredSelection)) : ?>
          <li class="active"><a href="#" id="mapComponentsChosen" data-component-presentation="chosen">Gesuchte <span class="hidden-xs hidden-sm">Kategorien</span></a></li>
        <?php endif; ?>
        <?php if ($this->request->session()->check('Config.geolocation')) : ?>
          <li><a href="#" id="mapComponentsOther" data-component-presentation="distance">Entfernung <span class="hidden-xs hidden-sm">Anzeigen</span></a></li>
        <?php endif; ?>
        <li class="<?= isset($configuredSelection) ? '' : 'active' ?>"><a href="#" id="mapComponentsHide" data-component-presentation="none"><span class="hidden-xs hidden-sm">Kategorien ausblenden</span><span class="visible-xs visible-sm">Keine</span></a></li>
        <li><a href="#" id="mapComponentsOther" data-component-presentation="other">Übrige <span class="hidden-xs hidden-sm">Kategorien</span></a></li>
        <li><a href="#" id="mapComponentsOther" data-component-presentation="justBinary">Binär</a></li>
        <li><a href="#" id="mapComponentsOther" data-component-presentation="justNominal">Nominal</a></li>
        <li><a href="#" id="mapComponentsOther" data-component-presentation="justOrdinal">Ordinal</a></li>

      </ul>
    </div>
  </div>
</nav>