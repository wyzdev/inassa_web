<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use phpDocumentor\Plugin\Scrybe\Converter\ToHtmlInterface;
use Cake\Error\Debugger;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{
    public $components = array('Email');
    private $API_RESPONSE = '';

    private $key;

    /**
     * Function that allows the user to search client.
     */


    public function searchclientandroid()
    {
        $data = $this->request->getData();
        
          $clients = [];

          $message = true;
          if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $message = false;
            $clients = $this->searchClient($data);
            if ($clients == null){
                $clients = [];
            }
          }

          $this->set([
            'error' => $message,
            'clients' => $clients
          ]);
        
        
    }

    private function searchClient($data)
    {
        $firstname = trim($data['first_name']);
        $lastname = trim($data['last_name']);
        $dob = trim($data['dob']);


		//var_dump($dob);
		//die();
        //get user
        $user = TableRegistry::get('Users')->get($data['user_id']);

        $error = false;

        $this->saveInAdminLog(
            $user->first_name,
            "START SEARCH",
            date('Y-m-d H:i:s'),
            $user->institution,
            "TEST",
            $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');

       // if (!$this->testapi($data['user_id'])) {
      //          $this->set('errorMessage', 'Problème de communication à l\'API.');
      //          $this->set('error', true);
      //          return;
      //  }

        // decode the result in JSON
        $response = json_decode($this->getClient($firstname, $lastname, $dob));


        $this->saveInAdminLog(
            $user->first_name,
            "API RESPONSE",
            date('Y-m-d H:i:s'),
            $user->institution,
            "TEST",
            $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
        // var_dump($response);
        // var_dump(isset($response[0]));

        if (is_object($response)) {
            if (!$response->success) {
                if (!empty($response->Info)) {
                    $error = 'Impossible de se connecter au serveur de données.';
                } elseif (!empty($response->Details)) {
                    $error = 'Problème de communication à l\'API.';
                } elseif (empty($response->clients)) {
                    $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                    $error = 'Aucun client ne correspond à vos critères de recherche.';
                } else {
                    $error = 'Erreur inconnue - Appelez le support technique.';
                }
            } else {
                if (empty($response->clients)) {
                    $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                    $error = 'Aucun client ne correspond à vos critères de recherche.';
                } else {
                    $response->clients = $this->getClientBenefits($response->clients);
                }
            }
        } else {
            if ($response[0]->Response[0]->success == false) {
                $error = "Erreur d'authentification à l'API";
            } else {
                if (empty($response[0]->Response[0]->clients)) {
                    $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                    $error = 'Aucun client ne correspond à vos critères de recherche.';
                }
            }
        }

        $this->set('errorMessage', $error);

        if ($response->success and !empty($response->clients)) {
            $response_firstname = $response->clients[0]->first_name;
            $response_employeeID = $response->clients[0]->employee_id;
            $response_lastname = $response->clients[0]->last_name;
            $response_status = $response->clients[0]->status;
            $response_dob = $response->clients[0]->dob;
            $response_success = $response->success;

            $array_response = (array)$response->clients;
            $array_clients = array(array());

            $obj_array = array();
            $i = 0;
            foreach ($array_response as $response_array) {
                $obj_array[$i++] = (array)$response_array;
            }
            //print_r($hello);
            

            $confirmation_code = $this->getLastConfirmationCode();

            if ($confirmation_code < 1000)
                $confirmation_code = 1000;
            else
                $confirmation_code = (intval($confirmation_code) + 1);

            /*
             {
  "success": true,
  "clients": [
    {
      "employee_id": 52354,
      "global_name_number": 46500,
      "first_name": "Mateo",
      "last_name": "Dupuy",
      "dob": "01/05/2005",
      "address": "14, Rue Vilvalex\nPeguy-Ville\nPetion-Ville\nHaiti",
      "status": true,
      "company": "DUPUY & MEROVE-PIERRE",
      "primary_name": "Giscard Dupuy",
      "primary_employee_id": 52353,
      "policy_number": 2901,
      "legacy_policy_number": "12056"
    },
    {
      "employee_id": 208715,
      "global_name_number": 149003,
      "first_name": "Mateo",
      "last_name": "Dupuy",
      "dob": "01/05/2005",
      "address": "",
      "status": true,
      "company": "DUPUY & MEROVE-PIERRE",
      "primary_name": "Anick Supplice Dupuy",
      "primary_employee_id": 208714,
      "policy_number": 2901,
      "legacy_policy_number": "12056"
    }
  ]
}*/
            $i = 0;
            foreach ($obj_array as $client) {
                $array_clients[$i++] = array(
                    'employee_id' => $client['employee_id'],
                    'global_name_number' => $client['global_name_number'],
                    'firstname' => $client['first_name'],
                    'lastname' => $client['last_name'],
                    'dob' => $client['dob'],
                    'address' => $client['address'],
                    'status' => $client['status'],
                    'company' => $client['company'],
                    'primary_name' => $client['primary_name'],
                    'primary_employee_id' => $client['primary_employee_id'],
                    'policy_number' => $client['policy_number'],
                    'legacy_policy_number' => $client['legacy_policy_number'],
                    'has_hero' => $client['has_hero'],
                    'hero_tag' => $client['hero_tag'],
                    'is_dependant' => ($client['employee_id'] == $client['primary_employee_id']) ? 0 : 1
                );


                $this->saveHistorics([
                    'first_name' => $client['first_name'],
                    'last_name' => $client['last_name'],
                    'hero' => $client['hero_tag'],
                    'employee_id' => $client['employee_id'],
                    'primary_name' => ($client['employee_id'] == $client['primary_employee_id']) ? '-' : $client['primary_name'],
                    'primary_employee_id' => $client['primary_employee_id'],
                    'dob' => $client['dob'],
                    'status' => $client['status'],
                    'doctor_name' => $user->first_name . ' ' . $user->last_name,
                    'institution' => $user->institution,
                    'date' => date('Y-m-d H:i:s'),
                    'user_id' => $user->id,
                    'legacy_policy' => $client['legacy_policy_number'],
                    'is_dependant' => ($client['employee_id'] == $client['primary_employee_id']) ? 0 : 1],
                    $confirmation_code,
                    $user);

            }
            
            // $this->sendResearchAsPDF($array_clients, $user, $confirmation_code);

        }
        

        return $array_clients;
    }



    public function view(){

        if ($this->request->is('post')) {

            $data = $this->request->getData();

            $client = json_decode($data['client_selected']);
            $user_fullname = $data['user_fullname'];
            $user_institution = $data['user_institution'];

            $confirmation_code = $this->getLastConfirmationCode();
            $user = TableRegistry::get('Users')->get($this->request->session()->read('Auth.User')['id']);
            // debug($data);
            // die();

            $this->set(['client' => $client, 'user_fullname' => $user_fullname, 'user_institution' => $user_institution, 'code' => $confirmation_code, 'user' => $user]);

        }else{

          $this->redirect(['action' => 'gestion']);
        }
        
        
    }




    public function testsend()
    {

      $data = $this->request->getData();

      $clients = array();
      $message = false;

       $this->set([
            'error' => $message,
            'clients' => $clients
          ]);
        
    }





    public function sendresearch()
    {

        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $client = json_decode($data['client_selected']);

            $clients = array();
            $clients[] = $client;

            $confirmation_code = $this->getLastConfirmationCode();

            $user = TableRegistry::get('Users')->get($this->request->session()->read('Auth.User')['id']);

            if ($confirmation_code < 1000)
                $confirmation_code = 1000;


            // debug($data);
            // die();

            

            if(isset($data['mail'])){
              $this->sendResearchAsPDF($clients, $user, $confirmation_code, false);
              $this->Flash->success("Mail envoyé");
            }else{
              $this->sendResearchAsPDF($clients, $user, $confirmation_code, true);
            }

            $this->redirect(['action' => 'gestion']);

        }else{

            $this->redirect(['action' => 'gestion']);
        }

    }




     public function sendresearchapi()
    {


        // $this->request->getParam('article_id');

        $data = $this->request->getData();
        $message = true;
        $mail = false;
        $user = null;
        $client = null;

        if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $message = false;
            $mail = true;


            $user = TableRegistry::get('Users')->get($data['user_id']);

            $client = json_decode($data['client']);
            $client->legacy_number = $client->legacy_policy_number;

            $confirmation_code = $this->getLastConfirmationCode();

            if ($confirmation_code < 1000)
                $confirmation_code = 1000;


            $clients = array();
            $clients[] = $client;  
            

            $this->sendResearchAsPDF($clients, $user, $confirmation_code, false);

           
      }
        
      $this->set([
            'error' => $message,
            'client' => $client,
            'mail' => $mail,
            'user' => $user
        ]);
      

      

    }


    public function gestion()
    {
        // auto logout if user is doctor and there's a problem with the API
        $this->autoLogout();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $firstname = trim($data['first_name']);
            $lastname = trim($data['last_name']);
            $dob = trim($data['dob']);

            $user = TableRegistry::get('Users')->get($this->request->session()->read('Auth.User')['id']);

            $error = false;


//            $this->saveInAdminLog(
//                $this->request->session()->read('Auth.User')['last_name'],
//                "START SEARCH",
//                date('Y-m-d H:i:s'),
//                $user->institution,
//                "TEST",
//                $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');

            $response = json_decode($this->getClient($firstname, $lastname, $dob));

//            $this->saveInAdminLog(
//                $this->request->session()->read('Auth.User')['last_name'],
//                "API RESPONSE",
//                date('Y-m-d H:i:s'),
//                $user->institution,
//                "TEST",
//                $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
//             var_dump($response);
//             die();
            // var_dump(isset($response[0]));

            if (is_object($response)) {
                if (!$response->success) {
                    if (!empty($response->Info)) {
                        $error = 'Impossible de se connecter au serveur de données.';
                    } elseif (!empty($response->Details)) {
                        $error = 'Problème de communication à l\'API.';
                    } elseif (empty($response->clients)) { $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                        $error = 'Aucun client ne correspond à vos critères de recherche.';
                    } else {
                        $error = 'Erreur inconnue - Appelez le support technique.';
                    }
                } else {
                    if (empty($response->clients)) { $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                        $error = 'Aucun client ne correspond à vos critères de recherche.';
                    } else {
                        $response->clients = $this->getClientBenefits($response->clients);
                    }
                }
            } else {
                if ($response[0]->Response[0]->success == false) {
                    $error = "Erreur d'authentification à l'API";
                } else {
                    if (empty($response[0]->Response[0]->clients)) { $this->saveInAdminLog(
                        $user->first_name,
                        $user->last_name,
                        $user->role,
                        $user->institution,
                        "a recherché",
                        $firstname . ' ' . $lastname . ' ' . $dob . ' [MM/DD/YYYY]');
                        $error = 'Aucun client ne correspond à vos critères de recherche.';
                    }
                }
            }

            $this->set('errorMessage', $error);

            if ($response->success and !empty($response->clients)) {
                $response_firstname = $response->clients[0]->first_name;
                $response_employeeID = $response->clients[0]->employee_id;
                $response_lastname = $response->clients[0]->last_name;
                $response_status = $response->clients[0]->status;
                $response_dob = $response->clients[0]->dob;
                $response_success = $response->success;

                $array_response = (array)$response->clients;
                $array_clients = array(array());

                $obj_array = array();
                $i = 0;
                foreach ($array_response as $response_array) {
                    $obj_array[$i++] = (array)$response_array;
                }
                //print_r($hello);
                // debug($array_response);
                // die();

                $confirmation_code = $this->getLastConfirmationCode();

                if ($confirmation_code < 1000)
                    $confirmation_code = 1000;
                else
                    $confirmation_code = (intval($confirmation_code) + 1);


                $i = 0;
                foreach ($obj_array as $client) {
                    $array_clients[$i++] = array(
                        'lastname' => $client['last_name'],
                        'firstname' => $client['first_name'],
                        'primary_employee_id' => $client['primary_employee_id'],
                        'primary_name' => $client['primary_name'],
                        'dob' => $client['dob'],
                        'employee_id' => $client['employee_id'],
                        'address' => $client['address'],
                        'policy_number' => $client['policy_number'],
                        'company' => $client['company'],
                        'status' => $client['status'],
                        'has_hero' => $client['has_hero'],
                        'hero_tag' => $client['hero_tag'],
                        'is_dependant' => ($client['employee_id'] == $client['primary_employee_id']) ? 0 : 1,
                        'legacy_number' => $client['legacy_policy_number']
                    );

                    //$array_user = $this->request->session()->read('Auth.User');


                    $this->saveHistorics([
                        'first_name' => $client['first_name'],
                        'last_name' => $client['last_name'],
                        'hero' => $client['hero_tag'],
                        'employee_id' => $client['employee_id'],
                        'primary_name' => ($client['employee_id'] == $client['primary_employee_id']) ? '-' : $client['primary_name'],
                        'primary_employee_id' => $client['primary_employee_id'],
                        'dob' => $client['dob'],
                        'status' => $client['status'],
                        'doctor_name' => $user->first_name . ' ' . $user->last_name,
                        'institution' => $user->institution,
                        'date' => date('Y-m-d H:i:s'),
                        'user_id' => $user->id,
                        'legacy_policy' => $client['legacy_policy_number'],
                        'is_dependant' => ($client['employee_id'] == $client['primary_employee_id']) ? 0 : 1],
                        $confirmation_code,
                        $user);

                }

                // debug($array_clients);
                // die();
               
                //$this->sendResearchAsPDF($array_clients, $user, $confirmation_code);

//                print_r($array_clients);
//                die();
                $old_date_timestamp = strtotime($dob);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);


                $this->set(
                    array(
                        'clients' => $array_clients,
                        'client_dob' => $dob,
                        'client_search_dob' => $new_date));

////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
//                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
//                    . ' ' .
//                    $this->request->session()->read('Auth.User')['last_name'],
//                    $this->request->session()->read('Auth.User')['role'],
//                    $this->request->session()->read('Auth.User')['institution'],
//                    "a recherché le client",
//                    strtoupper($firstname) . ' ' . strtoupper($lastname) . "\n");
            } else {

                $array_response = (array)$response->clients;
                $this->set(array('clients' => $array_response, 'client_dob' => $dob));
            }
        } else {
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
//            $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
//                . ' ' .
//                $this->request->session()->read('Auth.User')['last_name'],
//                $this->request->session()->read('Auth.User')['role'],
//                $this->request->session()->read('Auth.User')['institution'],
//                "est allé dans ACCUEIL",
//                "" . "\n");
        }

    }

    private function getClientBenefits($clients)
    {
        $total = count($clients);
        // var_dump($clients);
        for ($i = 0; $i < $total; $i++) {
            $condition = false;
            $employee_id = $clients[$i]->employee_id;

            $curl_host = curl_init();

            curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.83:8180/RequestQuote/epic_mwGetEBSubscriberExts");
            //curl_setopt($curl_host, CURLOPT_URL, "192.168.5.8:8080/RequestQuote/epic_mwGetEBSubscriberExts");
            // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
            curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_host, CURLOPT_POST, 1);

            curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

            curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $this->key . '"},"employee_id": ' . $employee_id . ',"first_name": "' . $clients[$i]->first_name . '"}');
            curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

            $result = curl_exec($curl_host);
            // debug($result);
            // die();
            // checck if policy extensions exist
            if (!empty(json_decode($result)->policy_extensions) and isset(json_decode($result)->policy_extensions)) {
                $result = json_decode($result)->policy_extensions;

                for ($j = 0; $j < count($result); $j++) {
                    if (strpos(strtolower($result[$j]->extension), 'hero') !== false) {
                        //debug($result);
                        $condition = true;
                        // $hero_tag = $result[$j]->extension;
                        $hero_tag = $result[$j]->name_for_display;
                    }
                }
            }

            if ($condition == true) {
                $clients[$i]->has_hero = true;
                $clients[$i]->hero_tag = $hero_tag;
            } else {
                $clients[$i]->has_hero = false;
                $clients[$i]->hero_tag = 'N/A';
            }
        }
        return $clients;
    }


    public function saveInHistoric()
    {
        // array that contains the post
        $array_post = $this->request->getData();

        // get the max confirmation code registered
        $confirmation_code = $this->getLastConfirmationCode();


        $var = $array_post['dob'];
        $date = str_replace('/', '-', $var);
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


        if ($confirmation_code < 1000)
            $log->confirmation_code = 1000;
        else
            $log->confirmation_code = (intval($confirmation_code) + 1);

        $log->user_id = $array_post['user_id'];
        $log_saved = $logs_model->save($log);
        if ($log_saved) {
            echo json_encode(
                [
                    'error' => false,
                    'message' => 'Save in historic successfully',
                    'data' => $log_saved
                ]);
            die();
        } else {
            echo json_encode(
                [
                    'error' => true,
                    'message' => 'Save in historic failed',
                    'data' => $log_saved
                ]);
            die();
        }
    }


    private function getResponseFromApiForLogin()
    {
        // init curl
        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.226.83:8180/RequestQuote/RequestLogin");
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

        return $result;
    }

    private function isSuccessfullyLoginToApi($result)
    {

        // decode the result in JSON
        $response = json_decode($result);

        // if the Auth is 'true' then get the key
        if (json_encode($response[0]->Response[0]->success)) {
            return true;
        }
        return false;
    }


    private function getKeyFromTheLoginResponse($result)
    {
        $response = json_decode($result);
        return $key = str_replace('"', "", json_encode($response[0]->Response[0]->key));
    }

    private function getResponseFromApiForSearch($key, $firstname, $lastname, $dob)
    {

        $curl_host = curl_init();

        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.226.83:8180/RequestQuote/epic_mwClientSearch");
        //curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8080/RequestQuote/epic_mwClientSearch");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);

        curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $key . '"},"first_name":"' . strtoupper($firstname) . '","last_name":"' . strtoupper($lastname) . '","dob":"' . $dob . '"}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        return curl_exec($curl_host);
    }

    private function isSearchSuccessfull($result)
    {
        $response = json_decode($result);

        if ($response->success and !empty($response->clients)) {
            return true;
        }

        return false;
    }


    /**
     * Function that gets the client's information from the API of INASSA
     *
     * @param $firstname
     * @param $lastname
     * @param $dob
     * @return mixed
     */
    public function getClient($firstname, $lastname, $dob)
    {

        $this->saveInAdminLog(
            $this->request->session()->read('Auth.User')['last_name'],
            "QUERY 1 START",
            date('Y-m-d H:i:s.u'),
            "",
            "TEST",
            "");

        // init curl
        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.226.83:8180/RequestQuote/RequestLogin");

        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);

        curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"Login":{"username":"wyzdev@nassagroup.com","password":"W1Yz$54@8jha$1"}}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        //result from the API of INASSA
        $result = curl_exec($curl_host);

       // var_dump($result);
       // die();
        $this->saveInAdminLog(
            $this->request->session()->read('Auth.User')['last_name'],
            "QUERY 1 END",
            date('Y-m-d H:i:s.u'),
            "",
            "TEST",
            "");

        if (empty($result)) {

            $error_message = "{\"error\":true,\"message\":\"Login failed\",\"api_response\":\"Cannot communicate with the server\"}";

            $this->request->session()->write('api_response', $error_message);
            $this->saveInMiddlewareLogsAndSendEmail($error_message,
                $this->request->session()->read('Auth.User')['id']);
            $this->setLockDown(true);
            if ($this->request->session()->read('Auth.User')['role'] == 'medecin')
                $this->logout();
        }
        $response = json_decode($result);


        if ($response[0]->Response[0]->success == false) {
            return $result;
        }
        // decode the result in JSON
        $response = json_decode($result);

        // if the Auth is 'true' then get the key
        if (json_encode($response[0]->Response[0]->success)) {
            // remove the quotes that surround the 'key'
            $key = str_replace('"', "", json_encode($response[0]->Response[0]->key));
        }
        $this->key = $key;
        $curl_host = curl_init();

