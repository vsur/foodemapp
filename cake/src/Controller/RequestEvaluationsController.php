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
    public function index($key = null)
    {
        $this->checkAccess($key);
        $this->viewBuilder()->layout('fmappbeta');
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
    public function view($id = null, $key = null)
    {
        $this->checkAccess($key);
        $requestEvaluation = $this->RequestEvaluations->get($id, [
            'contain' => []
        ]);

        $this->set('requestEvaluation', $requestEvaluation);
        $this->set('_serialize', ['requestEvaluation']);
    }

    public function new($key = null, $commingFromView = null)
    {
        $this->viewBuilder()->layout('fmappbeta');
        $this->checkAccess($key);
        // Check if geolocation is set
        $session = $this->request->session();
        // $session->destroy();  // Uncoment for Debug Purposes
        if ($session->check('Config.geolocation')) {
            $sortByGeo = true;
            $distanceSelectQueryString = '6371 * acos (
                cos ( radians(' . $session->read("Config.geolocation.latitude") . ') )
                * cos( radians( lat ) )
                * cos( radians( lng ) - radians(' . $session->read("Config.geolocation.longitude") . ') )
                + sin ( radians(' .  $session->read("Config.geolocation.latitude") . ') )
                * sin( radians( lat ) )
              )';
        }

        $this->loadModel('Ypois');
        $filterSelection = $this->Ypois->buildFilterObject($this->request->query);
        // $ypois = $this->Ypois->findYpoisByConfiguredSelection($filterSelection, $sortByGeo, $distanceSelectQueryString);
        $ypois = $this->Ypois->findYpoisByConfiguredSelection($filterSelection);
        $ypois = $this->Ypois->getYpoisOrderedByAssocCount($ypois);
        $overallComponentCount = $this->PoisNComponents->allComponentsCount($ypois);

        $requestEvaluation = $this->RequestEvaluations->newEntity();
        if ($this->request->is('post')) {
            $requestEvaluation = $this->RequestEvaluations->patchEntity($requestEvaluation, $this->request->getData());
            if ($this->RequestEvaluations->save($requestEvaluation)) {
                $this->Flash->success(__('Ihre Bewerrung wurde gespeichert'));

                return $this->redirect( ["controller" => "ypois", "action" => "findMatches", "selectViz", "?" => $this->request->query] );
            }
            $this->Flash->error(__('The request evaluation could not be saved. Please, try again.'));
        }
        $this->set(compact('requestEvaluation', 'ypois', 'overallComponentCount', 'commingFromView'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Request Evaluation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $key = null)
    {
        $this->checkAccess($key);
        $this->request->allowMethod(['post', 'delete']);
        $requestEvaluation = $this->RequestEvaluations->get($id);
        if ($this->RequestEvaluations->delete($requestEvaluation)) {
            $this->Flash->success(__('The request evaluation has been deleted.'));
        } else {
            $this->Flash->error(__('The request evaluation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', 'doStuff']);
    }
}
