<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Food_M_App';
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <?= $this->Html->charset() ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="description" content="">
  <meta name="author" content="">
  <title>
    <?= $cakeDescription ?>:
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('icon') ?>

  <!-- <?= $this->Html->css('base.css') ?> -->
  <!-- <?= $this->Html->css('cake.css') ?> -->
  <?= $this->Html->css('awesomplete.css') ?>
  <!-- Bootstrap core CSS -->
  <?= $this->Html->css('fmappdata.css') ?>
  <!-- Leaflet CSS -->
  <?= $this->Html->css('leaflet.1.6.0.css') ?>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

  <!-- Some JS at the end of the document but awesomplete and d3-->
  <?= $this->Html->script('awesomplete.min.js') ?>
  <?= $this->Html->script('jquery-2.1.4.min.js') ?>

  <?= $this->Html->script('d3.v5.js') ?>

  <?= $this->Html->script('leaflet.1.6.0') ?>
  <?= $this->Html->script('leaflet-providers.js') ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>

<body role="document">
  <div id="heatmapContainer">
    <div id="heatmap"></div>
  </div>
  <?= $this->element('aoimodal'); ?>
  <div id="analyzeContainer">
    <div class="container" role="main">
      <?= $this->fetch('content') ?>
    </div> <!-- /.container -->
  </div>
  <footer>
  </footer>

  <!-- Placed at the end of the document so the pages load faster -->
  <?= $this->Html->script('bootstrap.js') ?>
  <?= $this->Html->script('heatmap.min.js') ?>
  <!-- Block for post heatmap init -->
  <?= $this->fetch('scriptAfterHeatmap'); ?>
  <?= $this->Html->script('fmapp_beta_app.js') ?>

  <!-- Block for post fmApp init -->
  <?= $this->fetch('scriptAfterfmApp'); ?>

</body>

</html>
