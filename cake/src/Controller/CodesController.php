<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Codes Controller
 *
 * @property \App\Model\Table\CodesTable $Codes
 *
 * @method \App\Model\Entity\Code[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 40,
            'contain' => ['FieldTypes'],
            'order' => [
                'FieldTypes.name' => 'ASC',
                'Codes.name' => 'ASC'
            ], 
            'sortWhitelist' => [
                'FieldTypes.name', 'Codes.name'
            ] 
        ];
        $codes = $this->paginate($this->Codes);

        $this->set(compact('codes'));
    }

    /**
     * View method
     *
     * @param string|null $id Code id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $code = $this->Codes->get($id, [
            'contain' => ['FieldTypes', 'Participants'],
        ]);

        $this->set('code', $code);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $code = $this->Codes->newEntity();
        if ($this->request->is('post')) {
            $code = $this->Codes->patchEntity($code, $this->request->getData());
            if ($this->Codes->save($code)) {
                $this->Flash->success(__('The code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The code could not be saved. Please, try again.'));
        }
        $fieldTypes = $this->Codes->FieldTypes->find('list', ['limit' => 200]);
        $participants = $this->Codes->Participants->find('list', ['limit' => 200]);
        $this->set(compact('code', 'fieldTypes', 'participants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $code = $this->Codes->get($id, [
            'contain' => ['Participants'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $code = $this->Codes->patchEntity($code, $this->request->getData());
            if ($this->Codes->save($code)) {
                $this->Flash->success(__('The code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The code could not be saved. Please, try again.'));
        }
        $fieldTypes = $this->Codes->FieldTypes->find('list', ['limit' => 200]);
        $participants = $this->Codes->Participants->find('list', ['limit' => 200]);
        $this->set(compact('code', 'fieldTypes', 'participants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $code = $this->Codes->get($id);
        if ($this->Codes->delete($code)) {
            $this->Flash->success(__('The code has been deleted.'));
        } else {
            $this->Flash->error(__('The code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
