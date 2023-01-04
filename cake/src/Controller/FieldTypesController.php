<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FieldTypes Controller
 *
 * @property \App\Model\Table\FieldTypesTable $FieldTypes
 *
 * @method \App\Model\Entity\FieldType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FieldTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $fieldTypes = $this->paginate($this->FieldTypes);

        $this->set(compact('fieldTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Field Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fieldType = $this->FieldTypes->get($id, [
            'contain' => ['Codes'],
        ]);

        $this->set('fieldType', $fieldType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fieldType = $this->FieldTypes->newEntity();
        if ($this->request->is('post')) {
            $fieldType = $this->FieldTypes->patchEntity($fieldType, $this->request->getData());
            if ($this->FieldTypes->save($fieldType)) {
                $this->Flash->success(__('The field type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The field type could not be saved. Please, try again.'));
        }
        $this->set(compact('fieldType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Field Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fieldType = $this->FieldTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fieldType = $this->FieldTypes->patchEntity($fieldType, $this->request->getData());
            if ($this->FieldTypes->save($fieldType)) {
                $this->Flash->success(__('The field type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The field type could not be saved. Please, try again.'));
        }
        $this->set(compact('fieldType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Field Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fieldType = $this->FieldTypes->get($id);
        if ($this->FieldTypes->delete($fieldType)) {
            $this->Flash->success(__('The field type has been deleted.'));
        } else {
            $this->Flash->error(__('The field type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
