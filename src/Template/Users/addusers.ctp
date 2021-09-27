<?= $this->assign('title', 'INASSA - Paramètres'); ?>

<?= $this->Html->css('add_user'); ?>
<?= $this->Html->css('login_form'); ?>


<div class="container-fluid">
    <div class="row">
        <div class=" col-lg-4 col-lg-offset-0 col-md-4 col-md-offset-0 col-sm-8 col-sm-offset-2 vertical-center">
            <div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1">
                <div class="account-wall">
                    <h3 class="center">Ajouter un nouvel utilisateur</h3>
                    <div class="form-signin">
                        <?= $this->Form->create($user); ?>
                        <?= $this->Form->input('last_name', array('class' => 'form-control margin-10', 'label'=>false,"placeholder"=>"NOM")) ?>
                        <?= $this->Form->input('first_name', array('class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"Prénom")) ?>
                        <?= $this->Form->input('username', array('class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"Nom d'utilisateur")) ?>
                        <?= $this->Form->input('email', array('type' => 'email', 'class' => 'form-control margin-10', 'label'=>false, "placeholder"=>"E-mail")) ?>

                        <?= $this->Form->select('role', ['medecin' => 'Médecin', 'admin' => 'Admin', 'user' => 'Simple utilisateur'], ['empty' => true, 'class' => 'form-control', 'id' => 'role', 'default'=>'']) ?>
                        <?= $this->Form->input('institution', array('class' => 'form-control margin-10', 'label' => false, "placeholder" => "Hopital", "id" => "hospital_field")) ?>
                        <?= $this->Form->button('Enregistrer', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 table-responsive" style="margin-top: 30px">
            <table id="example" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>E-mail</th>
                    <th>Nom d'utilisateur</th>
                    <th>Établissement</th>
                    <th>Accès</th>
                    <th>Status</th>
                    <th>Réinitialiser</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nom complet</th>
                    <th>E-mail</th>
                    <th>Nom d'utilisateur</th>
                    <th>Établissement</th>
                    <th>Accès</th>
                    <th>Status</th>
                    <th>Réinitialiser</th>
                </tr>
                </tfoot>
                <tbody>

                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user->first_name .' '. $user->last_name?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->username ?></td>
                            <td><?= $user->institution ?></td>
                            <td>
                                <?php
                                    if ($user->role == 'admin')
                                        $checked_admin = true;
                                    else
                                        $checked_admin = false;
                                    if ($user->status)
                                        $checked_status = true;
                                    else
                                        $checked_status = false;
                                ?>
                                <?php if ($user->role == 'admin' or $user->role == 'user'){
                                    ?>
                                    <?= $this->Form->create() ?>
                                        <?= $this->Form->input('admin',
                                            [
                                                'type' => 'checkbox',
                                                'label' => ' Admin',
                                                'id' => 'admin'.$user->id,
                                                'num' => $user->id,
                                                'name' => 'admin',
                                                'value' => 'value-admin',
                                                'checked' => $checked_admin,
                                                'class' => 'access',
                                                'firstname' => $user->first_name,
                                                'lastname' => $user->last_name
                                            ]); ?>
                                    <?= $this->Form->end() ?>
                                <?php }else
                                    echo 'Médecin'
                                        ?>
                            </td>
                            <td>
                                <?= $this->Form->create() ?>
                                    <?= $this->Form->input('actif',
                                        [
                                            'type' => 'checkbox',
                                            'label' => ' Actif',
                                            'id' => 'actif'.$user->id,
                                            'num' => $user->id,
                                            'name' => 'actif',
                                            'value' => 'value-actif',
                                            'checked' => $checked_status,
                                            'class' => 'status',
                                            'firstname' => $user->first_name,
                                            'lastname' => $user->last_name
                                        ]); ?>
                                <?= $this->Form->end() ?>
                            </td>
                            <td style="padding-top: 6px; padding-left: 40px;">
                                <?= '<a href="#myModal" data-toggle="modal" style="cursor: pointer;" class="reset" firstname="'.$user->first_name.'" lastname="'.$user->last_name.'" '.'num="'.$user->id.'">' ?><span class="glyphicon glyphicon-retweet dark" style="color: red;"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Confirmation</h3>
            </div>
            <div class="modal-body" id="reset-user_modal-body">

            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                <button type="button" class="btn btn-warning confirmation_reset" data-dismiss="modal">OUI</button>
            </div>
        </div>
    </div>
</div>
<!--//////////////////////////////// DIALOG MESSAGE //////////////////////////////////////////////////-->
<div id="dialog-message" title="Changement">

</div>



<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; top:0px; left: 0px; right: 0px; bottom: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>

<!--/////////////////////////////// LOADER 2 /////////////////////////////////////////-->
<div id="content_loader2" style="display: none;background: rgba(0,0,0,0.2);; top:0px; left: 0px; right: 0px; bottom: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>