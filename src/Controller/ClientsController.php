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

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $clients = $this->paginate($this->Clients);

        $this->set(compact('clients'));
        $this->set('_serialize', ['clients']);
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => []
        ]);

        $this->set('client', $client);
        $this->set('_serialize', ['client']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $client = $this->Clients->newEntity();
        if ($this->request->is('post')) {
            $client = $this->Clients->patchEntity($client, $this->request->data);
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
        $this->set(compact('client'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->data);
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
        $this->set(compact('client'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function gestion1(){
        //$user = $this->Users->get($this->Auth->user('id'));
        $user = $this->request->session()->read('Auth.User')['id'];
        if (!empty($this->request->data)) {
            $user = $this->Users->patchEntity(
                $user,
                [
                    'old_password' => $this->request->data['old_password'],
                    'password' => $this->request->data['password1'],
                    'password1' => $this->request->data['password1'],
                    'password2' => $this->request->data['password2']
                ],
                ['validate' => 'password'] );
            if ($this->Users->save($user)) {
                $this->Flash->success('The password is successfully changed');
                $this->redirect('/index');
            }
            else {
                $this->Flash->error('There was an error during the save!');
            }
        }
        $this->set('user',$user);
    }

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

                $this->set('client', array('firstname' => $response_firstname, 'lastname' => $response_lastname, 'status' => $response_status, 'dob' => $response_dob, 'success' => $response_success));

            }
            else
                $this->set('client', array('success' => false));



        }
    }
}

