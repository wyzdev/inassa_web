<?= $this->assign('title', 'INASSA - Accueil'); ?>


<div class="container" style="">
   <!-- <p class="text-center">
        Recherchez un client ...
    </p>-->
    <div class="client" style="display: ;">
        <div class="info_client container-fluid" style="">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title_search margin-bottom-20">Recherche Active</h3>
                    <p class="info-container">
                        <span class="indicatif">Client</span>
                        <span class="deux-point">:</span>
                        <span class="result">John DOE</span>
                        <br/>
                        <span class="indicatif">Date de naissance</span>
                        <span class="deux-point">:</span>
                        <span class="result">07 / 04 / 1973</span>
                    </p>
                    <div class="status-carte center-horizontal margin-bottom-20">
                        <span class="status">Carte Active</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="center-horizontal container-fluid center-horizontal margin-10">
            <a class=" col-xs-12 col-md-4  col-md-offset-4 margin-10 padding-10">Voir l'historique de ce client</a>
        </div>
    </div>
</div>


<?php
$loguser = $this->request->session()->read('Auth.User');
if ($loguser['first_login']) { ?>
    <style>
        .modal {
            display: block;
        }
    </style>
    <div class="modal-backdrop fade in">

    </div>
<?php } ?>

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog"
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
