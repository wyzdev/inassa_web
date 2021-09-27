<?php


namespace App\Controller\api;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use phpDocumentor\Plugin\Scrybe\Converter\ToHtmlInterface;
use Cake\Error\Debugger;



class ClientsController extends AppController
{


	public function initialize()
    {
        $this->loadComponent('RequestHandler');
    }

    

 	public function sendresearchapi()
    {


        // $this->request->getParam('article_id');

        $data = $this->request->getData();
        $message = true;

        if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $message = false;


            $user = TableRegistry::get('Users')->get($data['user_id']);

            $confirmation_code = $this->getLastConfirmationCode();

            if ($confirmation_code < 1000)
                $confirmation_code = 1000;
            
         
             $html = '<!doctype html>
                        <html lang="fr">
                        
                            <body>

                                <div id="img_container">
                                       <img src="'. WWW_ROOT . DS .'/img/logo_inassa_mail.png" alt="" width="150"/>
                                </div>
                                
                                <div class="table_container">
                                    <table width="100%" class="header">
                                       <tr>
                                          <td><span class="card-libele">Code de recherche</span>: <strong>' . $code . '</strong></td>
                                          <td>Utilisateur: '.$user->first_name.' '.$user->last_name.' - '.$user->institution.' ('.$user->role.') </td>
                                      </tr>

                                   </table>
                                </div>
                                <div class="results_container"> 
                                        
                                        <table id="result">';
                                         $counter = 1;
        
                                              if($data['is_dependant']){
                                                  $dependance = 'Oui';
                                                  $as = '('.$data['primary_employee_id'].') '. $data['primary_name'];
                                              }else{
                                                  $dependance = 'Non';
                                                  $as = 'N/A';
                                              }
         
                                              if($client['status']){
                                                  $status = "actif";
                                              }else{
                                                  $status = "inactif";
                                              }
        
                                              $html .= '    <tr><td></td><td></td></tr>                                                  
                                                            <tr>
                                                                <li><td>Identification </td><td>: '.$data['employee_id'].'</td></li>

                                                            </tr>
                                                            <tr>
                                                                <li><td>Prénom </td><td>: '.$data['first_name'].'</td></li>
                                                            </tr>

                                                            <tr>
                                                                <li><td>Nom </td><td>: '.$data['last_name'].'</td></li>
                                                            </tr>
                                                            <tr>
                                                                <li><td>DOB (MM/JJ/AAAA) </td><td>: '.$data['dob'].'</td></li>
                                                            </tr>
                                                            <tr>
                                                                <li><td>Addresse </td><td>: '.$data['address'].'</td></li>
                                                            </tr>
                                                            <tr>
                                                                <li><td>Numéro de police hérité </td><td>: '.$data['legacy_policy_number'].'</td></li>
                                                            </tr>
                                                            <tr>
                                                                <li><td>Compagnie </td><td>: '.$data['company'].'</td></li>
                                                                </tr>
                                                            <tr>
                                                                <li><td>Dépendant </td><td>: '.$dependance.'</td></li>
                                                                </tr>
                                                            <tr>
                                                                <li><td>Assuré Principal </td><td>: '.$as.'</td></li>
                                                                </tr>
                                                            <tr>
                                                                <li><td>Hero </td><td>: '.$data['hero'].'</td></li>
                                                                </tr>
                                                            <tr>
                                                                <li><td>Statut </td><td>: '.$status.'</td></li>
                                                              </tr>
                                                              
                                                           ';
         
                $html .='       </table>
                                        <br/>
                                        <div id="date-container">
                                            '.date("Y-m-d H:i:s").'
                                        </div>
                            </div>
                            <style type="text/css">
                                        * {
                                             font-family: Verdana, Arial, sans-serif;
                                          }

                                     li{
                                        width: 100%;
                                        
                                     }   

                                     #result td{
                                        min-width: 40%;
                                    }

                                    #result tr td:nth-child(2){
                                        padding-left: 20px;
                                    }  

                                    #date-container{
                                        text-align: right;
                                    }

                                     
                                          
                                     .header{
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
                        </body>
                    </html>'; 
         
         

         $dompdf = new DOMPDF();
         $dompdf->load_html($html);
         $dompdf->render();
         $output = $dompdf->output();
         file_put_contents('search_log_pdf/recherche_'.$confirmation_code.'.pdf', $output);

         $to = 'Wyzdev';
         $subject = 'Recherche '.$code.' '.date('d-m-Y');
    //        $message = $this->messageToSend($username, $userpassword, $role);
         
        $mail = $this->Email->send("wyzdevsa@gmail.com", $subject, 'Inassa search result', WWW_ROOT . DS . 'search_log_pdf/recherche_'.$code.'.pdf');
        
         


         if($mail){
            $m = false;
         }else{
            $m = true;
         }
         // $this->set('mail',$mail);
      }

    }


}

?>