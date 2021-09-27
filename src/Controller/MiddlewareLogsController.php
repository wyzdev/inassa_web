<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MiddlewareLogs Controller
 *
 * @property \App\Model\Table\MiddlewareLogsTable $MiddlewareLogs */
class MiddlewareLogsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $middlewareLogs = $this->MiddlewareLogs->find()
            ->orderDesc('date')
            ->contain(['Users']);


        $this->set(compact('middlewareLogs'));
        $this->set('_serialize', ['middlewareLogs']);
    }

    /**
     * View method
     *
     * @param string|null $id Middleware Log id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $middlewareLog = $this->MiddlewareLogs->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('middlewareLog', $middlewareLog);
        $this->set('_serialize', ['middlewareLog']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $middlewareLog = $this->MiddlewareLogs->newEntity();
        if ($this->request->is('post')) {
            $middlewareLog = $this->MiddlewareLogs->patchEntity($middlewareLog, $this->request->getData());
            if ($this->MiddlewareLogs->save($middlewareLog)) {
                $this->Flash->success(__('The middleware log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The middleware log could not be saved. Please, try again.'));
        }
        $users = $this->MiddlewareLogs->Users->find('list', ['limit' => 200]);
        $this->set(compact('middlewareLog', 'users'));
        $this->set('_serialize', ['middlewareLog']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Middleware Log id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $middlewareLog = $this->MiddlewareLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $middlewareLog = $this->MiddlewareLogs->patchEntity($middlewareLog, $this->request->getData());
            if ($this->MiddlewareLogs->save($middlewareLog)) {
                $this->Flash->success(__('The middleware log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The middleware log could not be saved. Please, try again.'));
        }
        $users = $this->MiddlewareLogs->Users->find('list', ['limit' => 200]);
        $this->set(compact('middlewareLog', 'users'));
        $this->set('_serialize', ['middlewareLog']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Middleware Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $middlewareLog = $this->MiddlewareLogs->get($id);
        if ($this->MiddlewareLogs->delete($middlewareLog)) {
            $this->Flash->success(__('The middleware log has been deleted.'));
        } else {
            $this->Flash->error(__('The middleware log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
