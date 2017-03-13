<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //debug($this->request);
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////
/*    public function beforeFilter() {
        //parent::beforeFilter();
        // Allow users to register and logout.
        //$this->Auth->allow('add', 'logout');
    }*/


    public function addusers(){
        if ($this->request->session()->read('Auth.User')['access'] == 0)
            $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->password = 'admin123';
            $user->status = 1;
            $user->first_login = 1;
            if ($this->Users->save($user)) {
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));
                return $this->redirect(['action' => 'addusers']);
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));
        }
        $this->set('user', $user);

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    public function login() {
        if ($this->request->session()->read('Auth.User'))
            $this->redirect(
                [
                    'controller' => 'clients',
                    'action'     => 'gestion'
                ]);
        $this->viewBuilder()->setLayout('authentification_layout');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if ($user['status']){
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl(['controller' => 'clients', 'action' => 'gestion']));
                }
                else
                    $this->Flash->error(__('Vous n\'etes pas actif dans la base de donnees'));
            }
            $this->Flash->error(__('Nom d\'utilisateur ou mot de passe invalide, essayez encore'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function changepassword(){
        $user =$this->Users->get($this->Auth->user('id'));
        if (!empty($this->request->data)) {
            $user = $this->Users->patchEntity($user,
                [
                    'password1' => $this->request->data['password1'],
                    'password2' => $this->request->data['password2']
                ],
                ['validate' => 'password'] );
            $user->first_login = 0;
            if ($this->Users->save($user)) {
                $this->Flash->success('The password is successfully changed');

                $this->Auth->setUser($user);
                $this->redirect(
                    [
                        'controller' => 'clients',
                        'action' => 'gestion'
                    ]);
            } else {
                $this->Flash->error('There was an error during the save!');
            }
        }
    }

    public function test(){
        //$this->layout='ajax';
        // result can be anything coming from $this->data
        $result =  'Hello Dolly!';
        $this->set("result", $result);
    }

}