//         debug($key);
//         die();

        $this->saveInAdminLog(
            $this->request->session()->read('Auth.User')['last_name'],
            "QUERY 2 START",
            date('Y-m-d H:i:s'),
            "",
            "TEST",
            "");

        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.226.83:8180/RequestQuote/epic_mwClientSearch");
        //curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8080/RequestQuote/epic_mwClientSearch");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);

        curl_setopt($curl_host, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_host, CURLOPT_TIMEOUT, 20); //timeout in seconds

        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $key . '"},"first_name":"' . strtoupper($firstname) . '","last_name":"' . strtoupper($lastname) . '","dob":"' . $dob . '"}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        $this->saveInAdminLog(
            $this->request->session()->read('Auth.User')['last_name'],
            "QUERY 2 END",
            date('Y-m-d H:i:s'),
            "",
            "TEST",
            "");

        return $result = curl_exec($curl_host);

    }

//
    public function testapiclient()
    {
        $response_login = $this->getResponseFromApiForLogin();

        if (empty($response_login)) {
            $response = "Cannot communicate with the server";
            $response = json_encode(
                [
                    'error' => true,
                    'message' => 'Login failed',
                    'api_response' => $response
                ]
            );
            $this->request->session()->write('api_response', $response);
            $this->sendresponseapi();
            $this->set(array('result' => $response));
            $this->saveInMiddlewareLogs($response, $this->request->session()->read('Auth.User')['id']);
            return;

        }

        if (!$this->isSuccessfullyLoginToApi($response_login)) {
            $response = json_encode(
                [
                    'error' => true,
                    'message' => 'Login failed',
                    'api_response' => $response_login
                ]
            );
            $this->request->session()->write('api_response', $response);
            $this->sendresponseapi();
            $this->set([
                'api' => false
            ]);
            $this->set(array('result' => $response));
            $this->saveInMiddlewareLogs(json_encode(json_decode($response_login)[0]->Response), $this->request->session()->read('Auth.User')['id']);
            return;
        }

        $response_search = $this
            ->getResponseFromApiForSearch(
                $this->getKeyFromTheLoginResponse($response_login),
                'sebastien',
                'merove-pierre',
                '9/18/1988');

        if (!$this->isSearchSuccessfull($response_search)) {
            $response = json_encode(
                [
                    'error' => true,
                    'message' => 'Search failed',
                    'api_response' => $response_search
                ]
            );
            $this->request->session()->write('api_response', $response);
            $this->sendresponseapi();
            $this->set(array('result' => $response));
            $this->saveInMiddlewareLogs(json_encode(json_decode($response_login)[0]->Response), $this->request->session()->read('Auth.User')['id']);
            return;

        }


        $response = json_encode(
            [
                'error' => false,
                'message' => 'Test successfull',
                'api_response' => $response_search
            ]
        );
        $this->request->session()->write('api_response', $response);
        $this->set(array('result' => $response));
    }

    private function getAdminAddresses()
    {
        return [
            'hollynderisse93@gmail.com',
            'hollyn.derisse@esih.edu'
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
        $this->Flash->error("Les serveurs sont temporairement indisponibles.");

        //$this->Flash->success('E-mail envoyé à : ' . $mails);
       /* return $this->redirect(
            [
                'action' => 'gestion'
            ]
        );*/
    }

    private function sendEmailWithApiResponse($mai_address)
    {
        // to
        $to = $mai_address;
        //subject
        $subject = 'Reponse de l\'API';
        //message
        $message = 'Test effectué par : '
            . $this->request->session()->read('Auth.User')['first_name'] . ' ' . $this->request->session()->read('Auth.User')['last_name'] . '<br />' .
            'Test API échoué le ' . date('d/m/Y') . ' à ' . date('H:i') . '<br /><br />
        Le message d\'erreur est : <br />' . $this->getApiResponse();
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail', $mail);
        $this->viewBuilder()->setLayout(false);
        $this->render(false);
    }

    private function getApiResponse()
    {
        $response = json_decode($this->request->session()->read('api_response'))->api_response;
        return $response;
    }
    
    
   
}


