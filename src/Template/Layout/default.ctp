<?php
/**
 * @copyright     Copyright (c) (Inassa 2017))
 * @link          nassagroup.com
 */

$cakeDescription = 'INASSA: Compagnie d\'assurance';
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
    <?= $this->Html->css('sidebar'); ?>
    <?= $this->Html->css('authentification_page') ?>
    <?= $this->Html->css('font-awesome/font-awesome/css/font-awesome'); ?>
    <?= $this->Html->css('bootstrap/bootstrap-theme'); ?>
    <?= $this->Html->css('login_form') ?>
    <?= $this->Html->css('search_form') ?>
    <?= $this->Html->css('bootstrap-datepicker.min') ?>
    <?= $this->Html->css('navbar'); ?>
    <?= $this->Html->css('accueil'); ?>
    <?= $this->Html->css('loader'); ?>
    <?= $this->Html->css('jquery-ui/jquery-ui'); ?>
    <?= $this->Html->css('default_page')?>
    <?= $this->fetch('meta'); ?>
    <?= $this->fetch('css'); ?>

    <style type="text/css">
        .ui-dialog-titlebar-close{
            display: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <span id="role_user" role="<?= $this->request->session()->read('Auth.User')['role'] ?>"></span>
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
                echo "<li>"; ?>
            <?= $this->Html->link('<i class="fa fa-home"></i>' . ' Accueil', ['controller' => 'clients', 'action' => 'gestion'], ['escape' => false]); ?></li>
            <?php if ($this->request->session()->read('Auth.User')['role'] != "medecin"): ?>
                <?php if ($this->request->action == 'historique')
                    echo "<li class='active'>";
                else
                    echo "<li>"; ?>

                <?= $this->Html->link('<i class="fa fa-history"></i>' . ' Historique', ['controller' => 'logs', 'action' => 'historique'], ['escape' => false]); ?></li>
            <?php endif; ?>
           <!--  <li>
                <a href="#" class="test_api"><i class="fa fa-check-square-o"></i> Test API</a></li> -->

            <?php if ($this->request->session()->read('Auth.User')['role'] == 'admin') { ?>
                <?php
                if ($this->request->action == 'addusers')
                    echo "<li class='active'>";
                else
                    echo "<li>";
                ?>
                <?= $this->Html->link('<i class="fa fa-cog"></i>' . ' Paramètres', ['controller' => 'users', 'action' => 'addusers'], ['class' => 'list-dropdown', 'escape' => false]); ?></li>
                <?php
                if ($this->request->action == 'readlogs')
                    echo "<li class='active'>";
                    else
                        echo "<li>";
                    ?>
                    <?= $this->Html->link('<i class="fa fa-file-archive-o"></i>' . ' Logs', ['controller' => 'logs', 'action' => 'readlogs'], ['class' => 'list-dropdown', 'escape' => false]); ?></li> <?php
                if ($this->request->action == 'manuel')
                    echo "<li class='active'>";
                else
                    echo "<li>";
                    ?>
                <?= $this->Html->link('<i class="fa fa-book"></i>' . ' Manuel d\'utilisation', ['controller' => 'users', 'action' => 'manuel'], ['class' => 'list-dropdown', 'escape' => false]); ?></li>
            <?php } ?>
            <li class="divider"></li>
            <li><a href="#modal_change_password" data-toggle="modal" class="list-dropdown"><i class="fa fa-lock"></i> Changer de mot de passe</a></li>
            <li class="divider"></li>
            <li><?= $this->Html->link('<i class="fa fa-sign-out"></i>' . ' Déconnexion', ['controller' => 'users', 'action' => 'logout'], ['class' => 'list-dropdown', 'escape' => false]); ?></li>

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
                        <?= $this->Html->link('<i class="fa fa-cog"></i>' . ' Paramètres', ['controller' => 'users', 'action' => 'addusers'], ['escape' => false]); ?></li>
                        <li class="divider"></li>
                        <?php
                        if ($this->request->action == 'readlogs')
                            echo "<li class='active'>";
                        else
                            echo "<li>";
                        ?>
                        <?= $this->Html->link('<i class="fa fa-file-archive-o"></i>' . ' Logs', ['controller' => 'logs', 'action' => 'readlogs'], ['escape' => false]); ?></li>
                        <li class="divider"></li>
                        <?php
                        if ($this->request->action == 'manuel')
                            echo "<li class='active'>";
                        else
                            echo "<li>";
                        ?>
                        <?= $this->Html->link('<i class="fa fa-book"></i>' . ' Manuel d\'utilisation', ['controller' => 'users', 'action' => 'manuel'], ['escape' => false]); ?></li>
                        <li class="divider"></li>
                    <?php } ?>
                    <li><a href="#modal_change_password" data-toggle="modal"><i class="fa fa-lock"></i> Changer de mot de passe</a></li>
                        <li class="divider"></li>
                    <li><?= $this->Html->link('<i class="fa fa-sign-out"></i>' . ' Déconnexion', ['controller' => 'users', 'action' => 'logout'], ['escape' => false]); ?></li>
                </ul>
            </li>


        </ul>


    </div><!-- /.navbar-collapse -->
