<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Components Controller
 *
 * @property \App\Model\Table\ComponentsTable $Components
 */
class ComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $components = $this->paginate($this->Components);

        $this->set(compact('components'));
        $this->set('_serialize', ['components']);
    }

    /**
     * View method
     *
     * @param string|null $id Component id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => ['Scenarios', 'Stages']
        ]);

        $this->set('component', $component);
        $this->set('_serialize', ['component']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $component = $this->Components->newEntity();
        if ($this->request->is('post')) {
            $component = $this->Components->patchEntity($component, $this->request->data);
            if ($this->Components->save($component)) {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $scenarios = $this->Components->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('component', 'scenarios'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Component id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $component = $this->Components->get($id, [
            'contain' => ['Scenarios']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $component = $this->Components->patchEntity($component, $this->request->data);
            if ($this->Components->save($component)) {
                $this->Flash->success(__('The component has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The component could not be saved. Please, try again.'));
            }
        }
        $scenarios = $this->Components->Scenarios->find('list', ['limit' => 200]);
        $this->set(compact('component', 'scenarios'));
        $this->set('_serialize', ['component']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Component id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $component = $this->Components->get($id);
        if ($this->Components->delete($component)) {
            $this->Flash->success(__('The component has been deleted.'));
        } else {
            $this->Flash->error(__('The component could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
