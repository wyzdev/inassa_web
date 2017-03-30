<?php
namespace App\Controller;

use App\Controller\AppController;

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
            $message = 'Saved';
        } else {
            $message = 'Error';
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
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->set([
            'message' => $message,
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

/*


public function initialize()
{
    $this->loadComponent('RequestHandler');
}

public function add()
{
    $log = $this->Logs->newEntity();
    if ($this->request->is('post')) {
        $log = $this->Logs->patchEntity($log, $this->request->data);
        if ($this->Logs->save($log)) {
            $this->Flash->success(__('The log has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The log could not be saved. Please, try again.'));
    }
    $this->set(compact('log'));
    $this->set('_serialize', ['log']);
}

public function edit($id = null)
{
    $log = $this->Logs->get($id, [
        'contain' => []
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
        $log = $this->Logs->patchEntity($log, $this->request->data);
        if ($this->Logs->save($log)) {
            $this->Flash->success(__('The log has been saved.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The log could not be saved. Please, try again.'));
    }
    $this->set(compact('log'));
    $this->set('_serialize', ['log']);
}
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $log = $this->Logs->get($id);
    if ($this->Logs->delete($log)) {
        $this->Flash->success(__('The log has been deleted.'));
    } else {
        $this->Flash->error(__('The log could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
}


public function historique()
{
    $logs = $this->paginate($this->Logs);

    $this->set(compact('logs'));
    $this->set('_serialize', ['logs']);
}*/
