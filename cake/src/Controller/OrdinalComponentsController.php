<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OrdinalComponents Controller
 *
 * @property \App\Model\Table\OrdinalComponentsTable $OrdinalComponents
 */
class OrdinalComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ordinalComponents = $this->paginate($this->OrdinalComponents);

        $this->set(compact('ordinalComponents'));
        $this->set('_serialize', ['ordinalComponents']);
    }

    /**
     * View method
     *
     * @param string|null $id Ordinal Component id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ordinalComponent = $this->OrdinalComponents->get($id, [
            'contain' => ['OrdinalAttributes']
        ]);

        $this->set('ordinalComponent', $ordinalComponent);
        $this->set('_serialize', ['ordinalComponent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ordinalComponent = $this->OrdinalComponents->newEntity();
        if ($this->request->is('post')) {
            $ordinalComponent = $this->OrdinalComponents->patchEntity($ordinalComponent, $this->request->getData());
            if ($this->OrdinalComponents->save($ordinalComponent)) {
                $this->Flash->success(__('The ordinal component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal component could not be saved. Please, try again.'));
        }
        $this->set(compact('ordinalComponent'));
        $this->set('_serialize', ['ordinalComponent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ordinal Component id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ordinalComponent = $this->OrdinalComponents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ordinalComponent = $this->OrdinalComponents->patchEntity($ordinalComponent, $this->request->getData());
            if ($this->OrdinalComponents->save($ordinalComponent)) {
                $this->Flash->success(__('The ordinal component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ordinal component could not be saved. Please, try again.'));
        }
        $this->set(compact('ordinalComponent'));
        $this->set('_serialize', ['ordinalComponent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ordinal Component id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ordinalComponent = $this->OrdinalComponents->get($id);
        if ($this->OrdinalComponents->delete($ordinalComponent)) {
            $this->Flash->success(__('The ordinal component has been deleted.'));
        } else {
            $this->Flash->error(__('The ordinal component could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
