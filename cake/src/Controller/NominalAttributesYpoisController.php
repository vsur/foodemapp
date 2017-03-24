<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NominalAttributesYpois Controller
 *
 * @property \App\Model\Table\NominalAttributesYpoisTable $NominalAttributesYpois
 */
class NominalAttributesYpoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['NominalAttributes', 'Ypois']
        ];
        $nominalAttributesYpois = $this->paginate($this->NominalAttributesYpois);

        $this->set(compact('nominalAttributesYpois'));
        $this->set('_serialize', ['nominalAttributesYpois']);
    }

    /**
     * View method
     *
     * @param string|null $id Nominal Attributes Ypois id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nominalAttributesYpois = $this->NominalAttributesYpois->get($id, [
            'contain' => ['NominalAttributes', 'Ypois']
        ]);

        $this->set('nominalAttributesYpois', $nominalAttributesYpois);
        $this->set('_serialize', ['nominalAttributesYpois']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nominalAttributesYpois = $this->NominalAttributesYpois->newEntity();
        if ($this->request->is('post')) {
            $nominalAttributesYpois = $this->NominalAttributesYpois->patchEntity($nominalAttributesYpois, $this->request->getData());
            if ($this->NominalAttributesYpois->save($nominalAttributesYpois)) {
                $this->Flash->success(__('The nominal attributes ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal attributes ypois could not be saved. Please, try again.'));
        }
        $nominalAttributes = $this->NominalAttributesYpois->NominalAttributes->find('list', ['limit' => 200]);
        $ypois = $this->NominalAttributesYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('nominalAttributesYpois', 'nominalAttributes', 'ypois'));
        $this->set('_serialize', ['nominalAttributesYpois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nominal Attributes Ypois id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nominalAttributesYpois = $this->NominalAttributesYpois->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nominalAttributesYpois = $this->NominalAttributesYpois->patchEntity($nominalAttributesYpois, $this->request->getData());
            if ($this->NominalAttributesYpois->save($nominalAttributesYpois)) {
                $this->Flash->success(__('The nominal attributes ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal attributes ypois could not be saved. Please, try again.'));
        }
        $nominalAttributes = $this->NominalAttributesYpois->NominalAttributes->find('list', ['limit' => 200]);
        $ypois = $this->NominalAttributesYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('nominalAttributesYpois', 'nominalAttributes', 'ypois'));
        $this->set('_serialize', ['nominalAttributesYpois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nominal Attributes Ypois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nominalAttributesYpois = $this->NominalAttributesYpois->get($id);
        if ($this->NominalAttributesYpois->delete($nominalAttributesYpois)) {
            $this->Flash->success(__('The nominal attributes ypois has been deleted.'));
        } else {
            $this->Flash->error(__('The nominal attributes ypois could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
