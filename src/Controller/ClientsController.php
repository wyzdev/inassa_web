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

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{
    public $components = array('Email');
    private $API_RESPONSE = '';

    /**
     * Function that allows the user to search client.
     */
    public function gestion()
    {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $firstname = trim($data['first_name']);
            $lastname = trim($data['last_name']);
            $dob = trim($data['dob']);


            // decode the result in JSON
            $response = json_decode($this->getClient($firstname, $lastname, $dob));

            if ($response->success and !empty($response->clients)) {
                $response_firstname = $response->clients[0]->first_name;
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


                $i = 0;
                foreach ($obj_array as $client) {
                    $array_clients[$i++] = array(
                        'lastname' => $client['last_name'],
                        'firstname' => $client['first_name'],
                        'dob' => $client['dob'],
                        'address' => $client['address'],
                        'policy_number' => $client['policy_number'],
                        'company' => $client['company'],
                        'status' => $client['status']
                    );
                }

                $old_date_timestamp = strtotime($dob);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);


                $this->set(array('clients' => $array_clients, 'client_dob' => $dob, 'client_search_dob' => $new_date));
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    . ' ' .
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    "a recherché le client",
                    strtoupper($firstname) . ' ' . strtoupper($lastname) . "\n");
            } else {

                $array_response = (array)$response->clients;
                $this->set(array('clients' => $array_response, 'client_dob' => $dob));
            }
        } else {
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
            $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                . ' ' .
                $this->request->session()->read('Auth.User')['last_name'],
                $this->request->session()->read('Auth.User')['role'],
                $this->request->session()->read('Auth.User')['institution'],
                "est allé dans ACCUEIL",
                "" . "\n");
        }

    }


    public function saveInHistoric()
    {
        // array that contains the post
        $array_post = $this->request->getData();


        // Table that we are going to use "Logs"
        $logs_model = TableRegistry::get("Logs");

        $log = $logs_model->newEntity();
        $log = $logs_model->patchEntity($log, $array_post);
        if ($logs_model->save($log)) {
            echo json_encode(
                [
                    'error' => false,
                    'message' => 'Save in historic successfully',
                    'data' => $log
                ]);
            die();
        } else {
            echo json_encode(
                [
                    'error' => true,
                    'message' => 'Save in historic failed',
                    'data' => $log
                ]);
            die();
        }
    }


    private function getResponseFromApiForLogin()
    {


        // init curl
        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.221:8180/RequestQuote/RequestLogin");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/RequestLogin");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);
        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"Login":{"username":"jotest@test.com","password":"P@$$w0rd"}}');
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

        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.221:8180/RequestQuote/epic_mwClientSearch");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);
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

        // init curl
        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.221:8180/RequestQuote/RequestLogin");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/RequestLogin");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);
        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"Login":{"username":"jotest@test.com","password":"P@$$w0rd"}}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        //result from the API of INASSA
        $result = curl_exec($curl_host);

        // decode the result in JSON
        $response = json_decode($result);

        // if the Auth is 'true' then get the key
        if (json_encode($response[0]->Response[0]->success)) {
            // remove the quotes that surround the 'key'
            $key = str_replace('"', "", json_encode($response[0]->Response[0]->key));
        }

        $curl_host = curl_init();

        curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.221:8180/RequestQuote/epic_mwClientSearch");
        // curl_setopt($curl_host, CURLOPT_URL, "http://192.168.5.8:8180/RequestQuote/epic_mwClientSearch");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);
        curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $key . '"},"first_name":"' . strtoupper($firstname) . '","last_name":"' . strtoupper($lastname) . '","dob":"' . $dob . '"}');
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        return $result = curl_exec($curl_host);

    }

    public function testapi()
    {
        $response_login = $this->getResponseFromApiForLogin();

        if (!$this->isSuccessfullyLoginToApi($response_login)) {
            $response = json_encode(
                [
                    'error' => true,
                    'message' => 'Login failed',
                    'api_response' => $response_login
                ]
            );
            $this->request->session()->write('api_response', $response);
            $this->set(array('result' => $response));
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
            $this->set(array('result' => $response));
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

    public function sendresponseapi()
    {
        $mail_addresses = $this->getAdminAddresses();

        $mails = '';
        foreach ($mail_addresses as $key => $mail_address):
            $mails .= $mail_address . ' - ';
            $this->sendEmailWithApiResponse($mail_address);
        endforeach;

        $this->Flash->success('E-mail envoyé à : ' . $mails);
        return $this->redirect(
            [
                'action' => 'gestion'
            ]
        );
    }

    private function sendEmailWithApiResponse($mai_address)
    {
        $to = $mai_address;
        $subject = 'Reponse de l\'API';
        $message = 'Test API échoué le ' . date('d/m/Y') . ' à ' . date('H:i') . '<br /><br />
        Le message d erreur est : <br />' .$this->getApiResponse();
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail', $mail);
        $this->viewBuilder()->setLayout(false);
        $this->render(false);
    }

    private function getApiResponse(){
        $response = json_decode($this->request->session()->read('api_response'));
        return $response->api_response;
    }
}

