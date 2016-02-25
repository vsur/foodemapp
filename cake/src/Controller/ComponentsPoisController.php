<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComponentsPois Controller
 *
 * @property \App\Model\Table\ComponentsPoisTable $ComponentsPois
 */
class ComponentsPoisController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Components', 'Pois']
        ];
        $this->set('componentsPois', $this->paginate($this->ComponentsPois));
        $this->set('_serialize', ['componentsPois']);
    }

    /**
     * View method
     *
     * @param string|null $id Components Pois id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $componentsPois = $this->ComponentsPois->get($id, [
            'contain' => ['Components', 'Pois']
        ]);
        $this->set('componentsPois', $componentsPois);
        $this->set('_serialize', ['componentsPois']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $componentsPois = $this->ComponentsPois->newEntity();
        if ($this->request->is('post')) {
            $componentsPois = $this->ComponentsPois->patchEntity($componentsPois, $this->request->data);
            if ($this->ComponentsPois->save($componentsPois)) {
                $this->Flash->success(__('The components pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The components pois could not be saved. Please, try again.'));
            }
        }
        $components = $this->ComponentsPois->Components->find('list', ['limit' => 200]);
        $pois = $this->ComponentsPois->Pois->find('list', ['limit' => 200]);
        $this->set(compact('componentsPois', 'components', 'pois'));
        $this->set('_serialize', ['componentsPois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Components Pois id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $componentsPois = $this->ComponentsPois->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $componentsPois = $this->ComponentsPois->patchEntity($componentsPois, $this->request->data);
            if ($this->ComponentsPois->save($componentsPois)) {
                $this->Flash->success(__('The components pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The components pois could not be saved. Please, try again.'));
            }
        }
        $components = $this->ComponentsPois->Components->find('list', ['limit' => 200]);
        $pois = $this->ComponentsPois->Pois->find('list', ['limit' => 200]);
        $this->set(compact('componentsPois', 'components', 'pois'));
        $this->set('_serialize', ['componentsPois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Components Pois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $componentsPois = $this->ComponentsPois->get($id);
        if ($this->ComponentsPois->delete($componentsPois)) {
            $this->Flash->success(__('The components pois has been deleted.'));
        } else {
            $this->Flash->error(__('The components pois could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
