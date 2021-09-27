<?= $this->assign('title', 'INASSA - Détail'); ?>

<?= $this->Html->css('Card') ?>
<?= $this->Html->css('gestion') ?>
<!-- <? /*= $this->Html->css('date-dropdown/styles')*/ ?> -->
<?= $this->Html->script('date-dropdown/date_dropdowns.min', ['block' => true]) ?>


<!--Block contenant le formulaire pour la recherche d'un client -->
<?php

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
    


</div>

<?php 
    // debug($client);
    // die();
?>

<div class="client row" id="display_client">
    <div class="info_client container-fluid" style="">
        <div class="container">
            <div class="col-md-12 container container-info">
                <div class="btn-container">
                <?php 
                    if(isset($client)){

                        if($client->status){
                            $status = '<span class="status_active">Client Actif</span>';
                        }else{
                            $status = '<span class="status_inactive">Client inactif</span>';
                        }

                        if($client->is_dependant == 0){
                            $dependant = "NON";
                            $as = " ";
                            $display = "N/A";
                        }else{
                            $dependant = "OUI";
                            $as = $client->primary_name.' ('.$client->primary_employee_id.')';
                            $display = $as;
                        }


                        if($client->has_hero){
                            $hero = $client->hero_tag;
                        }else{
                            $hero = "NON";
                        }
                ?>


                 <form class="form-inline" role="form" method="post" accept-charset="utf-8"
                          action="sendresearch">

                    <div id="form_option">
                    <?= $this->Form->input("client_selected", 
                        ['type' => 'hidden', 'value' => json_encode($client)] ) ?>

                    <?= $this->Form->submit('Imprimer', array('label' => false, 'name' => 'print', 'id' => 'print_client' ,'class' => 'btn btn-primary', 'title' => '', 'alt' => 'Print', 'error' => false));?>


                    <?= $this->Form->submit('Envoyer par email', array('label' => false, 'id' => 'mail_client' ,'name' => 'mail', 'class' => 'btn btn-primary', 'title' => '', 'alt' => 'Mail', 'error' => false));?>

                    </div>
                </form>


                </div>
                <div id="info_to_print">
                    <h3 class="title_search margin-bottom-20">Recherche Active</h3>
                     <p class="info-container" id="display_client_info">
                        <!-- info client will be display here -->
                        <span class="indicatif">Client</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $client->lastname.' '.$client->firstname ?></span>
                        <br/>
                        <span class="indicatif">Identification</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $client->employee_id ?></span>
                         <br>
                        <span class="indicatif">Compagnie</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $client->company ?></span>
                        <br>
                        <span class="indicatif">Numéro de police hérité</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $client->legacy_number ?></span>
                        <br><span class="indicatif">Date de Naissance</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $client->dob ?></span>
                        <br>
                        <span class="indicatif">Hero</span>
                        <span class="deux-point">:</span>
                        <span class="result label label-danger"><?= $hero ?></span>
                        <br>
                        <span class="indicatif">Dépendant</span>
                        <span class="deux-point">:</span>
                        <span class="result"><?= $dependant.' '.$as  ?></span>
                        </p>
                        <div class="status-carte center-horizontal margin-bottom-20" id="display_client_status">
                        <!-- status will be displayed here -->
                            <?= $status ?>
                        </div>
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

        <?php 

            }else{






                    }
            ?>
        </div>


        <div id="print_content" style="display: none;">
        <div id="print_c">
            <div id="img_container">
                    <img src="<?= WWW_ROOT . DS .'/img/logo_inassa_mail.png' ?>" alt="" width="150"/>
            </div>
                                
                <div class="table_container">
                    <table width="100%" class="header">
                        <tr>
                            <td><span class="card-libele">Code de recherche</span>: <strong id="code_container"><?= $code ?></strong></td>
                                          <td>Utilisateur: <?= $user->first_name.' '.$user->last_name.' - '.$user->institution.' ('.$user->role.')' ?> </td>
                            </tr>
                            <br/>
                        </table>
                                </div>
                                <div class="results_container"> 
                                        
                                        <table id="result">
                                            <tr><td></td><td></td></tr>                                                  
                                                            <tr>
                                                                <td><li>Identification</li></td><td>: <?= $client->employee_id?></td>

                                                            </tr>
                                                            <tr>
                                                                <td><li>Prénom</li></td><td>: <?= $client->firstname ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td><li>Nom</li></td><td>: <?= $client->lastname ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>DOB (MM/JJ/AAAA)</li></td><td>: <?= $client->dob ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>Addresse</li></td><td>: <?= $client->address ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>Numéro de police hérité</li></td><td>: <?= $client->policy_number?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>Compagnie</li></td><td>: <?= $client->company ?></td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Dépendant</li></td><td>: <?= $dependant ?></td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Assuré Principal</li></td><td>: <?= $display ?></td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Hero</li></td><td>: <?= $client->firstname ?></td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Statut</li></td><td>: <?= $status ?></td>
                                                                </tr>
                                                              
                                                           
                             </table>
                                        <br/>
                                        <div id="date-container">
                                            <?= date("d/m/Y g:i a") ?>
                                        </div>
                            </div>
                            <style id="pdf_style" type="text/css">
                                        #print_c * {
                                             font-family: Verdana, Arial, sans-serif;
                                          }

                                     #print_c li{
                                        width: 100%;
                                        
                                     }   

                                     #print_c #result td{
                                        min-width: 40%;
                                    }

                                    #print_c #result tr td:nth-child(2){
                                        padding-left: 20px;
                                    }  

                                   #print_c #date-container{
                                        text-align: right;
                                    }

                                     
                                          
                                    #print_c .header{
                                            font-size: 1em;
                                            background: rgb(6, 93, 170);
                                            border-radius: 5px 5px 5px 5px;
                                            color: white;
                                            margin-top: 10px;
                                            margin-bottom: 10px;
                                            padding-left: 15px;
                                          }

                                     #print_c tfoot tr td{
                                           font-weight: bold;
                                           font-size: x-small;
                                         }
                                     #print_c .gray {
                                         background-color: lightgray;
                                      }
                                         
                                      
                                     #print_c  tr{
                                         padding-left: 20px;
                                      }
                                      
                                     #print_c .results_container div{
                                         baground-color: rgb(255,255,255);
                                         margin-top: 10px;
                                      }
                                      
                                     #print_c .results_container{
                                         padding-left: 10px;
                                      }
                                      
                                     #print_c .img_container{
                                            width: 150px;
                                            height: 150px;
                                      }
                                      
                                      #print_c .img_container img{
                                        float: center;
                                      }
                                   </style>
                        </body>
                    </html>

        </div>
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

                .btn-container input{
                    margin-left: 20px;
                }

                form{
                    width: 100%;
                }

                #form_option{
                    margin-top: 3px;
                    display: flex;
                    position: relative;
                    right: 2px;
                    float: right;
                }

                #form_option input{
                    margin-right: 5px;
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