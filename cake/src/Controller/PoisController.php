<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pois Controller
 *
 * @property \App\Model\Table\PoisTable $Pois
 */
class PoisController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('pois', $this->paginate($this->Pois));
        $this->set('_serialize', ['pois']);
    }

    /**
     * View method
     *
     * @param string|null $id Pois id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pois = $this->Pois->get($id, [
            'contain' => ['Components', 'Tags']
        ]);
        $this->set('pois', $pois);
        $this->set('_serialize', ['pois']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pois = $this->Pois->newEntity();
        if ($this->request->is('post')) {
            $pois = $this->Pois->patchEntity($pois, $this->request->data);
            if ($this->Pois->save($pois)) {
                $this->Flash->success(__('The pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois could not be saved. Please, try again.'));
            }
        }
        $components = $this->Pois->Components->find('list', ['limit' => 200]);
        $tags = $this->Pois->Tags->find('list', ['limit' => 200]);
        $this->set(compact('pois', 'components', 'tags'));
        $this->set('_serialize', ['pois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pois id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pois = $this->Pois->get($id, [
            'contain' => ['Components', 'Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pois = $this->Pois->patchEntity($pois, $this->request->data);
            if ($this->Pois->save($pois)) {
                $this->Flash->success(__('The pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois could not be saved. Please, try again.'));
            }
        }
        $components = $this->Pois->Components->find('list', ['limit' => 200]);
        $tags = $this->Pois->Tags->find('list', ['limit' => 200]);
        $this->set(compact('pois', 'components', 'tags'));
        $this->set('_serialize', ['pois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pois = $this->Pois->get($id);
        if ($this->Pois->delete($pois)) {
            $this->Flash->success(__('The pois has been deleted.'));
        } else {
            $this->Flash->error(__('The pois could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
