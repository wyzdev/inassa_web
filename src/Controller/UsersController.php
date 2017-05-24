<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public $components = array('Email');

    /**
     *
     */
    public function requestUser() {
        $data = $this->request->data;

        $message = true;
        $user = '';
        if (isset($data['token']) && $this->TOKEN == $data['token']){
            $user = $this->Auth->identify();
            if ($user)
                $message = false;
        }
        $this->set([
            'error' => $message,
            'user' => $user
        ]);
    }

    /**
     * @return mixed
     */
    public function addusers()
    {
        if ($this->request->session()->read('Auth.User')['role'] != 'admin' or $this->request->session()->read('Auth.User')['first_login'])
            $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $randomPassword = $this->randomPassword();
            $user->last_name = strtoupper($user->last_name);
            $user->first_name = ucwords($user->first_name);
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

    /**
     * randomPassword method
     *
     * @return string
     */
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

    /**
     * login method
     *
     * @return mixed
     */
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

    /**
     * forgotPassword method
     *
     * send an e-mail with a new password to a user
     */
    public function forgotPassword() {
        $data = $this->request->data;
        $message = true;
        $user = '';
        if (isset($data['token']) && $this->TOKEN == $data['token']){
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $result = $this->Users->findByUsername($user->username)->toArray();
            if ($result){
                $newPassword = $this->randomPassword();
                $this->sendPassword($user->email, $newPassword);
                $modif = $this->Users->get($result[0]['id']);
                $modif->password = $newPassword;
                $modif->first_login = true;
                $modif->status = true;
                $this->Users->save($modif);
            }
        }


        $this->set([
            'error' => $message,
            'user' => $user
        ]);
    }

    /**
     *
     * logout method
     *
     * @return mixed
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * changePassword method
     *
     *
     */
    public function changepassword()
    {
        $user = $this->Users->get($this->Auth->user('id'));
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
        //$this->set('user', $user);
    }

    /**
     * sendPassword method
     *
     * @param $usermail
     * @param $userpassword
     */
    private function sendPassword($usermail, $userpassword){
        $to = $usermail;
        $subject = 'Votre mot de passe';
        $message = 'Votre mot de passe est : '.$userpassword;
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail',$mail);
        $this->render(false);
    }

    /**
     * changePasswordMedecin method
     *
     *
     */
    public function changePasswordMedecin(){
        $data = $this->request->data;


        $message = true;
        $user = '';
        if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $result = $this->Users->findByUsername($data['username'])->toArray();

            if ($result) {
                $user = $this->Users->get($result[0]['id']);
                $user->password = $data['password'];
                $user->email = $data['email'];
                $user->first_login = false;
                $this->Users->save($user);

                $message = false;
            }
        }
        $this->set([
            'error' => $message,
            'user' => $user
        ]);
    }

    /**
     *test method
     */
    public function test() {
        // just to test out the sending email using SMTP is OK, create a method that will be able to access from public
//        $to = 'hollyn.derisse@esih.edu';
//        $subject = 'Hi buddy, i got a message for you.';
//        $message = 'Nothing much. Just test out my Email Component using PHPMailer.';
//        $mail = $this->Email->send($to, $subject, $message);
//        $this->set('mail',$mail);
//        $this->render(false);
//        $usersTable = TableRegistry::get('Users');
//        $hasher = new DefaultPasswordHasher();
//        debug($this->request->session()->read('Auth.User'));
        //debug($this->Users->find('all')->where(['Users.username' => 'hollyn_derisse', 'Users.password' => '$2y$10$.WPw0oxAa4GaCHodxOKweuRb2tV8VTVV5n5zCS6V/O4yNTnkNtlGm'])->toArray());
//        $usersTable->find('all')
//            ->where(['Users.username' => 'hollyn_derisse']));
            //->contain(['Comments', 'Authors']));
        $result = $this->Users->findByUsername('hollyn_derisse')->toArray();
//        $result = $this->Users->get(1)->toArray();
        debug($result[0]['username']);
        die();
    }

    /**
     * updateAccess method
     *
     * change access of a user to the database
     */
    public function updateAccess()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
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
            die();
        }
    }

    /**
     * updateStatus method
     *
     * change status of a user
     */
    public function updateStatus()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
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
            die();
        }
    }

    /**
     * resetAccount method
     *
     * change the status, the access and the password in the database, and send the new password to
     * the e-mail of this user
     */
    public function resetAccount()
    {
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is('ajax')) {
            // echo $_POST['value_to_send'];
            $id = $this->request->data('value_to_send');
            $user = $this->Users->get($id);
            if ($this->request->session()->read('Auth.User')['id'] != $id) {
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
            die();
        }
    }
}
