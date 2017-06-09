<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{


    public function gestion(){
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $firstname = $data['first_name'];
            $lastname = $data['last_name'];
            $dob = $data['dob'];

            // init curl
            $curl_host = curl_init();

            // set some cURL options
            curl_setopt($curl_host, CURLOPT_URL, "http://200.113.219.221:8180/RequestQuote/RequestLogin");
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
            curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_host, CURLOPT_POST, 1);
            curl_setopt($curl_host, CURLOPT_POSTFIELDS, '{"resquestkey":{"key":"' . $key . '"},"first_name":"' . strtoupper($firstname) . '","last_name":"' . strtoupper($lastname) . '","dob":"' . $dob . '"}');
            curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

            $result = curl_exec($curl_host);

            // decode the result in JSON
            $response = json_decode($result);
            if ($response->success and !empty($response->clients)) {
                $response_firstname = $response->clients[0]->first_name;
                $response_lastname = $response->clients[0]->last_name;
                $response_status = $response->clients[0]->status;
                $response_dob = $response->clients[0]->dob;
                $response_success = $response->success;


                $old_date_timestamp = strtotime($dob);
                $new_date = date('Y-m-d H:i:s', $old_date_timestamp);

                $this->set('client',
                    array(
                        'firstname' => $response_firstname,
                        'lastname' => $response_lastname,
                        'status' => $response_status,
                        'dob' => $response_dob,
                        'success' => $response_success,
                        'field_firstname' => $firstname,
                        'field_lastname' => $lastname,
                        'field_dob' => $new_date,
                    ));
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    .' '.
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    "a recherché le client",
                    strtoupper($firstname).' '.strtoupper($lastname)."\n");
            }
            else
                $this->set('client', array('success' => false));
        }
        else{
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
            $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                .' '.
                $this->request->session()->read('Auth.User')['last_name'],
                $this->request->session()->read('Auth.User')['role'],
                $this->request->session()->read('Auth.User')['institution'],
                "est allé dans ACCUEIL",
                ""."\n");
        }

    }
}

