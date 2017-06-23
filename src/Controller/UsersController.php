<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
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
    /**
     * @var array Array that contains the e-mail of INASSA.
     */
    public $components = array('Email');

    /**
     * Function that authenticates the user that uses the android application.
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
     * Function that registers new users.
     *
     * @return mixed
     */
    public function addusers()
    {
        if ($this->request->session()->read('Auth.User')['role'] != 'admin' or $this->request->session()->read('Auth.User')['first_login'])
            $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
        $user = $this->Users->newEntity();
        $registering = false;
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $randomPassword = $this->randomPassword();
            $user->last_name = strtoupper($user->last_name);
            $user->first_name = ucwords($user->first_name);
            $user->password = $randomPassword;
            $user->status = 1;
            $user->first_login = 1;
            if ($this->Users->save($user)) {
                $this->sendPassword($user->username, $user->email, $randomPassword);
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));

                $role = ($user->role == "admin") ? "Admin" : (($user->role == "medecin") ? "Médecin" : "Simple utilisateur");
                $status = ($user->status == true) ? "Actif" : "Inactif";
                ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    .' '.
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    "a enregistré l'utilisateur ",
                    ucwords($user->first_name).' '.strtoupper($user->last_name).' / '
                    .$user->username.' / '
                    .$user->email.' / '
                    .$role.' / '
                    .$status
                    ."\n");

                return $this->redirect(['action' => 'addusers']);
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));$this->set('user', $user);
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
            $this->set('_serialize', ['users']);
        }else{
            //if (!$registering) {
                ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    . ' ' .
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    " est allé dans PARAMETRES ",
                    "" . "\n");
            //}


            $this->set('user', $user);
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
            $this->set('_serialize', ['users']);
        }
    }

    /**
     * Function that generates random password.
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
     * Function that authenticates user that uses the web app
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
                if ($user['status'] and $user['role'] != "medecin") {
                    $this->Auth->setUser($user);

                    ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                    $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                        .' '.
                        $this->request->session()->read('Auth.User')['last_name'],
                        $this->request->session()->read('Auth.User')['role'],
                        $this->request->session()->read('Auth.User')['institution'],
                        " s'est connecté  ",
                        ""."\n");

                    return $this->redirect($this->Auth->redirectUrl(['controller' => 'clients', 'action' => 'gestion']));
                }
            }
            $this->set('id_incorrect', true);
        }
    }

    /**
     * Function that generates a new password for the user.
     *
     * Password will be sent to the user via an e-mail.
     */
    public function forgotPassword() {
        $data = $this->request->data;
        $message = true;
        $user = '';
        if (isset($data['token']) && $this->TOKEN == $data['token']){
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $result = $this->Users->findByEmail($user->email)->toArray();
            if ($result){
                $newPassword = $this->randomPassword();
                $this->sendPassword($user->username, $user->email, $newPassword);
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
     * Function that logs the user out.
     *
     * @return mixed
     */
    public function logout()
    {
        ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
        $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
            .' '.
            $this->request->session()->read('Auth.User')['last_name'],
            $this->request->session()->read('Auth.User')['role'],
            $this->request->session()->read('Auth.User')['institution'],
            " s'est déconnecté ",
            ""."\n");
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Function that changes the user's password.
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
                $this->Flash->success('Votre mot de passe a été changé avec succès');
                $this->Auth->setUser($user);
                $this->redirect(
                    [
                        'controller' => 'clients',
                        'action' => 'gestion'
                    ]);

                ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                    .' '.
                    $this->request->session()->read('Auth.User')['last_name'],
                    $this->request->session()->read('Auth.User')['role'],
                    $this->request->session()->read('Auth.User')['institution'],
                    " a changé son mot de passe ",
                    ""."\n");
            } else {
                //$this->Flash->error('There was an error during the save!');
                $this->redirect(['controller' => 'clients', 'action' => 'gestion']);
            }
        }
        //$this->set('user', $user);
    }

    /**
     * Function that sends password to the user's e-mail.
     *
     * @param $username
     * @param $usermail
     * @param $userpassword
     */
    private function sendPassword($username, $usermail, $userpassword){
        $to = $usermail;
        $subject = 'Votre mot de passe';
        $message = 'Votre nom d\'utilisateur est : '.$username."\n".'Votre mot de passe est : '.$userpassword;
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail',$mail);
        $this->render(false);
    }

    /**
     * Function that changes the doctor's password in database.
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
     * Function that changes the user's role in database.
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

                if ($usersTable->save($user)){
                    ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                    $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                        .' '.
                        $this->request->session()->read('Auth.User')['last_name'],
                        $this->request->session()->read('Auth.User')['role'],
                        $this->request->session()->read('Auth.User')['institution'],
                        " a changé le rôle de l'utilisateur ",
                        $user->first_name.' '.$user->last_name."\n");
                }
            } else
                echo 'no';
            die();
        }
    }

    /**
     * Function that changes the user's status in database.
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

                if ($usersTable->save($user)){

                    ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                    $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                        .' '.
                        $this->request->session()->read('Auth.User')['last_name'],
                        $this->request->session()->read('Auth.User')['role'],
                        $this->request->session()->read('Auth.User')['institution'],
                        " a changé le status de l'utilisateur ",
                        $user->first_name.' '.$user->last_name."\n");
                }
            } else
                echo 'no';
            die();
        }
    }

    /**
     * Function that changes the user's status, access and password in the database,
     * and send the new password to
     * the user's e-mail.
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

                if ($usersTable->save($user)) {
                    $this->sendPassword($user->username, $user->email, $newPassword);

                    ////////////////////////// SAVING DATA IN LOGS /////////////////////////////////////////////////////////
                    $this->writeinlogs($this->request->session()->read('Auth.User')['first_name']
                        .' '.
                        $this->request->session()->read('Auth.User')['last_name'],
                        $this->request->session()->read('Auth.User')['role'],
                        $this->request->session()->read('Auth.User')['institution'],
                        " a réinitialisé le compte de l'utilisateur ",
                        $user->first_name.' '.$user->last_name."\n");
                }
            } else
                echo 'no';
            die();
        }
    }
}
