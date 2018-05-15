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

    public function setScenario()
    {
        $this->viewBuilder()->layout('Fmappbeta');
        // Get all BinaryComponents
        $binaryComponents = $this->Ypois->BinaryComponents->getAllEntriesWithUnifiedDisplayNames();

        // Get all $nominalComponents with associated Attributes
        $nominalComponents = $this->Ypois->NominalAttributes->NominalComponents->getAllEntriesWithUnifiedDisplayNamesAndIconsPaths($withNominalAttr = true);

        // Get all OrdinalAttributes
        $ordinalComponents = $this->Ypois->OrdinalAttributes->OrdinalComponents->getAllEntriesWithUnifiedDisplayNames($withNominalAttr = true);

        // Wrap up all criteria
        $criteria = $this->combineAllComponetsToOneCriteriaArray($binaryComponents, $nominalComponents, $ordinalComponents);

        // Set combined criterion names for autocompletion and differentiation
        $criterionNames = $this->setCombinedCriterionNames($criteria);

        $configuredSelection = NULL;
        if (!empty($this->request->query)) {
            $configuredSelection = $this->request->query;
        }

        $this->set(compact('criteria', 'criterionNames', 'configuredSelection'));
    }

    public function findMatches()
    {
        $this->viewBuilder()->layout('Fmappbeta');
        // Get all BinaryComponents
        $binaryComponents = $this->Ypois->BinaryComponents->getAllEntriesWithUnifiedDisplayNames();
        // debug($binaryComponents->toArray());

        // Get all $nominalComponents with associated Attributes
        $nominalComponents = $this->Ypois->NominalAttributes->NominalComponents->getAllEntriesWithUnifiedDisplayNamesAndIconsPaths($withNominalAttr = true);

        // Get all OrdinalAttributes
        $ordinalComponents = $this->Ypois->OrdinalAttributes->OrdinalComponents->getAllEntriesWithUnifiedDisplayNames($withNominalAttr = true);

        // Wrap up all criteria
        $criteria = $this->combineAllComponetsToOneCriteriaArray($binaryComponents, $nominalComponents, $ordinalComponents);

        // Set combined criterion names for autocompletion and differentiation
        $criterionNames = $this->setCombinedCriterionNames($criteria);

        $configuredSelection = NULL;
        if (!empty($this->request->query)) {
            $configuredSelection = $this->request->query;
        }

        // Get all matching ypois or all
        $ypois = (object)[];
        if ($configuredSelection) {


            $filerSelection = $this->buildFilterObjectFromSelection($configuredSelection);

            debug($filerSelection);

            $ypois = $this->Ypois->find()->contain(['BinaryComponents', 'NominalAttributes.NominalComponents', 'OrdinalAttributes.OrdinalComponents']);

            // Add not matching binary filters
            if(!empty($filerSelection->notMatchingBinaries)) {
                $orNotMatchingBinaryConditions = ['OR' => []];
                foreach ($filerSelection->notMatchingBinaries as $notMatchingBinary) {
                    $newOrCondition = ['BinaryComponents.id' => $notMatchingBinary->id];
                    array_push($orNotMatchingBinaryConditions['OR'], $newOrCondition);
                }
                $ypois->notMatching('BinaryComponents', function ($q) use ($orNotMatchingBinaryConditions){
                    return $q->where($orNotMatchingBinaryConditions);
                });
            }

            // Add matching binray filters
            $binaryJoinConditions = [];
            foreach ($filerSelection->matchingBinaries as $matchingBinary) {
                $currentAlias = 'bccid_' . $matchingBinary->id;
                $binaryJoinConditions[$currentAlias] = [
                    'table' => 'binary_components_ypois',
                    'conditions' => [
                        $currentAlias . '.ypoi_id = Ypois.id',
                        $currentAlias  . '.binary_component_id = ' . $matchingBinary->id
                    ]
                ];
            }
            $ypois->join($binaryJoinConditions);

            // Add matching nominal filters
            $nominalJoinConditions = [];
            foreach ($filerSelection->matchingNominals as $matchingNominal) {
                $currentAlias = 'ncattrid_' . $matchingNominal->attribute->id;
                $nominalJoinConditions[$currentAlias] = [
                    'table' => 'nominal_attributes_ypois',
                    'conditions' => [
                        $currentAlias . '.ypoi_id = Ypois.id',
                        $currentAlias  . '.nominal_attribute_id = ' . $matchingNominal->attribute->id
                    ]
                ];
            }
            $ypois->join($nominalJoinConditions);


                /*
                 * JOIN ON Nominal Attributes
                 */
//                ->join([
//                    'noca_5' => [
//                        'table' => 'nominal_attributes_ypois',
//                        'conditions' =>
//                            [
//                                'noca_5.ypoi_id = Ypois.id',
//                                'noca_5.nominal_attribute_id = 26',
//                            ]
//                    ],
//                    'noca_2' => [
//                        'table' => 'nominal_attributes_ypois',
//                        'conditions' =>
//                            [
//                                'noca_2.ypoi_id = Ypois.id',
//                                'noca_2.nominal_attribute_id = 38',
//                            ]
//                    ]
//                ])

                /*
                 * JOIN ON Ordinal Attributes
                ->join([
                    'orca_2' => [
                        'table' => 'ordinal_attributes_ypois',
                        'conditions' =>
                            [
                                'orca_2.ypoi_id = Ypois.id',
                                'orca_2.ordinal_attribute_id = 2',
                            ]
                    ],
                    'orca_11' => [
                        'table' => 'ordinal_attributes_ypois',
                        'conditions' =>
                            [
                                'orca_11.ypoi_id = Ypois.id',
                                'orca_11.ordinal_attribute_id = 11',
                            ]
                    ],

                ])
                 */

                $ypois->enableAutoFields(true);
        } else {
            $ypois = $this->Ypois->find("all")
                ->contain(['BinaryComponents', 'NominalAttributes.NominalComponents', 'OrdinalAttributes.OrdinalComponents']);
        }

        $this->set(compact('ypois', 'criteria', 'criterionNames', 'configuredSelection'));
    }

    protected function combineAllComponetsToOneCriteriaArray($binaryComponents = null, $nominalComponents = null, $ordinalComponents = null)
    {
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

    protected function setCombinedCriterionNames($criteria = null)
    {
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
            // Selection list must have the criterions ID and the exact index of combineAllComponetsToOneCriteriaArray
            // _C-ID_ Prefix for _ Component ID _ in combination with Repo-Source the criterion can be identified
            // _ALLC-ID_ Prefix for _ AllComponetsToOneCriteriaArray Index _ to get find data again later
            $criterionIdentifier = $criterionInitials . "_C-ID_" . $criterion->id . "_ALLC-ID_" . $keyIndex;

            array_push($newEntry, $criterionName);
            array_push($newEntry, $criterionIdentifier);

            array_push($criterionNames, $newEntry);
        }
        return $criterionNames;
    }

    protected function buildFilterObjectFromSelection($configuredSelection = null) {
        /* Example $confugredSelection
            [
                'BC_C-ID_79_BC-STATE_1' => '5',
                'NC_C-ID_1_NCATTR-ID_2' => '4',
                'OC_C-ID_2_OCATTR-ID_6' => '2'
            ]
        */
        $filters = (object)[];
        $filters->notMatchingBinaries = [];
        $filters->matchingBinaries = [];
        $filters->matchingNominals = [];
        $filters->matchingOrdinals = [];

        foreach ($configuredSelection as $combinedComponentString => $componentRating) {
            switch (true) {
                case strstr($combinedComponentString,'BC_C-ID_'):
                    // Build and fill matchingBinaries and notMatchingBinaries
                    $settedComponent = $this->rebuildIdsFromString($combinedComponentString, 'BC_C-ID_');
                    $settedComponent->rating = $componentRating;
                    if ($settedComponent->binaryComponentState) {
                        array_push($filters->matchingBinaries, $settedComponent);
                    } else {
                        array_push($filters->notMatchingBinaries, $settedComponent);
                    }
                    break;
                case strstr($combinedComponentString,'_NCATTR-ID_'):
                    // Build and fill matchingNominals
                    $settedComponent = $this->rebuildIdsFromString($combinedComponentString, 'NC_C-ID_');
                    $settedComponent->rating = $componentRating;
                    array_push($filters->matchingNominals, $settedComponent);
                    break;
                case strstr($combinedComponentString,'_OCATTR-ID_'):
                    // Build and fill matchingOrdinals
                    $settedComponent = $this->rebuildIdsFromString($combinedComponentString, 'OC_C-ID_');
                    $settedComponent->rating = $componentRating;
                    array_push($filters->matchingOrdinals, $settedComponent);
                    break;
            }

        }

        return $filters;
    }

    protected function rebuildIdsFromString($combinedComponentString = null, $componentIdentifierString = null) {
        // Set string position of id-identifier
        $idStart = strlen($componentIdentifierString);
        // Create object to store reslults
        $currentSettedComponent = (object) [];

        switch ($componentIdentifierString) {
            case 'BC_C-ID_':
                // Set sting position after id
                $idEnd = strrpos($combinedComponentString, '_BC-STATE_');
                // Set length of current id
                $idLength = $idEnd - $idStart;
                // Slice id from string
                $compnentId = substr($combinedComponentString, $idStart, $idLength);
                // Set sting position of state-identifier
                $stateEnd = $idEnd + strlen('_BC-STATE_');
                // Slice state value from string
                $bcState = substr($combinedComponentString, $stateEnd) === '1' ? true : false;
                // Set properties
                $currentSettedComponent->id = $compnentId;
                $currentSettedComponent->binaryComponentState = $bcState;
                break;

            case 'NC_C-ID_':
                // Set sting position after component id
                $idEnd = strrpos($combinedComponentString, '_NCATTR-ID_');
                // Set length of current component id
                $idLength = $idEnd - $idStart;
                // Slice id from string
                $compnentId = substr($combinedComponentString, $idStart, $idLength);
                // Set sting position of state-identifier
                $attributeStart = $idEnd + strlen('_NCATTR-ID_');
                // Slice attribute id from string
                $attributeId = substr($combinedComponentString, $attributeStart);
                // Set properties
                $currentSettedComponent->id = $compnentId;
                $currentSettedComponent->attribute = (object)['id' => $attributeId];
                break;

            case 'OC_C-ID_':
                // Set sting position after component id
                $idEnd = strrpos($combinedComponentString, '_OCATTR-ID_');
                // Set length of current component id
                $idLength = $idEnd - $idStart;
                // Slice id from string
                $compnentId = substr($combinedComponentString, $idStart, $idLength);
                // Set sting position of state-identifier
                $attributeStart = $idEnd + strlen('_OCATTR-ID_');
                // Slice attribute id from string
                $attributeId = substr($combinedComponentString, $attributeStart);
                // Set properties
                $currentSettedComponent->id = $compnentId;
                $currentSettedComponent->attribute = (object)['id' => $attributeId];
                break;

        }
        return $currentSettedComponent;
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
