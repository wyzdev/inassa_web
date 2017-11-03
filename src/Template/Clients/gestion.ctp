<?= $this->assign('title', 'INASSA - Accueil'); ?>

<?= $this->Html->css('Card') ?>
<?= $this->Html->css('gestion') ?>
<!-- <? /*= $this->Html->css('date-dropdown/styles')*/ ?> -->
<?= $this->Html->script('date-dropdown/date_dropdowns.min', ['block' => true]) ?>


<!--Block contenant le formulaire pour la recherche d'un client -->
<?php

$dob_input = (isset($client_dob)) ? $client_dob : '';
?>
<div class="container">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="gestion">
                        <div class="form-group col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) ?>
                        </div>
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("first_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Prénom")) ?>
                        </div>
                        <div class="form-group col-md-4 col-md-offset-1 col-xs-10 col-xs-offset-1"
                             style="margin-top: 5px;">


                            <?php
                            echo '<input name="dob" id="datepicker_dropdown" type="text" class="form-control "
                                       placeholder="Date de naissance" value="' . $dob_input . '">';

                            ?>
                        </div>
                        <div class="form-group  col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <button type="submit" type="reset" class="btn btn-default filter-col" style="margin-top: 4px;">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--    <input id="example3" name="example3" value="2010-02-17" readonly="readonly" type="text">-->
    <?php
    if (!isset($clients)) {
        ?>
        <div class="container" id="search_text" style="">
            <div class="client" style="display: ;">
                <p class="text-center" style="
            background: rgba(0,0,0,0.2);
            color: white;
            width: 25%;
            margin: auto;
            border-radius: 3px;
            padding: 5px;
            font-weight: bold;
            font-size: 15px;">
                    Recherchez un client ...
                </p>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
    if (isset($clients)) {
        if (sizeof($clients) > 0) {
            ?>

            <div class="row" id="table_client" style="margin-top: 40px;">

                <!-- Table -->
                <table class="col-md-12 table table-striped table-hover table-condensed" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Date de naissance</th>
                        <th>Adresse</th>
                        <th>Numéro de police</th>
                        <th>Compagnie</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php
                    foreach ($clients as $client) {
                        ?>
                        <tr class="client_row" firstname="<?= $client['firstname'] ?>"
                            lastname="<?= $client['lastname'] ?>" status="<?= $client['status'] ?>"
                            dob="<?= $client['dob'] ?>" dob_search="<?= $client_search_dob ?>"
                            style="cursor: pointer; width: 40px;">
                            <td><?= $client['firstname'] ?></td>
                            <td><?= $client['lastname'] ?></td>
                            <td><?= $client['dob'] ?></td>
                            <td><?= $client['address'] ?></td>
                            <td><?= $client['policy_number'] ?></td>
                            <td><?= $client['company'] ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <button type="button" class="btn btn-blue" style="">
                    <i class="fa fa-check"></i>
                </button>
            </div>
            <?php
        } else {
            ?>
            <div class="client row" style="display: ;" id="client_not_exist">
                <div class="info_client" style="">
                    <div class="container">
                        <div class="col-md-12 container-info">
                            <div class="status-carte center-horizontal margin-top-20 margin-bottom-20">
                                <span class="status_inactive">Les informations saisies ne correspondent à aucun client de la INASSA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-blue" style="">
                <i class="fa fa-check"></i>
            </button>
            <?php
        }
    } else {
    }
    ?>

</div>

<div class="client row" id="display_client" style="display: none;">
    <div class="info_client container-fluid" style="">
        <div class="container">
            <div class="col-md-12 container container-info">
                <h3 class="title_search margin-bottom-20">Recherche Active</h3>
                <p class="info-container" id="display_client_info">
                    <!-- info client will be display here -->
                </p>
                <div class="status-carte center-horizontal margin-bottom-20" id="display_client_status">
                    <!-- status will be displayed here -->
                </div>
            </div>

            <button type="button" class="btn btn-blue" style="margin-top: 10px;">
                <i class="fa fa-check"></i>
            </button>

            <center>
                <div class="center-horizontal container-fluid center-horizontal margin-10" style="
                    background: rgba(255,255,255,0.7); margin: auto; display: inline-block;" id="link_to_historic">
                    <!-- Link to go to the historic of a client will be display here -->
                </div>
            </center>
        </div>

    </div>
</div>


<!-- Shows when it is the first login of the user -->
<?php
$loguser = $this->request->session()->read('Auth.User');
if ($loguser['first_login']) { ?>
    <style>
        #modal {
            display: block;
        }
    </style>
    <div class="modal-backdrop fade in">

    </div>
<?php } ?>


<!-- Modal to change the change the password of the user -->
<div class="modal fade in" id="modal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">
                    Choisissez un nouveau mot de passe
                </h4>
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
        </div><!-- /.modal-content -->
    </div>
</div>

<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader"
     style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>



<?= $this->Html->scriptStart(['block' => true]) ?>
    <?= "$(function(){
        $('.day, .month, .year').attr('class', 'form-control');
    })"; ?>
<?= $this->Html->scriptEnd(); ?>