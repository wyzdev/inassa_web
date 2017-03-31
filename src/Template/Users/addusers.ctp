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

                        <?= $this->Form->select('access', ['medecin' => 'Medecin', 'admin' => 'Admin', 'user' => 'Simple utilisateur'], ['empty' => true, 'class' => 'form-control', 'id' => 'role']) ?>
                        <?= $this->Form->input('hopital', array('class' => 'form-control margin-10', 'label' => false, "placeholder" => "Hopital", "id" => "hospital_field")) ?>
                        <?= $this->Form->button('Enregistrer', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 table-responsive">
            <table id="example" class="table table-striped table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Accès</th>
                    <th>Status</th>
                    <th>Réinitialiser</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Accès</th>
                    <th>Status</th>
                    <th>Réinitialiser</th>
                </tr>
                </tfoot>
                <tbody>

                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= h($user->last_name) ?></td>
                            <td><?= h($user->first_name) ?></td>
                            <td><?= h($user->username) ?></td>
                            <td>
                                <?php
                                    if (h($user->access))
                                        $checked_admin = true;
                                    else
                                        $checked_admin = false;
                                    if (h($user->status))
                                        $checked_status = true;
                                    else
                                        $checked_status = false;
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
                                            'class' => 'access'
                                        ]); ?>
                                <?= $this->Form->end() ?>
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
                                            'class' => 'status'
                                        ]); ?>
                                <?= $this->Form->end() ?>
                            </td>
                            <td>
                                <?= '<a style="cursor: pointer;" class="reset" firstname="'.$user->first_name.'" lastname="'.$user->last_name.'" '.'num="'.$user->id.'">' ?><span class="glyphicon glyphicon-retweet dark" style="color: red; margin-left: 30px;"></span></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>