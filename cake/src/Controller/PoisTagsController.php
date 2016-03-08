<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PoisTags Controller
 *
 * @property \App\Model\Table\PoisTagsTable $PoisTags
 */
class PoisTagsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pois', 'Tags']
        ];
        $this->set('poisTags', $this->paginate($this->PoisTags));
        $this->set('_serialize', ['poisTags']);
    }

    /**
     * View method
     *
     * @param string|null $id Pois Tag id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $poisTag = $this->PoisTags->get($id, [
            'contain' => ['Pois', 'Tags']
        ]);
        $this->set('poisTag', $poisTag);
        $this->set('_serialize', ['poisTag']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $poisTag = $this->PoisTags->newEntity();
        if ($this->request->is('post')) {
            $poisTag = $this->PoisTags->patchEntity($poisTag, $this->request->data);
            if ($this->PoisTags->save($poisTag)) {
                $this->Flash->success(__('The pois tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois tag could not be saved. Please, try again.'));
            }
        }
        $pois = $this->PoisTags->Pois->find('list', ['limit' => 200]);
        $tags = $this->PoisTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('poisTag', 'pois', 'tags'));
        $this->set('_serialize', ['poisTag']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pois Tag id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $poisTag = $this->PoisTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $poisTag = $this->PoisTags->patchEntity($poisTag, $this->request->data);
            if ($this->PoisTags->save($poisTag)) {
                $this->Flash->success(__('The pois tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois tag could not be saved. Please, try again.'));
            }
        }
        $pois = $this->PoisTags->Pois->find('list', ['limit' => 200]);
        $tags = $this->PoisTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('poisTag', 'pois', 'tags'));
        $this->set('_serialize', ['poisTag']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pois Tag id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $poisTag = $this->PoisTags->get($id);
        if ($this->PoisTags->delete($poisTag)) {
            $this->Flash->success(__('The pois tag has been deleted.'));
        } else {
            $this->Flash->error(__('The pois tag could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
