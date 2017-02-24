<?= $this->assign('title', 'INASSA - Authentification'); ?>


<div class="container-fluid vertical-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3 col-lg-4 col-lg-offset-4">
                <div class="account-wall">
                    <?php // $this->Html->image('img/logo_inassa', ['alt' => 'Logo de INASSA']); ?>
                    <img class="profile-img"  src="img/logo_inassa.png"
                        alt="">
                    <form class="form-signin" method = "post" action = "/inassa_web/accueil.php">
                    <input type="text" class=" margin-10 form-control" placeholder="Nom d'utilisateur">
                    <input type="password" class="margin-10 form-control" placeholder="Mot de passe">
                    <a href="accueil.php">
                        <button class="margin-top-20 btn btn-lg btn-primary btn-block" type="submit">
                        Connexion</button>
                    </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  