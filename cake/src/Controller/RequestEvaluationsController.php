<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequestEvaluations Controller
 *
 * @property \App\Model\Table\RequestEvaluationsTable $RequestEvaluations
 */
class RequestEvaluationsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('PoisNComponents');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $requestEvaluations = $this->paginate($this->RequestEvaluations);

        $this->set(compact('requestEvaluations'));
        $this->set('_serialize', ['requestEvaluations']);
    }

    /**
     * View method
     *
     * @param string|null $id Request Evaluation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requestEvaluation = $this->RequestEvaluations->get($id, [
            'contain' => []
        ]);

        $this->set('requestEvaluation', $requestEvaluation);
        $this->set('_serialize', ['requestEvaluation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->viewBuilder()->layout('fmappbeta');

        $requestEvaluation = $this->RequestEvaluations->newEntity();
        if ($this->request->is('post')) {
            $requestEvaluation = $this->RequestEvaluations->patchEntity($requestEvaluation, $this->request->getData());
            if ($this->RequestEvaluations->save($requestEvaluation)) {
                $this->Flash->success(__('The request evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request evaluation could not be saved. Please, try again.'));
        }
        $this->set(compact('requestEvaluation'));
        $this->set('_serialize', ['requestEvaluation']);
    }

    public function new()
    {
        $this->viewBuilder()->layout('fmappbeta');
        
        $this->loadModel('Ypois');
        $filterSelection = $this->Ypois->buildFilterObject($this->request->query);
        $ypois = $this->Ypois->findYpoisByConfiguredSelection($filterSelection);
        $overallComponentCount = $this->PoisNComponents->allComponentsCount($ypois);
        
        $requestEvaluation = $this->RequestEvaluations->newEntity();
        if ($this->request->is('post')) {
            $requestEvaluation = $this->RequestEvaluations->patchEntity($requestEvaluation, $this->request->getData());
            if ($this->RequestEvaluations->save($requestEvaluation)) {
                $this->Flash->success(__('The request evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request evaluation could not be saved. Please, try again.'));
        }
        $this->set(compact('requestEvaluation', 'ypois', 'overallComponentCount'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Request Evaluation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requestEvaluation = $this->RequestEvaluations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestEvaluation = $this->RequestEvaluations->patchEntity($requestEvaluation, $this->request->getData());
            if ($this->RequestEvaluations->save($requestEvaluation)) {
                $this->Flash->success(__('The request evaluation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request evaluation could not be saved. Please, try again.'));
        }
        $this->set(compact('requestEvaluation'));
        $this->set('_serialize', ['requestEvaluation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Request Evaluation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requestEvaluation = $this->RequestEvaluations->get($id);
        if ($this->RequestEvaluations->delete($requestEvaluation)) {
            $this->Flash->success(__('The request evaluation has been deleted.'));
        } else {
            $this->Flash->error(__('The request evaluation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
