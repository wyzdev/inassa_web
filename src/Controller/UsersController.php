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

use Dompdf\Dompdf;

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
                $this->sendPassword($user->username, $user->email, $randomPassword, $user->role);
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
                if ($user['status']) {
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
                } else{
                    $this->logout();
                    $this->set('id_incorrect', 2);
                }
            }
            $this->set('id_incorrect', 1);
        }
    }


    public function forgotpass()
    {

        $this->viewBuilder()->setLayout('authentification_layout');
        if ($this->request->is('post')){
            $data = $this->request->data;
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $result = $this->Users->findByEmail($user->email)->toArray();
            if ($result){
                $newPassword = $this->randomPassword();
                $this->sendPassword($result[0]['username'], $user->email, $newPassword, $result[0]['role']);
                $modif = $this->Users->get($result[0]['id']);
                $modif->password = $newPassword;
                $modif->first_login = true;
                $modif->status = true;
                if ($this->Users->save($modif)){
                    $this->Flash->success('Votre nouveau mot de passe a été envoyé à votre adresse e-mail');
                    return $this->redirect($this->Auth->logout());
                }
            }else{
                $this->set('email_incorrect', true); 
            }
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
                $this->sendPassword($result[0]['username']
                    , $user->email, $newPassword, $result[0]['role']);
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

    private function messageToSend($username, $userpassword, $role){
        $message = '';
        if ($role == 'medecin'){
            $message = 'Rendez-vous sur l\'application Android pour commencer.';
        }else{
            $message = 'Rendez-vous sur l\'application <a href="http://www.nassagroup.com/app/" target="_blank">ici.</a>';
        }
        return '<!DOCTYPE html>
                <html>
                    <head>
                        <title></title>
                        <style type="text/css">

                            .container{
                                font-family: \'calibri\';
                                display: inline-block;
                                background: rgba(100, 100, 100, .2);
                                padding: 20px 40px;
                                border-radius: 5px;
                            }

                            .semi-top-blue{
                                width: 400px;
                                background: rgb(6, 93, 170);
                                height: 300px;
                                border-radius: 15px 15px 0 0;
                            }

                            .semi-bottom-white{
                                width: 400px;
                                background: #fff;
                                height: 300px;
                                border-radius: 0 0 15px 15px;
                            }

                            .img-container{
                                padding-top: 45px;
                                display: inline-block;
                            }

                            .card-container{
                                text-align: center;
                            }
                            .card{
                                margin-top: 30px;
                                z-index: 99999;
                                border: 1px solid #000;
                                background: #fff;
                                border-radius: 5px;
                                display: inline-block;
                                padding: 10px 50px 40px 50px;
                                text-align: left;
                                box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.5);
                            }
                            
                            .redirect{
                                display: inline-block;
                                margin-top: 220px;
                                margin-left: 15px;
                            }

                            .card-libele{
                                display: inline-block;
                                width: 115px;
                            }
                        </style>
                    </head>

                    <body>
                        <center>
                            <div class="container">
                                <div class="semi-top-blue">
                                    <div class="card-container">
                                        <div class="img-container">
                                            <img src="http://nassagroup.com/app/img/logo_inassa_mail.png" height="150px">
                                        </div>
                                        <div class="card">
                                            <center><h3>Information du compte</h3></center>
                                            <span class="card-libele">Nom d\'utilisateur </span>: <strong>' . $username . '</strong>
                                            <br />
                                            <span class="card-libele">Mot de passe </span>: <strong>' . $userpassword . '</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="semi-bottom-white">
                                    <div class="redirect">
                                        <span>' . $message . '</span>
                                    </div>
                                </div>
                            </div>
                        </center>
                    </body>
                </html>';
    }

    /**
     * Function that sends password to the user's e-mail.
     *
     * @param $username
     * @param $usermail
     * @param $userpassword
     */
    private function sendPassword($username, $usermail, $userpassword, $role){
        $to = $usermail;
        $subject = 'Votre mot de passe';
        $message = $this->messageToSend($username, $userpassword, $role);
        $mail = $this->Email->send($to, $subject, $message);
        $this->set('mail',$mail);
        $this->viewBuilder()->setLayout(false);
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
                    $this->sendPassword($user->username, $user->email, $newPassword, $user->role);

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

    public function manuel(){
       // $this->viewBuilder()->setLayout('authentification_layout');        
    }

    public function delete($username)
    {
        
        $result = $this->Users->findByUsername($username)->toArray();
        $user = $this->Users->get($result[0]['id']);

        //$user = $this->Users->getUserByUsername($username);
        $message = 'Deleted';
        if (!$this->Users->delete($user)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
        return $this->redirect(['controller' => 'users', 'action' => 'addusers']);
    }

    public function hello(){

        $html =
            '<html><body>'.
            '<p>Put your html here, or generate it with your favourite '.
            'templating system.</p>'.
            '</body></html>';

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('Brochure.pdf', $output);

       /* $to = 'Hollyn';
        $subject = 'Votre pdf';
//        $message = $this->messageToSend($username, $userpassword, $role);
        $mail = $this->Email->send('hollyn.derisse@esih.edu', $subject, 'message', WWW_ROOT . DS . "Brochure.pdf");
        $this->set('mail',$mail);*/



    }
}
