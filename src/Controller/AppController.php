<?php

/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\RequestHandlerComponent;
use Cake\ORM\TableRegistry;
use JMS\Serializer\Tests\Fixtures\Tag;
use Cake\Error\Debugger;

use Dompdf\Dompdf;

/**
 * Application Controller
 */
class AppController extends Controller
{
    protected $secureActions = array(
        'login',
        '',
        ''
    );
    /**
     * Constants that used to check the requests of the android application
     * @var string
     */
    public $TOKEN = "1E:DF:D8:32:09:92:72:AF:FA:32:12:71:D6:B5:E4:70:DB:F2:7F:48";

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'users',
                'action' => 'login'
            ],
            'authError' => 'Votre session a expiré. Vous devez vous authentifier à nouveau.'
        ]);
    }

    public function forceSSL()
    {
        return $this->redirect('https://' . env('SERVER_NAME') . $this->request->here);
    }

    /**
     * Function that allows to make some action before the render of the web application.
     * @param Event $event
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Function that allows some action to execute without the user's authentication.
     * @param Event $event
     *
     */
    public function beforeFilter(Event $event)
    {
        if (in_array($this->request->action, $this->secureActions)
            && !isset($_SERVER['HTTPS'])) {
            //$this->forceSSL();
        }

        $this->Auth->allow(['add', 'requestUser', 'forgotPassword', 'changePasswordMedecin', 'search', 'forgotpass',
            'checkcanlogin', 'login', 'logout', 'searchclientandroid', 'sendresearchapi', 'testsend', 'deconnexion']);
        $this->Auth->authError = __('Vous devez vous connecter pour pouvoir accéder à cette fonctionnalité.');
        // $this->Auth->loginError = __('Invalid Username or Password entered, please try again.');
    }

    /**
     * Function that writes in log files.
     *
     * @param $user
     * @param $role
     * @param $from
     * @param $action
     * @param $client
     */
    public function writeinlogs($user, $role, $from, $action, $client)
    {
        date_default_timezone_set('America/New_York');
        $date = date('d/m/Y h:i:s a', time());

        // save in current log
        $file = 'inassa.log';
        $oldContents = file_get_contents($file);

        $handle = fopen($file, 'w') or die('Cannot open file:  ' . $file);
        $data = '[<b>' . $date . '</b>] ' . $user . ' ' . '(' . $role . ')' . ' de ' . $from . ' ' . $action . ' ' . $client;

        $newmsg = $data . $oldContents;
        fwrite($handle, $newmsg); // write a line in the file
        fclose($handle);

        // save in daily log
        $my_file = "Logs/" . date("Y_m_d") . '.log';
        $handle = fopen($my_file, 'a+') or die('Cannot open file:  ' . $my_file);

        $data = '[<b>' . $date . '</b>] ' . $user . ' ' . '(' . $role . ')' . ' de ' . $from . ' ' . $action . ' ' . $client;
        fwrite($handle, $data); // write a line in the file
        fclose($handle);
    }

    public function manuel()
    {

    }

    public function saveInMiddlewareLogs($message, $user_id)
    {
        // get middleware logs model
        $middleware_logs_model = TableRegistry::get('MiddlewareLogs');

        // get the current date time
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d h:i:s', time());

        // new entity
        $middleware_log = $middleware_logs_model->newEntity();

        // patch entity
        $middleware_log = $middleware_logs_model->patchEntity($middleware_log, [
            'date' => $date,
            'user_id' => $user_id,
            'message' => $message
        ]);

        // save the middleware log
        if ($middleware_logs_model->save($middleware_log))
            return $this->redirect(['controller' => 'Clients', 'action' => 'gestion']);
    }

    public function testApi($user_id)
    {
        // get user
        $user = TableRegistry::get('Users')->get($user_id);

        $result_test_auth = $this->testAuthApi($user);
        if (!$result_test_auth['success'])
            return false;
        else
            if (!$this->testSearch($result_test_auth['key'], $user))
                return false;


        $this->setLockDown(false);
        return true;
    }

    public function testSearch($key, $user)
    {

        $curl_host = curl_init();

        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.83:8180/RequestQuote/epic_mwClientSearch");
        //curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8080/RequestQuote/epic_mwClientSearch");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);

        curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $key . '"},"first_name":"sebastien","last_name":"merove-pierre","dob":"9/18/1988"}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        $result = curl_exec($curl_host);


        if (empty($result)) {
            $this->Flash->error("Les serveurs sont temporairement indisponibles. Essayez à nouveau dans 5 minutes et si le problème persiste, contactez la INASSA au 28127600.");
            $error_message = "{\"error\":true,\"message\":\"Login failed\",\"api_response\":\"Cannot communicate with the server\"}";
            $this->request->session()->write('api_response', $error_message);

            $this->saveInMiddlewareLogsAndSendEmail($error_message,
                $user->id);
            $this->setLockDown(true);

            return false;
        }

        if (json_decode($result)->success)
            return true;

        $this->saveInMiddlewareLogsAndSendEmail($result, $user->id);
        $this->setLockDown(true);
        $this->Flash->error("Les serveurs sont temporairement indisponibles. Essayez à nouveau dans 5 minutes et si le problème persiste, contactez la INASSA au 28127600.");

        return false;

        //return false;
    }

    public function testAuthApi($user)
    {

        // init curl
        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.83:8180/RequestQuote/RequestLogin");
        //curl_setopt($curl_host, CURLOPT_URL, "192.168.5.8:8080/RequestQuote/RequestLogin");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/RequestLogin");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);

        curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"Login":{"username":"wyzdev@nassagroup.com","password":"W1Yz$54@8jha$1"}}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        //result from the API of INASSA
        $result = curl_exec($curl_host);

        if (empty($result)) {
            $this->Flash->error("Les serveurs sont temporairement indisponibles. Essayez à nouveau dans 5 minutes et si le problème persiste, contactez la INASSA au 28127600.");
            $error_message = "{\"error\":true,\"message\":\"Login failed\",\"api_response\":\"Cannot communicate with the server\"}";
            $this->request->session()->write('api_response', $error_message);

            $this->saveInMiddlewareLogsAndSendEmail($error_message,
                $user->id);
            $this->setLockDown(true);

            return ['key' => '', 'success' => false];
        }

        if (json_decode($result)[0]->Response[0]->success) {
            return ['key' => json_decode($result)[0]->Response[0]->key, 'success' => json_decode($result)[0]->Response[0]->success];
        }

        $this->Flash->error("Les serveurs sont temporairement indisponibles. Essayez à nouveau dans 5 minutes et si le problème persiste, contactez la INASSA au 28127600.");
        $this->saveInMiddlewareLogsAndSendEmail(json_encode(json_decode($result)[0]->Response), $user->id);
        $this->setLockDown(true);

        return ['key' => '', 'success' => false];
    }

    public function saveInMiddlewareLogsAndSendEmail($error, $user_id)
    {
        $this->saveInMiddlewareLogs($error, $user_id);
        $this->sendresponseapi();
        $this->request->session()->write('api_response', $error);
    }

    public function getLockDown()
    {
        return !$this->canLogin();
    }

    public function setLockDown($b)
    {
        $this->setCanLogin(!$b);
    }

    public function canLogin()
    {
        // test_logins model
        $test_logins_model = TableRegistry::get('TestLogins');

        //check if doctor can login
        $can_login = $test_logins_model->find()->first();

        return $can_login->canLogin;

    }

    public function setCanLogin($b)
    {
        // test_logins model
        $test_logins_model = TableRegistry::get('TestLogins');

        $test_login_count = $test_logins_model->find()->count();


        if ($test_login_count > 0) {
            // get the login
            $test_login = $test_logins_model->find()->first();
        } else {
            $test_login = $test_logins_model->newEntity();
        }

        $test_login->canLogin = $b;

        $test_logins_model->save($test_login);
    }


    private function getAdminAddresses()
    {
        return [
            'wyzdevsa@gmail.com',
            'emmanuel.noel@wyzdev.net'
        ];
    }

    private function sendresponseapi()
    {
        $mail_addresses = $this->getAdminAddresses();

        $mails = '';
        foreach ($mail_addresses as $key => $mail_address):
            $mails .= $mail_address . ' - ';
            $this->sendEmailWithApiResponse($mail_address);
        endforeach;

//        $this->Flash->success('E-mail envoyé à : ' . $mails);
        //$this->Flash->success('E-mail envoyé à : info@nassagroup.com');
        /*return $this->redirect(
            [
                'action' => 'gestion'
            ]
        );*/
    }

    private function sendEmailWithApiResponse($mai_address)
    {
        $firstname = '';
        $lastname = '';
        if (!empty($this->request->session()->read('user_id')) and
            $this->request->session()->read('user_id') != null) {
            $user = TableRegistry::get('Users')->get($this->request->session()->read('user_id'));
            $firstname = $user->first_name;
            $lastname = $user->last_name;
        }

        $to = $mai_address;
        $subject = 'Reponse de l\'API';
        $message = 'Test effectué par : '
            . $firstname . ' ' . $lastname . '<br />' .
            'Test API échoué le ' . date('d/m/Y') . ' à ' . date('H:i') . '<br /><br />
        Le message d\'erreur est : <br />' . $this->getApiResponse();
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail', $mail);
        $this->viewBuilder()->setLayout(false);
        $this->render(false);
    }

    private function getApiResponse()
    {
        $response = json_decode($this->request->session()->read('api_response'));
        return $response->api_response;
    }


    /**
     *
     * Function that logs the user out.
     *
     * @return mixed
     */
    public
    function logout()
    {
        ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
        $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
            . ' ' .
            $this->request->session()->read('Auth.User')['last_name'],
            $this->request->session()->read('Auth.User')['role'],
            $this->request->session()->read('Auth.User')['institution'],
            " s'est déconnecté ",
            "" . "\n");
        return $this->redirect($this->Auth->logout());
    }

    // auto logout
    public function autoLogout()
    {
        $can = ($this->canLogin() == 1) ? true : false;
        if (!$can) {
            if ($this->request->session()->read('Auth.User')['role'] == 'medecin') {
                $this->logout();
            }
        }
    }

    public function saveInAdminLog($firstname, $lastname, $role, $institution, $action, $client)
    {
        ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
        $this->writeinlogs($firstname
            . ' ' .
            $lastname,
            $role,
            $institution,
            " " . $action . "  ",
            $client . "\n");
    }

    public function saveHistorics($array_post, $confirmation_code, $user)
    {


        $var = $array_post['dob'];
        $date = str_replace('/', '-', $var);


        $array_date = explode("-", $date);
        $day = $array_date[1];
        $month = $array_date[0];
        $year = $array_date[2];

        $date = $day . '-' . $month . '-' . $year;

        $new_dob = date('Y-m-d', strtotime($date));

        // Table that we are going to use "Logs"
        $logs_model = TableRegistry::get("Logs");

        $log = $logs_model->newEntity();
        $log = $logs_model->patchEntity($log, $array_post);

        $log->dob = $new_dob;
        if ($array_post["primary_employee_id"] == $array_post["employee_id"]) {
            $log->is_dependant = 0;

        } else {
            $log->is_dependant = 1;
            $log->primary_name = $array_post["primary_employee_id"] . " - " . $array_post["primary_name"];
        }


        $log->confirmation_code = intval($confirmation_code);

        $log->user_id = $array_post['user_id'];
        $log_saved = $logs_model->save($log);
        if ($log_saved) {

////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
            $this->writeinlogs(
                $user->first_name . ' ' . $user->last_name,
                $user->role,
                $user->institution,
                "a recherché le client",
                strtoupper($log_saved->first_name) . ' ' . strtoupper($log_saved->last_name)
                . ' ' . $log_saved->dob . "\n");
        }
    }

    public function getLastConfirmationCode()
    {
        return TableRegistry::get('Logs')->find()
            ->select(
                [
                    'confirmation_code' => 'MAX(Logs.confirmation_code)'
                ])->first()->confirmation_code;
    }
    
    
     public function sendResearchAsPDF($clients, $user, $code, $print = false)
    {

         
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

                                         $client = $clients[0];

                                         $client = (array) $client;
                                         
                                         // foreach ($clients as $client):
        
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
        
                                              $html .= '    <tr><td></td><td></td></tr>                                                  
                                                            <tr>
                                                                <td><li>Identification</li></td><td>: '.$client['employee_id'].'</td>

                                                            </tr>
                                                            <tr>
                                                                <td><li>Prénom</li></td><td>: '.$client['firstname'].'</td>
                                                            </tr>

                                                            <tr>
                                                                <td><li>Nom</li></td><td>: '.$client['lastname'].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>DOB (MM/JJ/AAAA)</li></td><td>: '.$client['dob'].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>Addresse</li></td><td>: '.$client['address'].'</td>
                                                            </tr>
                                                            <tr>
                                                                 <td><li>Numéro de police hérité</li></td><td>: '.$client['legacy_number'].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td><li>Compagnie</li></td><td>: '.$client['company'].'</td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Dépendant</li></td><td>: '.$dependance.'</td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Assuré Principal</li></td><td>: '.$as.'</td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Hero</li></td><td>: '.$client['hero_tag'].'</td>
                                                                </tr>
                                                            <tr>
                                                                <td><li>Statut</li></td><td>: '.$status.'</td>
                                                                </tr>
                                                              
                                                           ';
        
                                         // endforeach;
         
                $html .='       </table>
                                        <br/>
                                        <div id="date-container">
                                            '.date("d/m/Y g:i a").'
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
         file_put_contents('search_log_pdf/recherche_'.$code.'.pdf', $output);

         $to = 'Wyzdev';
         $subject = 'Recherche '.$code.' '.date('d-m-Y');
    //        $message = $this->messageToSend($username, $userpassword, $role);
         // $admin_array_pdf = $this->getAdminAddressesPDF();

         
        $mail = $this->Email->send('wyzdevsa@gmail.com', $subject, 'Inassa search result', WWW_ROOT . DS . 'search_log_pdf/recherche_'.$code.'.pdf');

        $mail = $this->Email->send('info@nassagroup.com', $subject, 'Inassa search result', WWW_ROOT . DS . 'search_log_pdf/recherche_'.$code.'.pdf');

        // $mail = $this->Email->send('mealtidor@nassagroup.com', $subject, 'Inassa search result', WWW_ROOT . DS . 'search_log_pdf/recherche_'.$code.'.pdf');
        if(!$print){
            $mail = $this->Email->send($user->email, $subject, 'Inassa search result', WWW_ROOT . DS . 'search_log_pdf/recherche_'.$code.'.pdf');
        }
        
         
         // debug($mail);
         // die();

         $this->set('mail',$mail);

    }

    public function getAdminAddressesPDF(){
        return [
            'wyzdevsa@gmail.com',
            // 'hollynderisse93@gmail.com',
            'emmanuel.noel@wyzdev.net'
            //'wsanon@nassagroup.com',
            //'mealtidor@nassagroup.com'
        ];
    }

}
