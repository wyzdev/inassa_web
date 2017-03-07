<h2>Example of creating Modals with Twitter Bootstrap</h2>

<!-- Button trigger modal -->
<button class = "btn btn-primary btn-lg" data-toggle = "modal" data-target = "#myModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class = "modal fade" id = "myModal" tabindex = "-1" role = "dialog"
     aria-labelledby = "myModalLabel" aria-hidden = "true">

    <div class = "modal-dialog  modal-sm">
        <div class = "modal-content">


            <div class = "modal-header">
                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">
                    &times;
                </button>

                <h4 class = "modal-title" id = "myModalLabel">
                    Choisissez un nouveau mot de passe
                </h4>
            </div>

            <div class = "modal-body">

                <?= $this->Form->create(null ,
                    [
                        'url' =>
                            [
                                'controller' => 'users',
                                'action' => 'modifier'
                            ]
                    ]) ?>
                <?= $this->Form->input('password',
                    array('type' => 'password',
                        'class' => 'margin-10 form-control col-md-4',
                        'label' => false,
                        "placeholder" => "Nouveau mot de passe",

                    )) ?>

                <?= $this->Form->input('password',
                    array(
                        'type' => 'password',
                        'class' => 'margin-10 form-control',
                        'label'=>false,
                        "placeholder"=>"Confirmer le mot de passe"
                    )) ?>
                <?= $this->Form->button('Enregistrer', ['class' => 'margin-top-20 btn btn-lg btn-primary btn-block']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->