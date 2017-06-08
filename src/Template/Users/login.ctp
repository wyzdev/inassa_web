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
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($id_incorrect) {?>
<center><p class="text-danger" style="margin-top: 10px;">Nom d'utilisateur ou mot de passe incorrect</p></center>
<?php }?>

<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>