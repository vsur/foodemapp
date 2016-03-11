<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Scenarios Controller
 *
 * @property \App\Model\Table\ScenariosTable $Scenarios
 */
class ScenariosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $scenarios = $this->paginate($this->Scenarios);

        $this->set(compact('scenarios'));
        $this->set('_serialize', ['scenarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Scenario id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scenario = $this->Scenarios->get($id, [
            'contain' => ['Components']
        ]);

        $this->set('scenario', $scenario);
        $this->set('_serialize', ['scenario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scenario = $this->Scenarios->newEntity();
        if ($this->request->is('post')) {
            $scenario = $this->Scenarios->patchEntity($scenario, $this->request->data);
            if ($this->Scenarios->save($scenario)) {
                $this->Flash->success(__('The scenario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The scenario could not be saved. Please, try again.'));
            }
        }
        $components = $this->Scenarios->Components->find('list', ['limit' => 200]);
        $this->set(compact('scenario', 'components'));
        $this->set('_serialize', ['scenario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Scenario id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scenario = $this->Scenarios->get($id, [
            'contain' => ['Components']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scenario = $this->Scenarios->patchEntity($scenario, $this->request->data);
            if ($this->Scenarios->save($scenario)) {
                $this->Flash->success(__('The scenario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The scenario could not be saved. Please, try again.'));
            }
        }
        $components = $this->Scenarios->Components->find('list', ['limit' => 200]);
        $this->set(compact('scenario', 'components'));
        $this->set('_serialize', ['scenario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Scenario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scenario = $this->Scenarios->get($id);
        if ($this->Scenarios->delete($scenario)) {
            $this->Flash->success(__('The scenario has been deleted.'));
        } else {
            $this->Flash->error(__('The scenario could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
