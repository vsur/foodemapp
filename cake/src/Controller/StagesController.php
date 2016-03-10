<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Stages Controller
 *
 * @property \App\Model\Table\StagesTable $Stages
 */
class StagesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Components', 'Locations']
        ];
        $this->set('stages', $this->paginate($this->Stages));
        $this->set('_serialize', ['stages']);
    }

    /**
     * View method
     *
     * @param string|null $id Stage id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stage = $this->Stages->get($id, [
            'contain' => ['Components', 'Locations']
        ]);
        $this->set('stage', $stage);
        $this->set('_serialize', ['stage']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stage = $this->Stages->newEntity();
        if ($this->request->is('post')) {
            $stage = $this->Stages->patchEntity($stage, $this->request->data);
            if ($this->Stages->save($stage)) {
                $this->Flash->success(__('The stage has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The stage could not be saved. Please, try again.'));
            }
        }
        $components = $this->Stages->Components->find('list', ['limit' => 200]);
        $locations = $this->Stages->Locations->find('list', ['limit' => 200]);
        $this->set(compact('stage', 'components', 'locations'));
        $this->set('_serialize', ['stage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Stage id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stage = $this->Stages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stage = $this->Stages->patchEntity($stage, $this->request->data);
            if ($this->Stages->save($stage)) {
                $this->Flash->success(__('The stage has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The stage could not be saved. Please, try again.'));
            }
        }
        $components = $this->Stages->Components->find('list', ['limit' => 200]);
        $locations = $this->Stages->Locations->find('list', ['limit' => 200]);
        $this->set(compact('stage', 'components', 'locations'));
        $this->set('_serialize', ['stage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Stage id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stage = $this->Stages->get($id);
        if ($this->Stages->delete($stage)) {
            $this->Flash->success(__('The stage has been deleted.'));
        } else {
            $this->Flash->error(__('The stage could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
