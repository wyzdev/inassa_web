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

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $logs = $this->paginate($this->Logs);

        $this->set(compact('logs'));
        $this->set('_serialize', ['logs']);
    }

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);

        $this->set('log', $log);
        $this->set('_serialize', ['log']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->data;
        $log = '';
        $message = true;
        if (isset($data['token']) && $this->TOKEN == $data['token']) {
            $log = $this->Logs->newEntity($this->request->getData());
            if ($this->Logs->save($log))
                $message = false;
        }
        $this->set([
            'error' => $message,
            'log' => $log
        ]);

       /* $log = $this->Logs->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Logs->patchEntity($log, $this->request->getData());
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log could not be saved. Please, try again.'));
        }
        $this->set(compact('log'));
        $this->set('_serialize', ['log']);*/
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->getData());
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The log could not be saved. Please, try again.'));
        }
        $this->set(compact('log'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
            if ($this->request->session()->read('Auth.User')['first_login']) {
                $this->redirect(
                    [
                        'controller' => 'clients',
                        'action' => 'gestion'
                    ]);
            }
            else if ($this->request->is('post')) {
                $data = $this->request->data;
                $client = $this->Logs->find('all', array(
                    'conditions' => array(
                        'Logs.first_name' => $data['first_name'],
                        'Logs.last_name' => $data['last_name'],
                        'Logs.dob' => $data['dob']
                    )
                ));
                if ($client)
                {

                    $logs = $this->paginate($client);
                    $this->set(compact('logs'));
                    $this->set('_serialize', ['logs']);
                }
                else
                {
                }
            }
            else {
                $logs = $this->paginate($this->Logs);
                $this->set(compact('logs'));
                $this->set('_serialize', ['logs']);
            }
    }
}
