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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Some JS at the end of the document-->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body role="document">
  <!-- Fixed navbar -->
  <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed"
        data-toggle="collapse" data-target="#navbar" aria-expanded="false"
        aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span> <span
          class="icon-bar"></span> <span class="icon-bar"></span> <span
          class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Auswahl der Kategorien</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Komponenten</a></li>
      </ul>
    </div>
    <!--/.nav-collapse -->
  </div>
  </nav>
  <?= $this->Flash->render() ?>
  <div class="container" role="main">
    <?= $this->fetch('content') ?>
  </div> <!-- /.container -->
  <footer>
  </footer>
  <!-- No Bootstrap core JavaScript, cause Polymer shall be integrated
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <?= $this->Html->script('jquery-2.1.4.min.js') ?>
  <?= $this->Html->script('bootstrap.js') ?>
  <?= $this->Html->script('awesomplete.min.js') ?>
  <?= $this->Html->script('fmapp_app.js') ?>
  <!--
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/fmapp_data.js"></script>
  -->
</body>
</html>
