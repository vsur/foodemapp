<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrdinalAttributesYpois Controller
 *
 * @property \App\Model\Table\OrdinalAttributesYpoisTable $OrdinalAttributesYpois
 */
class OrdinalAttributesYpoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OrdinalAttributes', 'Ypois']
        ];
        $ordinalAttributesYpois = $this->paginate($this->OrdinalAttributesYpois);

        $this->set(compact('ordinalAttributesYpois'));
        $this->set('_serialize', ['ordinalAttributesYpois']);
    }

    /**
     * View method
     *
     * @param string|null $id Ordinal Attributes Ypois id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordinalAttributesYpois = $this->OrdinalAttributesYpois->get($id, [
            'contain' => ['OrdinalAttributes', 'Ypois']
        ]);

        $this->set('ordinalAttributesYpois', $ordinalAttributesYpois);
        $this->set('_serialize', ['ordinalAttributesYpois']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordinalAttributesYpois = $this->OrdinalAttributesYpois->newEntity();
        if ($this->request->is('post')) {
            $ordinalAttributesYpois = $this->OrdinalAttributesYpois->patchEntity($ordinalAttributesYpois, $this->request->getData());
            if ($this->OrdinalAttributesYpois->save($ordinalAttributesYpois)) {
                $this->Flash->success(__('The ordinal attributes ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal attributes ypois could not be saved. Please, try again.'));
        }
        $ordinalAttributes = $this->OrdinalAttributesYpois->OrdinalAttributes->find('list', ['limit' => 200]);
        $ypois = $this->OrdinalAttributesYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('ordinalAttributesYpois', 'ordinalAttributes', 'ypois'));
        $this->set('_serialize', ['ordinalAttributesYpois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ordinal Attributes Ypois id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordinalAttributesYpois = $this->OrdinalAttributesYpois->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordinalAttributesYpois = $this->OrdinalAttributesYpois->patchEntity($ordinalAttributesYpois, $this->request->getData());
            if ($this->OrdinalAttributesYpois->save($ordinalAttributesYpois)) {
                $this->Flash->success(__('The ordinal attributes ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal attributes ypois could not be saved. Please, try again.'));
        }
        $ordinalAttributes = $this->OrdinalAttributesYpois->OrdinalAttributes->find('list', ['limit' => 200]);
        $ypois = $this->OrdinalAttributesYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('ordinalAttributesYpois', 'ordinalAttributes', 'ypois'));
        $this->set('_serialize', ['ordinalAttributesYpois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ordinal Attributes Ypois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordinalAttributesYpois = $this->OrdinalAttributesYpois->get($id);
        if ($this->OrdinalAttributesYpois->delete($ordinalAttributesYpois)) {
            $this->Flash->success(__('The ordinal attributes ypois has been deleted.'));
        } else {
            $this->Flash->error(__('The ordinal attributes ypois could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
