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
    <?= $this->Html->css('search_form') ?>
    <?= $this->Html->css('bootstrap-datepicker.min') ?>
    <?= $this->Html->css('navbar'); ?>
    <?= $this->Html->css('accueil'); ?>
    <?= $this->Html->css('default_page')?>
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
        <a class="navbar-brand">INASSA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav" id="menu">
            <?php if ($this->request->action == 'gestion')
                echo "<li class='active'>";
            else
                echo "<li>"; ?>
            <?= $this->Html->link('Accueil', ['controller' => 'clients', 'action' => 'gestion']); ?></li>

            <?php if ($this->request->action == 'historique')
                echo "<li class='active'>";
            else
                echo "<li>"; ?>

            <?= $this->Html->link('Historique', ['controller' => 'logs', 'action' => 'historique']); ?></li>
            <!--<li><?/*= $this->Html->link('Test', ['controller' => 'users', 'action' => 'test']); */?></li>-->

            <?php if ($this->request->session()->read('Auth.User')['role'] == 'admin') { ?>
                <?php
                if ($this->request->action == 'addusers')
                    echo "<li class='active'>";
                else
                    echo "<li>";
                ?>
                <?= $this->Html->link('Paramètres', ['controller' => 'users', 'action' => 'addusers'], ['class' => 'list-dropdown']); ?></li>
            <?php } ?>
            <li class="divider"></li>
            <li><?= $this->Html->link('Déconnexion', ['controller' => 'users', 'action' => 'logout'], ['class' => 'list-dropdown']); ?></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown img-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?= $this->Html->image('logo_inassa_profile.png', ['height' => '36', 'class' => 'img-navbar']); ?>
                    <?= '<b>' . $this->request->session()->read('Auth.User')['first_name'] . '</b>' ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if ($this->request->session()->read('Auth.User')['role'] == 'admin') { ?>
                        <?php
                        if ($this->request->action == 'addusers')
                            echo "<li class='active'>";
                        else
                            echo "<li>";
                        ?>
                        <?= $this->Html->link('Paramètres', ['controller' => 'users', 'action' => 'addusers']); ?></li>
                        <li class="divider"></li>
                    <?php } ?>
                    <li><?= $this->Html->link('Déconnexion', ['controller' => 'users', 'action' => 'logout']); ?></li>
                </ul>
            </li>


        </ul>


    </div><!-- /.navbar-collapse -->
</nav>


<?php
if ($this->request->action != 'addusers') {
    $print_or_not = ($this->request->action == 'gestion') ? 'style = "display: block"' : '';
    echo '
    <div class="container">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form">
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">'
        . $this->Form->input("first_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Prénom")) .
        '</div> <!-- form group [rows] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">'
        . $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) .
        '</div><!-- form group [search] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">                       
                            <div >
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                  <input name="dob" id="dob" type="text" class="form-control  datepicker" placeholder="Date de naissance">
                                </div>
                            </div>
                        </div> <!-- form group [order by] -->
                        <div class="form-group  col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <button type="submit" class="btn btn-default filter-col">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    ';

} ?>


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
<?= $this->Html->script('bootstrap-datepicker.min') ?>
<?= $this->Html->script('datepicker') ?>
<?= $this->Html->script('bootstrap-datepicker.fr.min') ?>
<?= $this->Html->script('toggle_search_form') ?>
<?= $this->Html->script('addusers') ?>
<?= $this->Html->script('update_database') ?>
<?= $this->Html->script('bootstrap/bootstrap') ?>
<?= $this->Html->script('data_table/jquery.dataTables.min'); ?>
<?= $this->Html->script('data_table/dataTables.bootstrap.min'); ?>
<?= $this->Html->script('script_datatable'); ?>
</html>

