<?= $this->assign('title', 'INASSA - Accueil'); ?>

<?= $this->Html->css('Card') ?>
<?= $this->Html->css('gestion') ?>
<!-- <? /*= $this->Html->css('date-dropdown/styles')*/ ?> -->
<?= $this->Html->script('date-dropdown/date_dropdowns.min', ['block' => true]) ?>


<!--Block contenant le formulaire pour la recherche d'un client -->
<?php
 var_dump(date('Y-m-d H:i:s'));
 die();
$dob_input = (isset($client_dob)) ? $client_dob : '';
?>

<span id="user_id" data-user-id="<?= $this->request->session()->read('Auth.User')['id'] ?>"></span>
<div class="container" style="margin-top: 15px">
    <div class="row">
        <div id="" class="">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="gestion">
                        <div class="form-group col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <?= $this->Form->input("last_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "NOM")) ?>
                        </div><!--
                        <div class="form-group col-md-2 col-md-offset-0 col-xs-10 col-xs-offset-1">
                            <?/*= $this->Form->input("middle_name", array("class" => "form-control margin-10", "label" => false, "placeholder" => "Middle name")) */?>
                        </div>-->
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

    // debug($clients);
    // die();

    if (isset($clients)) {
        if (sizeof($clients) > 0) {
            ?>
            <h5 style = 'margin-left:-15px;text-decoration:underline;'>Résultat Recherche Client - <?= date('d-m-Y H:i:s') ?></h5>
            <div class="row" id="table_client">
                   
                <!-- Table -->
                
                <table class="col-md-12 table table-striped table-hover table-condensed" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Identification</th>
                        <th class='text-center'>Prénom</th>
                        <th class='text-center'>Nom</th>
                        <th class='text-center'>DOB (JJ/M/AAAA)</th>
                        <th class='text-center'>addresse</th>
                        <th class='text-center'>Numéro de police hérité</th>
                        <th class='text-center'>Compagnie</th>
                        <th class='text-center'>Dépendant</th>
                        <th class = 'text-center'>Assuré Principal</th>
                        <th class='text-center'>Hero</th>
                        <th class='text-center'>Statut</th>
                        <th class='text-center'>action</th>
                    </tr>
                    </thead>

                    
                    <tbody>
                    <?php
                    foreach ($clients as $key => $client) {
                        ?>
                        <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="view">

                        <?php
                        if ($client['status'] == true)
                            $className = '';
                        else
                            $className = 'backgroundRed'; ?>                            
                        <tr class="client_row <?= $className ?>" employeeid="<?= $client['employee_id'] ?>" firstname="<?= $client['firstname'] ?>" primary_name = "<?= $client['primary_name'] ?>" primary_employee_id  = "<?= $client['primary_employee_id'] ?>" key="<?= $key ?>"
                            user_fullname="<?= $this->request->session()->read('Auth.User')['first_name'] . ' ' .$this->request->session()->read('Auth.User')['last_name'] ?>"
                            user_institution="<?= $this->request->session()->read('Auth.User')['institution'] ?>"
                            lastname="<?= $client['lastname'] ?>" status="<?= $client['status'] ?>" company = "<?= $client['company'] ?>" legacy_number = "<?= $client['legacy_number'] ?>" hero = "<?= $client['hero_tag'] ?>"
                            dob="<?= date("d/m/Y", strtotime($client['dob'])) ?>" dob_search="<?= $client_search_dob ?>"
                            style="cursor: pointer; width: 40px;">

                        

                        <?= $this->Form->input("user_fullname", 
                        ['type' => 'hidden', 'value' => $this->request->session()->read('Auth.User')['first_name'] . ' ' .$this->request->session()->read('Auth.User')['last_name']] ) ?>

                        <?= $this->Form->input("user_institution", 
                        ['type' => 'hidden', 'value' => $this->request->session()->read('Auth.User')['institution']]) ?>

                        <?= $this->Form->input("client_selected", 
                        ['type' => 'hidden', 'value' => json_encode($client)] ) ?>


                            <td><?= $client['employee_id'] ?></td>
                            <td class='text-center'><?= $client['firstname'] ?></td>
                            <td class='text-center'><?= $client['lastname'] ?></td>
       
                            <td class = 'text-center'> <?= date("d/m/Y", strtotime($client['dob'])) ?></td>
                            <td class='text-center'><?= $client['address'] ?></td>
                            <td class='text-center'><?= $client['legacy_number'] ?></td>
                            <td class='text-center'><?= $client['company'] ?></td>
                            <?php if($client['employee_id'] != $client['primary_employee_id']): ?>
                                <td class = 'text-center'>OUI</td>
                                <td class = 'text-center'><?= $client['primary_employee_id'] . " : " . $client['primary_name']  ?></td>
                            <?php   else : ?>
                                <td class = 'text-center'>NON</td>
                                <td class = 'text-center'>-</td>
                            <?php   endif; ?>
                            <?php if($client['has_hero']) : ?>
                                <td class='text-center'><span class = "label label-danger"><?= $client['hero_tag'] ?></span></td>
                            <?php else : ?>
                                <td class='text-center'>N/A</td>
                            <?php endif; ?>
                            <td>
                                <?php
                        if ($client['status'] == true)
                            echo "<span class = 'label label-success'>Actif</span>";
                        else
                            echo "Inactif"; ?></td>

                            <td>
                            

                            <?= $this->Form->submit('Voir', array('label' => false, 'name' => 'submit', 'class' => 'btn btn-primary', 'title' => '', 'alt' => 'Voir', 'error' => false));?>
                            </td>
            
                            </form>
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
                        <div class="col-md-12 container-info" style = 'padding:0px'>
                            <div class="status-carte center-horizontal">
                                <?php if($errorMessage != false) : ?>
                                        <p class="bg-danger"><?= $errorMessage ?></p>
                    <?php else : ?>
                        <p class="bg-danger"><?= $errorMessage ?></p>
                    <?php endif; ?>
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
                <div class="btn-container">
                    <div class="Btn">
                        <?= $this->Html->link(
                                    __('<i class="fa fa-print print_result" style="color: rgba(23, 27, 124, .9);"></i>'),
                                    [
                                        'controller' => 'clients',
                                        'action' => 'sendresearch'
                                    ],
                                    [
                                        'escape' => false,
                                        'title' => 'Imprimer'
                                    ]) ?>
                    </div>
                    <div class="Btn">

                        <?= $this->Html->link(
                                    __('<i class="fa fa-envelope mail_result" style="color: rgba(23, 27, 124, .9);"></i>'),
                                    [
                                        'controller' => 'clients',
                                        'action' => 'sendresearch',
                                        json_encode($clients),
                                        json_encode($this->request->session()->read('Auth.User'))
                                    ],
                                    [
                                        'escape' => false,
                                        'title' => 'Envoye par email'
                                    ]) ?>
                    </div>


                    <div>
                        <!-- <i class="fa fa-print print_result" id="print_client"  style="color: rgba(23, 27, 124, .9);"></i> -->

                    </div>
                    <div>
                        <!-- <i class="fa fa-envelope mail_result" id="mail_client" style="color: rgba(23, 27, 124, .9);">/i> -->
                    </div>


                </div>
                
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

        <style>
                .print_result, .mail_result {
                    font-size: 2em;
                    margin-right: 10px;
                }

                .btn-container{
                    display: flex;
                    flex-direction: row;
                }

                .key{
                    display: none;
                }
        </style>

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