<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrdinalAttributes Controller
 *
 * @property \App\Model\Table\OrdinalAttributesTable $OrdinalAttributes
 */
class OrdinalAttributesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['OrdinalComponents']
        ];
        $ordinalAttributes = $this->paginate($this->OrdinalAttributes);

        $this->set(compact('ordinalAttributes'));
        $this->set('_serialize', ['ordinalAttributes']);
    }

    /**
     * View method
     *
     * @param string|null $id Ordinal Attribute id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordinalAttribute = $this->OrdinalAttributes->get($id, [
            'contain' => ['OrdinalComponents', 'Ypois']
        ]);

        $this->set('ordinalAttribute', $ordinalAttribute);
        $this->set('_serialize', ['ordinalAttribute']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordinalAttribute = $this->OrdinalAttributes->newEntity();
        if ($this->request->is('post')) {
            $ordinalAttribute = $this->OrdinalAttributes->patchEntity($ordinalAttribute, $this->request->getData());
            if ($this->OrdinalAttributes->save($ordinalAttribute)) {
                $this->Flash->success(__('The ordinal attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal attribute could not be saved. Please, try again.'));
        }
        $ordinalComponents = $this->OrdinalAttributes->OrdinalComponents->find('list', ['limit' => 200]);
        $ypois = $this->OrdinalAttributes->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('ordinalAttribute', 'ordinalComponents', 'ypois'));
        $this->set('_serialize', ['ordinalAttribute']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ordinal Attribute id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordinalAttribute = $this->OrdinalAttributes->get($id, [
            'contain' => ['Ypois']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordinalAttribute = $this->OrdinalAttributes->patchEntity($ordinalAttribute, $this->request->getData());
            if ($this->OrdinalAttributes->save($ordinalAttribute)) {
                $this->Flash->success(__('The ordinal attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal attribute could not be saved. Please, try again.'));
        }
        $ordinalComponents = $this->OrdinalAttributes->OrdinalComponents->find('list', ['limit' => 200]);
        $ypois = $this->OrdinalAttributes->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('ordinalAttribute', 'ordinalComponents', 'ypois'));
        $this->set('_serialize', ['ordinalAttribute']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ordinal Attribute id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordinalAttribute = $this->OrdinalAttributes->get($id);
        if ($this->OrdinalAttributes->delete($ordinalAttribute)) {
            $this->Flash->success(__('The ordinal attribute has been deleted.'));
        } else {
            $this->Flash->error(__('The ordinal attribute could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
