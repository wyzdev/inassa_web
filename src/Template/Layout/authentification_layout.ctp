<?php
/**
 * @copyright     Copyright (c) (Inassa 2017))
 * @link          nassagroup.com
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
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
    <?= $this->Html->css('bootstrap/bootstrap') ?>
    <?= $this->Html->css('bootstrap/bootstrap-theme') ?>
    <?= $this->Html->css('loader'); ?>
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

<script>
    window.onload = function () {
        $('#content_loader').hide(200, function () {

        })
    };
</script>
</html>
