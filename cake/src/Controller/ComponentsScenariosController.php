<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComponentsScenarios Controller
 *
 * @property \App\Model\Table\ComponentsScenariosTable $ComponentsScenarios
 */
class ComponentsScenariosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Components', 'Scenarios']
        ];
        $componentsScenarios = $this->paginate($this->ComponentsScenarios);

        $this->set(compact('componentsScenarios'));
        $this->set('_serialize', ['componentsScenarios']);
    }

    /**
     * View method
     *
     * @param string|null $id Components Scenario id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $componentsScenario = $this->ComponentsScenarios->get($id, [
            'contain' => ['Components', 'Scenarios']
        ]);

        $this->set('componentsScenario', $componentsScenario);
        $this->set('_serialize', ['componentsScenario']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $componentsScenario = $this->ComponentsScenarios->newEntity();
        if ($this->request->is('post')) {
            $componentsScenario = $this->ComponentsScenarios->patchEntity($componentsScenario, $this->request->data);
            if ($this->ComponentsScenarios->save($componentsScenario)) {
                $this->Flash->success(__('The components scenario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The components scenario could not be saved. Please, try again.'));
            }
        }
        $components = $this->ComponentsScenarios->Components->find('list', ['limit' => 200]);
        $scenarios = $this->ComponentsScenarios->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('componentsScenario', 'components', 'scenarios'));
        $this->set('_serialize', ['componentsScenario']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Components Scenario id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $componentsScenario = $this->ComponentsScenarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $componentsScenario = $this->ComponentsScenarios->patchEntity($componentsScenario, $this->request->data);
            if ($this->ComponentsScenarios->save($componentsScenario)) {
                $this->Flash->success(__('The components scenario has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The components scenario could not be saved. Please, try again.'));
            }
        }
        $components = $this->ComponentsScenarios->Components->find('list', ['limit' => 200]);
        $scenarios = $this->ComponentsScenarios->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('componentsScenario', 'components', 'scenarios'));
        $this->set('_serialize', ['componentsScenario']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Components Scenario id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $componentsScenario = $this->ComponentsScenarios->get($id);
        if ($this->ComponentsScenarios->delete($componentsScenario)) {
            $this->Flash->success(__('The components scenario has been deleted.'));
        } else {
            $this->Flash->error(__('The components scenario could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
