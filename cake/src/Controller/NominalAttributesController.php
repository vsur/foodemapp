<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NominalAttributes Controller
 *
 * @property \App\Model\Table\NominalAttributesTable $NominalAttributes
 */
class NominalAttributesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['NominalComponents']
        ];
        $nominalAttributes = $this->paginate($this->NominalAttributes);

        $this->set(compact('nominalAttributes'));
        $this->set('_serialize', ['nominalAttributes']);
    }

    /**
     * View method
     *
     * @param string|null $id Nominal Attribute id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nominalAttribute = $this->NominalAttributes->get($id, [
            'contain' => ['NominalComponents', 'Ypois']
        ]);

        $this->set('nominalAttribute', $nominalAttribute);
        $this->set('_serialize', ['nominalAttribute']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nominalAttribute = $this->NominalAttributes->newEntity();
        if ($this->request->is('post')) {
            $nominalAttribute = $this->NominalAttributes->patchEntity($nominalAttribute, $this->request->getData());
            if ($this->NominalAttributes->save($nominalAttribute)) {
                $this->Flash->success(__('The nominal attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal attribute could not be saved. Please, try again.'));
        }
        $nominalComponents = $this->NominalAttributes->NominalComponents->find('list', ['limit' => 200]);
        $ypois = $this->NominalAttributes->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('nominalAttribute', 'nominalComponents', 'ypois'));
        $this->set('_serialize', ['nominalAttribute']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nominal Attribute id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nominalAttribute = $this->NominalAttributes->get($id, [
            'contain' => ['Ypois']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nominalAttribute = $this->NominalAttributes->patchEntity($nominalAttribute, $this->request->getData());
            if ($this->NominalAttributes->save($nominalAttribute)) {
                $this->Flash->success(__('The nominal attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal attribute could not be saved. Please, try again.'));
        }
        $nominalComponents = $this->NominalAttributes->NominalComponents->find('list', ['limit' => 200]);
        $ypois = $this->NominalAttributes->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('nominalAttribute', 'nominalComponents', 'ypois'));
        $this->set('_serialize', ['nominalAttribute']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nominal Attribute id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nominalAttribute = $this->NominalAttributes->get($id);
        if ($this->NominalAttributes->delete($nominalAttribute)) {
            $this->Flash->success(__('The nominal attribute has been deleted.'));
        } else {
            $this->Flash->error(__('The nominal attribute could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
