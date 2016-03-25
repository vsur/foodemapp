<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pois Controller
 *
 * @property \App\Model\Table\PoisTable $Pois
 */
class PoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $pois = $this->paginate($this->Pois);

        $this->set(compact('pois'));
        $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matches() {
      if( $this->request->is('get') ) {
        debug($this->request->query);
        $arrRes = (array)$this->request->query;
        debug($_GET);
      }
      $queryCondition =  array();
      $this->viewBuilder()->layout('Foodmapp');
      /*

GROSSE NOTIZ

Also CONTAIN Wirks sich nur auf hinzuzufügenden Associations aus!!!
Heißt filtere ich die Cotains, dann werden eben nur passende Components oder Stages hinzugefüft!

Ich Will uneingeschränkte Cotains haben!!!

Heißt ich muss über Matchiing gehen!

Sprich hier http://book.cakephp.org/3.0/en/orm/query-builder.html#filtering-by-associated-data

      */
      // $pois = $this->Pois->find('all', [
      //     'contain' => ['Components', 'Stages']
      // ]);
      // Restict Contain
      $pois = $this->Pois->find()
        ->contain([
          'Components' => function ($q) {
            return $q
              ->where(['Components.name' => 'Bier']);
          }
        // ])
        // ->contain([
        //   'Stages' => function ($q) {
        //     return $q
        //       ->where(['Stages.rating >' => 5.0]);
        //   }
        ]);

      // where([
      //         'author_id' => 3,
      //         'OR' => [['view_count' => 2], ['view_count' => 3]],
      //     ]);

      // debug($query->toArray());

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * View method
     *
     * @param string|null $id Pois id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pois = $this->Pois->get($id, [
            'contain' => ['Tags', 'Components']
        ]);

        $this->set('pois', $pois);
        $this->set('_serialize', ['pois']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pois = $this->Pois->newEntity();
        if ($this->request->is('post')) {
            $pois = $this->Pois->patchEntity($pois, $this->request->data);
            if ($this->Pois->save($pois)) {
                $this->Flash->success(__('The pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois could not be saved. Please, try again.'));
            }
        }
        $tags = $this->Pois->Tags->find('list', ['limit' => 200]);
        $this->set(compact('pois', 'tags'));
        $this->set('_serialize', ['pois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pois id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pois = $this->Pois->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pois = $this->Pois->patchEntity($pois, $this->request->data);
            if ($this->Pois->save($pois)) {
                $this->Flash->success(__('The pois has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The pois could not be saved. Please, try again.'));
            }
        }
        $tags = $this->Pois->Tags->find('list', ['limit' => 200]);
        $this->set(compact('pois', 'tags'));
        $this->set('_serialize', ['pois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pois = $this->Pois->get($id);
        if ($this->Pois->delete($pois)) {
            $this->Flash->success(__('The pois has been deleted.'));
        } else {
            $this->Flash->error(__('The pois could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
