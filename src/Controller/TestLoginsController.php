<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TestLogins Controller
 *
 * @property \App\Model\Table\TestLoginsTable $TestLogins */
class TestLoginsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $testLogins = $this->paginate($this->TestLogins);

        $this->set(compact('testLogins'));
        $this->set('_serialize', ['testLogins']);
    }

    /**
     * View method
     *
     * @param string|null $id Test Login id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $testLogin = $this->TestLogins->get($id, [
            'contain' => []
        ]);

        $this->set('testLogin', $testLogin);
        $this->set('_serialize', ['testLogin']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $testLogin = $this->TestLogins->newEntity();
        if ($this->request->is('post')) {
            $testLogin = $this->TestLogins->patchEntity($testLogin, $this->request->getData());
            if ($this->TestLogins->save($testLogin)) {
                $this->Flash->success(__('The test login has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test login could not be saved. Please, try again.'));
        }
        $this->set(compact('testLogin'));
        $this->set('_serialize', ['testLogin']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Test Login id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $testLogin = $this->TestLogins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $testLogin = $this->TestLogins->patchEntity($testLogin, $this->request->getData());
            if ($this->TestLogins->save($testLogin)) {
                $this->Flash->success(__('The test login has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test login could not be saved. Please, try again.'));
        }
        $this->set(compact('testLogin'));
        $this->set('_serialize', ['testLogin']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Test Login id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $testLogin = $this->TestLogins->get($id);
        if ($this->TestLogins->delete($testLogin)) {
            $this->Flash->success(__('The test login has been deleted.'));
        } else {
            $this->Flash->error(__('The test login could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
