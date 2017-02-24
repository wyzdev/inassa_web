<?php
/**
 * @copyright     Copyright (c) (Inassa 2017))
 * @link          ''
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title'); ?>
    </title>
    <?= $this->Html->meta('icon'); ?>
    <?= $this->Html->css('bootstrap'); ?>
    <?= $this->Html->css('bootstrap-theme'); ?>
    <?= $this->Html->css('navbar'); ?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>
</head>
<body>
  <nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="accueil.php">INASSA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
      <ul class="nav navbar-nav" id="menu">
        <li class="active"><a href="accueil.php">Accueil</a></li>
        <li><a href="historique.php">Historique</a></li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="img/logo_inassa.png" height="40"  style="border-radius: 50%; border: 1px green solid;margin-right:5px;">
            <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="add_user.php">Ajouter un utilisateur</a></li>
            <li class="divider"></li>
            <li><a href="index.php">Deconnexion</a></li>
          </ul>
        </li>
      </ul>
      <div class="col-sm-5 col-md-5 navbar-right">
          <form class="navbar-form" role="search">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Rechercher un client" name="q">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
          </div>
          </form>
      </div>
    </div><!-- /.navbar-collapse -->
  </nav>
    <?= $this->Flash->render(); ?>

    <!-- Cette Helper permet d'afficher le contenu de la page actuelle -->
    <?= $this->fetch('content'); ?>

    <footer class="navbar navbar-default navbar-bottom">
      <div class="container">
        <p class="navbar-text pull-left">Copyright © INASSA 2017
        </p>
      </div>
    </footer>
  
  <?= $this->fetch('script'); ?>
</body>

<?= $this->Html->script('jquery.min')?>
<?= $this->Html->script('bootstrap')?>
<?= $this->Html->script('jquery.dataTables.min'); ?>
<?= $this->Html->script('dataTables.bootstrap.min'); ?>
<?= $this->Html->script('script_datatable'); ?>
</html>
