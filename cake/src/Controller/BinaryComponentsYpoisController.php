<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BinaryComponentsYpois Controller
 *
 * @property \App\Model\Table\BinaryComponentsYpoisTable $BinaryComponentsYpois
 */
class BinaryComponentsYpoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['BinaryComponents', 'Ypois']
        ];
        $binaryComponentsYpois = $this->paginate($this->BinaryComponentsYpois);

        $this->set(compact('binaryComponentsYpois'));
        $this->set('_serialize', ['binaryComponentsYpois']);
    }

    /**
     * View method
     *
     * @param string|null $id Binary Components Ypois id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $binaryComponentsYpois = $this->BinaryComponentsYpois->get($id, [
            'contain' => ['BinaryComponents', 'Ypois']
        ]);

        $this->set('binaryComponentsYpois', $binaryComponentsYpois);
        $this->set('_serialize', ['binaryComponentsYpois']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $binaryComponentsYpois = $this->BinaryComponentsYpois->newEntity();
        if ($this->request->is('post')) {
            $binaryComponentsYpois = $this->BinaryComponentsYpois->patchEntity($binaryComponentsYpois, $this->request->getData());
            if ($this->BinaryComponentsYpois->save($binaryComponentsYpois)) {
                $this->Flash->success(__('The binary components ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The binary components ypois could not be saved. Please, try again.'));
        }
        $binaryComponents = $this->BinaryComponentsYpois->BinaryComponents->find('list', ['limit' => 200]);
        $ypois = $this->BinaryComponentsYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('binaryComponentsYpois', 'binaryComponents', 'ypois'));
        $this->set('_serialize', ['binaryComponentsYpois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Binary Components Ypois id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $binaryComponentsYpois = $this->BinaryComponentsYpois->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $binaryComponentsYpois = $this->BinaryComponentsYpois->patchEntity($binaryComponentsYpois, $this->request->getData());
            if ($this->BinaryComponentsYpois->save($binaryComponentsYpois)) {
                $this->Flash->success(__('The binary components ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The binary components ypois could not be saved. Please, try again.'));
        }
        $binaryComponents = $this->BinaryComponentsYpois->BinaryComponents->find('list', ['limit' => 200]);
        $ypois = $this->BinaryComponentsYpois->Ypois->find('list', ['limit' => 200]);
        $this->set(compact('binaryComponentsYpois', 'binaryComponents', 'ypois'));
        $this->set('_serialize', ['binaryComponentsYpois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Binary Components Ypois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $binaryComponentsYpois = $this->BinaryComponentsYpois->get($id);
        if ($this->BinaryComponentsYpois->delete($binaryComponentsYpois)) {
            $this->Flash->success(__('The binary components ypois has been deleted.'));
        } else {
            $this->Flash->error(__('The binary components ypois could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
