<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BinaryComponents Controller
 *
 * @property \App\Model\Table\BinaryComponentsTable $BinaryComponents
 */
class BinaryComponentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $binaryComponents = $this->paginate($this->BinaryComponents);

        $this->set(compact('binaryComponents'));
        $this->set('_serialize', ['binaryComponents']);
    }

    /**
     * View method
     *
     * @param string|null $id Binary Component id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $binaryComponent = $this->BinaryComponents->get($id, [
            'contain' => ['Ypois']
        ]);

        $this->set('binaryComponent', $binaryComponent);
        $this->set('_serialize', ['binaryComponent']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $binaryComponent = $this->BinaryComponents->newEntity();
        if ($this->request->is('post')) {
            $binaryComponent = $this->BinaryComponents->patchEntity($binaryComponent, $this->request->getData());
            if ($this->BinaryComponents->save($binaryComponent)) {
                $this->Flash->success(__('The binary component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The binary component could not be saved. Please, try again.'));
        }
        $ypois = $this->BinaryComponents->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('binaryComponent', 'ypois'));
        $this->set('_serialize', ['binaryComponent']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Binary Component id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $binaryComponent = $this->BinaryComponents->get($id, [
            'contain' => ['Ypois']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $binaryComponent = $this->BinaryComponents->patchEntity($binaryComponent, $this->request->getData());
            if ($this->BinaryComponents->save($binaryComponent)) {
                $this->Flash->success(__('The binary component has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The binary component could not be saved. Please, try again.'));
        }
        $ypois = $this->BinaryComponents->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('binaryComponent', 'ypois'));
        $this->set('_serialize', ['binaryComponent']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Binary Component id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $binaryComponent = $this->BinaryComponents->get($id);
        if ($this->BinaryComponents->delete($binaryComponent)) {
            $this->Flash->success(__('The binary component has been deleted.'));
        } else {
            $this->Flash->error(__('The binary component could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
