<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
{
    /**
     * Function that allows the user to search client.
     */
    public function gestion(){
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $firstname = $data['first_name'];
            $lastname = $data['last_name'];
            $dob = $data['dob'];



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
                foreach($array_response as $response_array){
                    $obj_array[$i ++] = (array)$response_array;
                }
                //print_r($hello);


                $i = 0;
                foreach($obj_array as $client){
                    $array_clients[$i ++] =  array(
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


                $this->set(array('clients' => $array_clients, 'client_dob'=> $dob, 'client_search_dob' => $new_date));
////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    .' '.
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    "a recherché le client",
                    strtoupper($firstname).' '.strtoupper($lastname)."\n");
            }
            else{
                
                $array_response = (array)$response->clients;
                $this->set(array('clients' => $array_response, 'client_dob'=> $dob));
                    }
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

    /**
     * Function that gets the client's information from the API of INASSA
     *
     * @param $firstname
     * @param $lastname
     * @param $dob
     * @return mixed
     */
    public function getClient($firstname, $lastname, $dob){

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

    public function testApi(){

        $curl_host = curl_init();

        // set some cURL options
        curl_setopt($curl_host, CURLOPT_URL, "www.google.com");
        curl_setopt($curl_host, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_host, CURLOPT_POST, 1);
        curl_setopt($curl_host, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

        curl_setopt($curl_host, CURLOPT_SSL_VERIFYPEER, false);

        //result from the API of INASSA
        $result = curl_exec($curl_host);
        print_r(curl_getinfo($curl_host));
        echo "--------------------------------------------------------";
        print curl_error($curl_host);
        die();
    }
}

