<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public $components = array('Email');
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
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


    public function addusers()
    {
        if ($this->request->session()->read('Auth.User')['role'] != 'admin' or $this->request->session()->read('Auth.User')['first_login'])
            $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $randomPassword = $this->randomPassword();
            $user->password = $randomPassword;
            $user->status = 1;
            $user->first_login = 1;
            if ($this->Users->save($user)) {
                $this->sendPassword($user->email, $randomPassword);
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

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function login()
    {
        if ($this->request->session()->read('Auth.User'))
            $this->redirect(
                [
                    'controller' => 'clients',
                    'action' => 'gestion'
                ]);
        $this->viewBuilder()->setLayout('authentification_layout');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if ($user['status']) {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl(['controller' => 'clients', 'action' => 'gestion']));
                } else
                    $this->Flash->error(__('Vous n\'etes pas actif dans la base de donnees'));
            }
            $this->Flash->error(__('Nom d\'utilisateur ou mot de passe invalide, essayez encore'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function changepassword()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        //$user = $this->Users->newEntity();
        if (!empty($this->request->data)) {
            $user = $this->Users->patchEntity($user, [
                'password' => $this->request->data['password1'],
                'password1' => $this->request->data['password1'],
                'password2' => $this->request->data['password2']
            ],
                ['validate' => 'password']
            );
            $user->first_login = false;
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
                $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
            }
        }
        $this->set('user', $user);
    }

    private function sendPassword($usermail, $userpassword){
        $to = $usermail;
        $subject = 'Votre mot de passe';
        $message = 'Votre mot de passe est : '.$userpassword;
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail',$mail);
        $this->render(false);
    }

    public function test() {
        // just to test out the sending email using SMTP is OK, create a method that will be able to access from public
        $to = 'hollyn.derisse@esih.edu';
        $subject = 'Hi buddy, i got a message for you.';
        $message = 'Nothing much. Just test out my Email Component using PHPMailer.';
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail',$mail);
        $this->render(false);
    }


    public function updateAccess()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
            //echo $_POST['value_to_send'];
            $id = $this->request->data('value_to_send');
            $user = $this->Users->get($id);
            if ($this->request->session()->read('Auth.User')['id'] != $id) {
                if ($user->role == 'admin')
                    $user->role = 'user';
                else
                    $user->role = 'admin';

                $usersTable->save($user);
            } else
                echo 'no';


            //or debug($this->request->data);
            //echo $user;
            die();
        }
    }

    public function updateStatus()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
            // echo $_POST['value_to_send'];
            $id = $this->request->data('value_to_send');
            $user = $this->Users->get($id);
            if ($this->request->session()->read('Auth.User')['id'] != $id) {
                if ($user->status)
                    $user->status = false;
                else
                    $user->status = true;

                $usersTable->save($user);
            } else
                echo 'no';


            //or debug($this->request->data);
            //echo $user;
            die();
        }
    }

    public function resetAccount()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
            // echo $_POST['value_to_send'];
            $id = $this->request->data('value_to_send');
            $user = $this->Users->get($id);
            if ($this->request->session()->read('Auth.User')['id'] != $id) {
                //$user->institution = 'INASSA';
                if ($user->role == 'admin')
                    $user->role = 'user';
                $newPassword = $this->randomPassword();
                $user->status = true;
                $user->first_login = true;
                $user->password = $newPassword;

                if ($usersTable->save($user))
                    $this->sendPassword($user->email, $newPassword);
            } else
                echo 'no';


//            debug($this->request->data);
//            echo $user;
            die();
        }
    }
}