</nav>




<?= $this->Flash->render(); ?>

<!-- Contenu de la page -->
<div style=" position: fixed; height: 100%; width: 100%; opacity:0.2; z-index: -1;text-align:center">
    <?=$this->Html->image('inassa2.jpeg', array("style" => "width:47%;height:auto;margin:auto;margin-top:50px")); ?>
</div>
<div style="margin-bottom: 75px;">
    <?= $this->fetch('content') ?>
</div>

<footer class="navbar navbar-default navbar-fixed-bottom" style="margin-bottom: 0;">
    <div class="container">
        <p class="navbar-text pull-left">Copyright © INASSA 2017
        </p>
    </div>
</footer>

<!--/////////////////////////////// LOADER 2 /////////////////////////////////////////-->
<div id="content_loader3" style="display: none;background: rgba(0,0,0,0.2);; top:0px; left: 0px; right: 0px; bottom: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>

<!-- Modal change password HTML -->
<div id="modal_change_password" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Saisissez votre nouveau mot de passe</h3>
            </div>

            <div class="modal-body">

                <?= $this->Form->create(null,
                    [
                        'url' =>
                            [
                                'controller' => 'users',
                                'action' => 'changepassword'
                            ]
                    ]) ?>
                <?= $this->Form->input('password1',
                    array('type' => 'password',
                        'class' => 'margin-10 form-control col-md-4',
                        'label' => false,
                        "placeholder" => "Nouveau mot de passe",

                    )) ?>

                <?= $this->Form->input('password2',
                    array(
                        'type' => 'password',
                        'class' => 'margin-10 form-control',
                        'label' => false,
                        "placeholder" => "Confirmer le mot de passe"
                    )) ?>
                <?= $this->Form->button('Enregistrer', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->fetch('script'); ?>
</body>

<?= $this->Html->script('jquery.min') ?>
<?= $this->Html->script('bootstrap-datepicker.min') ?>
<?php
    if ($this->request->action == 'gestion')
        echo $this->Html->script('datepicker_format1');
    else if ($this->request->action == 'historique')
        echo $this->Html->script('datepicker_format2');
?>
<?= $this->Html->script('bootstrap-datepicker.fr.min') ?>
<?= $this->Html->script('toggle_search_form') ?>
<?= $this->Html->script('addusers') ?>
<?= $this->Html->script('update_database') ?>
<?= $this->Html->script('bootstrap/bootstrap') ?>
<?= $this->Html->script('data_table/jquery.dataTables.min'); ?>
<?= $this->Html->script('data_table/dataTables.bootstrap.min'); ?>
<?= $this->Html->script('script_datatable'); ?>
<?= $this->Html->script('jquery-ui/jquery-ui'); ?>
<?= $this->Html->script('test_api'); ?>
<?= $this->Html->script('clear_logs'); ?>
<?= $this->Html->script('sidebar'); ?>
<?= $this->Html->script('gestion'); ?>
<?= $this->Html->script('youtube'); ?>
<script type="text/javascript" src="http://www.youtube.com/player_api"></script>

<script>
    window.onload = function () { $('#content_loader').hide(200, function () {

    })};
</script>

</html>

