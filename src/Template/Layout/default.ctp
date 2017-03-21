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
    <?= $this->Html->css('bootstrap/bootstrap'); ?>
    <?= $this->Html->css('bootstrap/bootstrap-theme'); ?>
    <?= $this->Html->css('login_form') ?>
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
        <?= $this->Html->link('INASSA', ['controller' => 'clients', 'action' => 'gestion'], ['class' => 'navbar-brand']); ?>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav" id="menu">
            <?php if ($this->request->action == 'gestion')
                echo "<li class='active'>";
            else
                echo "<li>";?>
            <?= $this->Html->link('Accueil', ['controller' => 'clients', 'action' => 'gestion']); ?></li>

            <?php if ($this->request->action == 'historique')
                echo "<li class='active'>";
            else
                echo "<li>";?>

            <?= $this->Html->link('Historique', ['controller' => 'logs', 'action' => 'historique']); ?></li>

            <?php if ($this->request->session()->read('Auth.User')['access']) { ?>
                <?php
                if ($this->request->action == 'addusers')
                    echo "<li class='active'>";
                else
                    echo "<li>";
                ?>
                <?= $this->Html->link('Parametres', ['controller' => 'users', 'action' => 'addusers'], ['class' => 'list-dropdown']); ?></li>
            <?php } ?>
            <li class="divider"></li>
            <li><?= $this->Html->link('Deconnexion', ['controller' => 'users', 'action' => 'logout'], ['class' => 'list-dropdown']); ?></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown img-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?= $this->Html->image('logo_inassa.png', ['height' => '36', 'class' => 'img-navbar']); ?>
                    <?= '<b>'.$this->request->session()->read('Auth.User')['first_name']. '</b>' ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if ($this->request->session()->read('Auth.User')['access']) { ?>
                        <?php
                        if ($this->request->action == 'addusers')
                            echo "<li class='active'>";
                        else
                            echo "<li>";
                        ?>
                        <?= $this->Html->link('Parametres', ['controller' => 'users', 'action' => 'addusers']); ?></li>
                        <li class="divider"></li>
                    <?php } ?>
                    <li><?= $this->Html->link('Deconnexion', ['controller' => 'users', 'action' => 'logout']); ?></li>
                </ul>
            </li>


        </ul>

        <?php
        if ($this->request->action == 'gestion'){
            echo '<div class="col-sm-5 col-md-5 navbar-right">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher un client" name="q">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>';
        }?>
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

<?= $this->Html->script('jquery.min') ?>
<?= $this->Html->script('printMap') ?>
<?= $this->Html->script('bootstrap/bootstrap') ?>
<?= $this->Html->script('data_table/jquery.dataTables.min'); ?>
<?= $this->Html->script('data_table/dataTables.bootstrap.min'); ?>
<?= $this->Html->script('script_datatable'); ?>
</html>
