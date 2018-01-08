<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ypois Controller
 *
 * @property \App\Model\Table\YpoisTable $Ypois
 */
class YpoisController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ypois = $this->paginate($this->Ypois);

        $this->set(compact('ypois'));
        $this->set('_serialize', ['ypois']);
    }

    public function setScenario() {
      $this->viewBuilder()->layout('Fmappbeta');
      // Get all BinaryComponents
      $binaryComponents = $this->Ypois->BinaryComponents->getAllEntriesWithUnifiedDisplayNames();
      // debug($binaryComponents->toArray());

      // Get all $nominalComponents with associated Attributes
      $nominalComponents = $this->Ypois->NominalAttributes->NominalComponents->getAllEntriesWithUnifiedDisplayNames($withNominalAttr = true);

      // Get all OrdinalAttributes
      $ordinalComponents = $this->Ypois->OrdinalAttributes->OrdinalComponents->getAllEntriesWithUnifiedDisplayNames($withNominalAttr = true);

      // Wrap up all criteria
      $criteria = $this->combineAllComponetsToOneCriteriaArray($binaryComponents, $nominalComponents, $ordinalComponents);

      // Set combined criterion names for autocompletion and differentiation
      $criterionNames = [];
      foreach ($criteria as $keyIndex => $criterion) {
        $newEntry = [];
        $criterionType = $criterion->source();
        $criterionTypeAction = "";
        $criterionInitials = "";
        switch ($criterionType) {
          case 'BinaryComponents':
            $criterionTypeAction = "On/Off";
            $criterionInitials = "BC";
            break;

          case 'NominalComponents':
            $criterionTypeAction = "auswählen";
            $criterionInitials = "NC";
            break;

          case 'OrdinalComponents':
            $criterionTypeAction = "einstellen";
            $criterionInitials = "OC";
            break;
        }
        $criterionName = $criterion->display_name . " " . $criterionTypeAction;
        $criterionIdentifier = $criterionInitials . "." . $criterion->id . "#" . $keyIndex;

        array_push($newEntry, $criterionName);
        array_push($newEntry, $criterionIdentifier);

        array_push($criterionNames, $newEntry);
      }
      // debug($criterionNames);

      $this->set(compact('criteria', 'criterionNames'));
    }

    public function combineAllComponetsToOneCriteriaArray($binaryComponents = null, $nominalComponents = null, $ordinalComponents = null) {
        $criteria = [];
        foreach ($binaryComponents as $binaryComponent) {
          $binaryComponent->modelType = $binaryComponent->source();
          array_push($criteria, $binaryComponent);
        }
        foreach ($nominalComponents as $nominalComponent) {
          $nominalComponent->modelType = $nominalComponent->source();
          array_push($criteria, $nominalComponent);
        }
        foreach ($ordinalComponents as $ordinalComponent) {
          $ordinalComponent->modelType = $ordinalComponent->source();
          array_push($criteria, $ordinalComponent);
        }
        // Sort criteria once at the end, assoc hast to be sorted earllier
        foreach ($criteria as $key => $row) {
            $displayName[$key] = $row['display_name'];
        }
        array_multisort($displayName, SORT_ASC, $criteria);
        return $criteria;
    }

    /**
     * View method
     *
     * @param string|null $id Ypois id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ypois = $this->Ypois->get($id, [
            'contain' => ['BinaryComponents', 'NominalAttributes.NominalComponents', 'OrdinalAttributes.OrdinalComponents']
        ]);

        $this->set('ypois', $ypois);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ypois = $this->Ypois->newEntity();
        if ($this->request->is('post')) {
            $ypois = $this->Ypois->patchEntity($ypois, $this->request->getData());
            if ($this->Ypois->save($ypois)) {
                $this->Flash->success(__('The ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ypois could not be saved. Please, try again.'));
        }
        $binaryComponents = $this->Ypois->BinaryComponents->find('list', ['limit' => 200]);
        $nominalAttributes = $this->Ypois->NominalAttributes->find('list', ['limit' => 200]);
        $ordinalAttributes = $this->Ypois->OrdinalAttributes->find('list', ['limit' => 200]);
        $this->set(compact('ypois', 'binaryComponents', 'nominalAttributes', 'ordinalAttributes'));
        $this->set('_serialize', ['ypois']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ypois id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ypois = $this->Ypois->get($id, [
            'contain' => ['BinaryComponents', 'NominalAttributes', 'OrdinalAttributes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ypois = $this->Ypois->patchEntity($ypois, $this->request->getData());
            if ($this->Ypois->save($ypois)) {
                $this->Flash->success(__('The ypois has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ypois could not be saved. Please, try again.'));
        }
        $binaryComponents = $this->Ypois->BinaryComponents->find('list', ['limit' => 200]);
        $nominalAttributes = $this->Ypois->NominalAttributes->find('list', ['limit' => 200]);
        $ordinalAttributes = $this->Ypois->OrdinalAttributes->find('list', ['limit' => 200]);
        $this->set(compact('ypois', 'binaryComponents', 'nominalAttributes', 'ordinalAttributes'));
        $this->set('_serialize', ['ypois']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ypois id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ypois = $this->Ypois->get($id);
        if ($this->Ypois->delete($ypois)) {
            $this->Flash->success(__('The ypois has been deleted.'));
        } else {
            $this->Flash->error(__('The ypois could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
