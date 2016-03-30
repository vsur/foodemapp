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
    public function matchesPie() {
      $searchParams = [];
      // Check if the query array containing possible params is not empty
      if( !(empty($this->request->query)) ) {
        // Loop thru params and make them accessable
        foreach ($this->request->query as $key => $value) {
          $arr = [
            'name' => $key,
            'rating' => $value/10
          ];
          array_push($searchParams, $arr);
        }
      } else {
        // If query array is empty set var for fetching all data later
        array_push($searchParams, 'findAll');
      }

      $this->viewBuilder()->layout('Foodmapp');

      $pois = $this->Pois->find('all', [
        'contain' => ['Components', 'Stages']
      ]);
      // debug($searchParams);
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Components.Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
            if($i == 0) {
              $q->where([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            } else {
              $q->orWhere([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            }
          }
          // debug($q);
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesBar() {
      $searchParams = [];
      // Check if the query array containing possible params is not empty
      if( !(empty($this->request->query)) ) {
        // Loop thru params and make them accessable
        foreach ($this->request->query as $key => $value) {
          $arr = [
            'name' => $key,
            'rating' => $value/10
          ];
          array_push($searchParams, $arr);
        }
      } else {
        // If query array is empty set var for fetching all data later
        array_push($searchParams, 'findAll');
      }

      $this->viewBuilder()->layout('Foodmapp');

      $pois = $this->Pois->find('all', [
        'contain' => ['Components', 'Stages']
      ]);
      // debug($searchParams);
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Components.Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */

          // VORsicht immer noch falsche Verschachtelung der Statements!

          /*
            V
            O
            R
            S
            I
            C
            H
            T
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
            if($i == 0) {
              $q->where([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            } else {
              $q->orWhere([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            }
          }
          // debug($q);
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesTreemap() {
      $searchParams = [];
      // Check if the query array containing possible params is not empty
      if( !(empty($this->request->query)) ) {
        // Loop thru params and make them accessable
        foreach ($this->request->query as $key => $value) {
          $arr = [
            'name' => $key,
            'rating' => $value/10
          ];
          array_push($searchParams, $arr);
        }
      } else {
        // If query array is empty set var for fetching all data later
        array_push($searchParams, 'findAll');
      }

      $this->viewBuilder()->layout('Foodmapp');

      $pois = $this->Pois->find('all', [
        'contain' => ['Components']
      ]);
      // debug($searchParams);
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages.Components', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
            if($i == 0) {
              $q->where([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            } else {
              $q->orWhere([
                'Stages.rating >' => $searchParams[$i]['rating'],
                'Components.name' => $searchParams[$i]['name']
              ]);
            }
          }
          // debug($q);
          return $q;
        })
        ->limit(3)
        ->distinct(['Pois.id'])
        ;
      }

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
