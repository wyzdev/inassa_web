<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $logs = $this->Logs->find('all');
        $this->set([
            'logs' => $logs,
            '_serialize' => ['logs']
        ]);
    }

    public function view($id)
    {
        $log = $this->Logs->get($id);
        $this->set([
            'log' => $log,
            '_serialize' => ['log']
        ]);
    }

    public function add()
    {
        $log = $this->Logs->newEntity($this->request->getData());
        if ($this->Logs->save($log)) {
            $message = true;
        } else {
            $message = false;
        }
        $this->set([
            'message' => $message,
            'log' => $log,
            '_serialize' => ['message', 'log']
        ]);
    }

    public function edit($id)
    {
        $log = $this->Logs->get($id);
        if ($this->request->is(['post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->getData());
            if ($this->Logs->save($log)) {
                $message = true;
            } else {
                $message = false;
            }
        }
        $this->set([
            'saved' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function delete($id)
    {
        $log = $this->Logs->get($id);
        $message = 'Deleted';
        if (!$this->Logs->delete($log)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
/*
    public function requestUser() {
        $user = TableRegistry::get('Users');
        $user = $this->Users->newEntity();
        $myuser = $this->Users->patchEntity($user, $this->request->getData());
        $user2 = $user->find('all')
            ->where(
                [
                    'Users.username' => $myuser->username,
                    'Users.password' => '$2y$10$.WPw0oxAa4GaCHodxOKweuRb2tV8VTVV5n5zCS6V/O4yNTnkNtlGm'
                ])
            ->toArray();

        $this->set([
            'message' => $user2
        ]);

        //debug($this->request->session()->read('Auth.User'));
        //debug($this->Users->find('all')->where(['Users.username' => 'hollyn_derisse', 'Users.password' => '$2y$10$.WPw0oxAa4GaCHodxOKweuRb2tV8VTVV5n5zCS6V/O4yNTnkNtlGm'])->toArray());
//        $usersTable->find('all')
//            ->where(['Users.username' => 'hollyn_derisse']));
        //->contain(['Comments', 'Authors']));
        //die();
    }*/

    public function historique()
    {

        if ($this->request->session()->read('Auth.User')['first_login']){
            $this->redirect(
                [
                    'controller' => 'clients',
                    'action' => 'gestion'
                ]);
        }
        else {
            $logs = $this->paginate($this->Logs);

            $this->set(compact('logs'));
            $this->set('_serialize', ['logs']);
        }
    }
}