<?= $this->assign('title', 'INASSA - Accueil'); ?>

<!--Block contenant le formulaire pour la recherche d'un client -->


<div class="container">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="gestion">
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("first_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Prénom")) ?>
                        </div> <!-- form group [rows] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) ?>
                        </div><!-- form group [search] -->
                        <div class="form-group col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input name="dob" id="dob" type="text" class="form-control  datepicker"
                                       placeholder="Date de naissance">
                            </div>
                        </div>
                        <div class="form-group  col-md-2 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <button type="submit" type="reset" class="btn btn-default filter-col">
                                <span class="glyphicon glyphicon-search"></span> Rechercher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="">
    <?php
        if (!isset($client)) {
            ?>
            <div class="client" style="display: ;">
                <p class="text-center">
                    Recherchez un client ...
                </p>
            </div>
            <?php
        }
            ?>
    <?php
        if (isset($client)) {
            if ($client['success']) {
                $status = $client['status'] == true ? '<span class="status_active">Client Actif</span>' : '<span class="status_inactive">Client inactif</span>';
                echo '<div class="client" style="display: ;">
            <div class="info_client container-fluid" style="">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="title_search margin-bottom-20">Recherche Active</h3>
                        <p class="info-container">
                            <span class="indicatif">Client</span>
                            <span class="deux-point">:</span>
                            <span class="result">' . $client["firstname"] . ' ' . $client["lastname"] . '</span>
                            <br/>
                            <span class="indicatif">Date de naissance</span>
                            <span class="deux-point">:</span>
                            <span class="result">' . $client["dob"] . '</span>
                        </p>
                        <div class="status-carte center-horizontal margin-bottom-20">
                            '.$status.'
                        </div>
                    </div>
                </div>
    
            </div>
            <div class="center-horizontal container-fluid center-horizontal margin-10">'.

                    $this->Html->link('Voir l\'historique de ce client', [
                        'controller' => 'logs',
                        'action' => 'historique',
                        '?' =>
                            [
                                "first_name" => $client["field_firstname"],
                                "last_name" => $client["field_lastname"],
                                "dob" => substr($client["field_dob"], 0, 10)
                            ]
                    ])


                    .'</div>
        </div>';
            }
            else{
                echo '
                    <div class="client" style="display: ;">
                        <div class="info_client container-fluid" style="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="status-carte center-horizontal margin-top-20 margin-bottom-20">
                                        <span class="status_inactive">Les informations saisies ne correspondent à aucun client de la INASSA</span>
                                    </div>
                                </div>
                            </div>
                
                        </div>
                    </div>
                ';
            }
        }
    ?>
</div>


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
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>