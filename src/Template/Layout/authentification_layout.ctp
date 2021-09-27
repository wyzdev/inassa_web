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
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('authentification_page') ?>
    <?= $this->Html->css('font-awesome/font-awesome/css/font-awesome.min'); ?>
    <?= $this->Html->css('default_page'); ?>
    <?= $this->Html->css('sidebar'); ?>
    <?= $this->Html->css('bootstrap/bootstrap') ?>
    <?= $this->Html->css('bootstrap/bootstrap-theme') ?>
    <?= $this->Html->css('loader'); ?>
    <?= $this->Html->css('sidebar'); ?>
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
    <?php //$this->Html->css('vertical_center') ?>
    <?= $this->Html->css('login_form') ?>


    <?= $this->fetch('meta') ?>
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <?= $this->Html->link('INASSA', ['controller' => 'users', 'action' => 'login'], ['class' => 'navbar-brand']); ?>
    </div>
</nav>


<?= $this->Flash->render(); ?>
<!-- Contenu de la page "AUTHENTIFICATION " -->
<div style="margin-bottom: 75px;">
    <?= $this->fetch('content') ?>
</div>

<footer class="navbar navbar-default navbar-fixed-bottom" style="margin-bottom: 0;">
    <div class="container">
        <p class="navbar-text pull-left">Copyright © INASSA 2017
        </p>
    </div>
</footer>
</body>

<?= $this->Html->script('jquery.min') ?>
<?= $this->Html->script('bootstrap') ?>
<?= $this->Html->script('jquery.dataTables.min') ?>
<?= $this->Html->script('dataTables.bootstrap.min') ?>
<?= $this->Html->script('sidebar'); ?>


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

<script>
    window.onload = function () {
        $('#content_loader').hide(200, function () {

        })
    };
</script>
</html>
