<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NominalComponents Controller
 *
 * @property \App\Model\Table\NominalComponentsTable $NominalComponents
 */
class NominalComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $nominalComponents = $this->paginate($this->NominalComponents);

        $this->set(compact('nominalComponents'));
        $this->set('_serialize', ['nominalComponents']);
    }

    /**
     * View method
     *
     * @param string|null $id Nominal Component id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nominalComponent = $this->NominalComponents->get($id, [
            'contain' => ['NominalAttributes']
        ]);

        $this->set('nominalComponent', $nominalComponent);
        $this->set('_serialize', ['nominalComponent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nominalComponent = $this->NominalComponents->newEntity();
        if ($this->request->is('post')) {
            $nominalComponent = $this->NominalComponents->patchEntity($nominalComponent, $this->request->getData());
            if ($this->NominalComponents->save($nominalComponent)) {
                $this->Flash->success(__('The nominal component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal component could not be saved. Please, try again.'));
        }
        $this->set(compact('nominalComponent'));
        $this->set('_serialize', ['nominalComponent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Nominal Component id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nominalComponent = $this->NominalComponents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nominalComponent = $this->NominalComponents->patchEntity($nominalComponent, $this->request->getData());
            if ($this->NominalComponents->save($nominalComponent)) {
                $this->Flash->success(__('The nominal component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The nominal component could not be saved. Please, try again.'));
        }
        $this->set(compact('nominalComponent'));
        $this->set('_serialize', ['nominalComponent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Nominal Component id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nominalComponent = $this->NominalComponents->get($id);
        if ($this->NominalComponents->delete($nominalComponent)) {
            $this->Flash->success(__('The nominal component has been deleted.'));
        } else {
            $this->Flash->error(__('The nominal component could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
