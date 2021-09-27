<?= $this->assign('title', 'INASSA - Accueil'); ?>

<?= $this->Html->css('Card') ?>
<?= $this->Html->css('gestion') ?>
<!-- <? /*= $this->Html->css('date-dropdown/styles')*/ ?> -->
<?= $this->Html->script('date-dropdown/date_dropdowns.min', ['block' => true]) ?>

<!doctype html>
                        <html lang="fr">
                            <head>
                                     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                                    <title>Aloha!</title>
                                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
                                   <style type="text/css">
                                        * {
                                             font-family: Verdana, Arial, sans-serif;
                                          }
                                          
                                     table{
                                            font-size: 1em;
                                            background: rgb(6, 93, 170);
                                            border-radius: 5px 5px 5px 5px;
                                            color: white;
                                            margin-top: 10px;
                                            margin-bottom: 10px;
                                            padding-left: 15px;
                                          }
                                     tfoot tr td{
                                           font-weight: bold;
                                           font-size: x-small;
                                         }
                                     .gray {
                                         background-color: lightgray;
                                      }
                                         
                                      
                                      tr{
                                         padding-left: 20px;
                                      }
                                      
                                      .results_container div{
                                         baground-color: rgb(255,255,255);
                                         margin-top: 10px;
                                      }
                                      
                                      .results_container{
                                         padding-left: 10px;
                                      }
                                      
                                      .img_container{
                                            width: 150px;
                                            height: 150px;
                                      }
                                      
                                      .img_container img{
                                        float: center;
                                      }
                                   </style>

                            </head>
                            <body>

                                <div id="img_container">
                                       <img src="<?=. WWW_ROOT . DS . ?>/img/logo_inassa_mail.png" alt="" width="150"/>
                                </div>
                                
                                <div class="table_container">
                                    <table width="100%">
                                       <tr>
                                          <td><span class="card-libele">Code de recherche</span>: <strong>' . $code . '</strong></td>
                                          <td>Utilisateur: '.$user->first_name.' '.$user->last_name.' - '.$user->institution.' ('.$user->role.') </td>
                                      </tr>

                                   </table>
                                </div>
                                <div class="results_container"> ';
                                        <? 
                             
                                             if($client['is_dependant']){
                                                  $dependance = 'Oui';
                                                  $as = '('.$client['primary_employee_id'].') '. $client['primary_name'];
                                              }else{
                                                  $dependance = 'Non';
                                                  $as = 'N/A';
                                              }
         
                                              if($client['status']){
                                                  $status = "actif";
                                              }else{
                                                  $status = "inactif";
                                              } 
                                           ?>
        
                                              <div class="result"> 
                                                 
                                                   <ul>
                                                      <li>Identification: <span class="text-right"><?= $client['employee_id'] ?></li>
                                                       <li>Prénom: <span class="text-right"><?= $client['firstname'] ?></li>
                                                       <li>Nom: <span class="text-right"><?= $client['lastname'] ?></li>
                                                       <li>DOB (MM/JJ/AAAA): <span class="text-right"><?= $client['dob'] ?></li>
                                                        <li>Addresse: <span class="text-right"><?= $client['address'] ?></li>
                                                       <li>Numéro de police hérité: <span class="text-right"><?= $client['legacy_number'] ?></li>
                                                        <li>Compagnie: <span class="text-right"><?= $client['company'] ?></li>
                                                         <li>Dépendant: <span class="text-right"><?= $dependance ?></li>
                                                        <li>Assuré Principal: <span class="text-right"><?= $as ?></li>
                                                        <li>Hero: <span class="text-right"><?= $client['hero_tag'] ?></li>
                                                        <li>Statut: <span class="text-right"><?= $status ?></li>
                                                    </ul>
                                                 </div>

                                 </div>
                        </body>
                    </html>