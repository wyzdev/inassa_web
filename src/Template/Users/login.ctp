<?= $this->assign('title', 'INASSA - Authentification'); ?>


<div class="container-fluid vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3 col-lg-4 col-lg-offset-4">
                <div class="account-wall">
                    <div class="form-signin">
                        <?= $this->Html->image('logo_inassa.png', ['alt' => 'Logo de INASSA', 'class' => 'profile-img']); ?>
                        <?= $this->Form->create(); ?>
                            <?= $this->Form->input('username', array('class' => 'margin-10 form-control', 'label'=>false, "placeholder"=>"Nom d'utilisateur")) ?>
                            <?= $this->Form->input('password', array('type' => 'password', 'class' => 'margin-10 form-control', 'label'=>false,"placeholder"=>"Mot de passe")) ?>

                            <?= $this->Form->button('Connexion', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
                        <?= $this->Form->end(); ?>
                    </div>
                    <center>
                        <?= $this->Html->link('Mot de passe oublié?', ['controller' => 'users', 'action' => 'forgotpass'], ['class' => 'margin-top-20']); ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
if (isset($id_incorrect)){
    if ($id_incorrect == 1) {
    ?>
        <center><p class="text-danger" style="margin-top: 10px;">Nom d'utilisateur ou mot de passe incorrect.</p></center>
<?php 
    }else if($id_incorrect == 2){
?>
        <center><p class="text-danger" style="margin-top: 10px;">Compte inactif. Contactez la INASSA.</p></center>
<?php
    }else if($id_incorrect == 3){
?>
        <center>
            <p class="text-danger" style="margin-top: 10px;">
                Les serveurs sont temporairement indisponibles. Essayez à nouveau dans 5 minutes, si le problème persiste contactez la INASSA au 28127600.
            </p>
        </center>
<?php

    }
}?>

<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>