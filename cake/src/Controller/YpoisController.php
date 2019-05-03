<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;

/**
 * Ypois Controller
 *
 * @property \App\Model\Table\YpoisTable $Ypois
 */
class YpoisController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('D3Data');
    }
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

    public function findMatches($displayVariant = null)
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

        // Store filter tokens from URL
        $configuredSelection = NULL;
        // Store filter objects for later filter query
        $filterSelection = NULL;
        // Store filter component sorte by ranking for filter group assignment
        $rankedSelection = NULL;

        if (!empty($this->request->query)) {
            $configuredSelection = $this->request->query;
        }

        // Get all matching ypois or all
        $ypois = (object)[];
        if ($configuredSelection) {


            $filterSelection = $this->buildFilterObject($configuredSelection);
            $rankedSelection = $this->buildRankedSelection($filterSelection);

            $ypois = $this->Ypois->find()->contain(
                [
                    'BinaryComponents' => [  'sort' => ['display_name' => 'ASC', 'name' => 'ASC']    ],
                    'NominalAttributes.NominalComponents',
                    'NominalAttributes' => [  'sort' => ['NominalComponents.display_name' => 'ASC', 'NominalComponents.name' => 'ASC']    ],
                    'OrdinalAttributes' => [  'sort' => ['meter' => 'ASC']   ],
                    'OrdinalAttributes.OrdinalComponents',
                    'OrdinalAttributes.OrdinalComponents.OrdinalAttributes' => [  'sort' => ['OrdinalAttributes.meter' => 'ASC']   ]
                ]);

            // Add not matching binary filters
            if(!empty($filterSelection->notMatchingBinaries)) {
                $ypois = $this->applyNotMatchingBinariesFilter($ypois, $filterSelection);
            }

            // Add matching binray filters
            $binaryJoinConditions = $this->buildBinaryJoinConditions($filterSelection);
            $ypois->join($binaryJoinConditions);

            // Add matching nominal filters
            $nominalJoinConditions = $this->buildNominalJoinConditions($filterSelection);
            $ypois->join($nominalJoinConditions);

            // Add matching ordinal filters
            $ordinalJoinConditions = $this->buildOrdinalJoinConditions($filterSelection);
            $ypois->join($ordinalJoinConditions);

            // Set autoFields for correct joins syntax
            $ypois->enableAutoFields(true);
        } else {
            $ypois = $this->Ypois->find("all")
                ->contain(['BinaryComponents', 'NominalAttributes.NominalComponents', 'OrdinalAttributes.OrdinalComponents']);
        }

        // Build filter wheel data for D3.js sunburst-viz
         $filerWheelJSONData = $this->D3Data->buildComponentWheelSuburstJSONData($ypois, $rankedSelection);
         debug($filerWheelJSONData);

        // Build chord diagram matrix for D3.js
        $chordDiagramMatrixData = [];
        if($displayVariant == "chord") {
            $chordDiagramMatrixData = $this->D3Data->buildChordDiagramMatrixData($ypois, $rankedSelection);
            /*
             *  Create JSON Files, uncomment next part

                debug(json_encode($chordDiagramMatrixData));
                $now = Time::now();
                $now->timezone = 'Europe/Paris';
                debug($now->format('Y-m-d_H-i-s'));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_Adjacency_Matrix.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData));
            */

        }

        $this->set(compact('ypois','criteria', 'criterionNames', 'displayVariant', 'configuredSelection', 'filterSelection', 'rankedSelection', 'filerWheelJSONData', 'chordDiagramMatrixData'));
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

    protected function buildFilterObject($configuredSelection = null) {
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

    protected function buildRankedSelection ($filterSelection = null) {
        $ratingStructure = (object) [
            'binaryComponents' => [],
            'nominalAttributes' => [],
            'ordinalAttributes' => [],
        ];

        $rankedSelection = (object) [];
        $rankedSelection->rating5 = clone $ratingStructure;
        $rankedSelection->rating4 = clone $ratingStructure;
        $rankedSelection->rating3 = clone $ratingStructure;
        $rankedSelection->rating2 = clone $ratingStructure;
        $rankedSelection->rating1 = clone $ratingStructure;
        $rankedSelection->binaryComponentIDs = [];
        $rankedSelection->nominalAttributeIDs = [];
        $rankedSelection->ordinalAttributeIDs = [];

        foreach ($filterSelection->notMatchingBinaries as $notMatchingBinary) {
            $this->ratingBasedAssignment($notMatchingBinary, $rankedSelection, 'binaryComponents');
            array_push($rankedSelection->binaryComponentIDs,$notMatchingBinary->id);
        }

        foreach ($filterSelection->matchingBinaries as $matchingBinary) {
            $this->ratingBasedAssignment($matchingBinary, $rankedSelection, 'binaryComponents');
            array_push($rankedSelection->binaryComponentIDs,$matchingBinary->id);
        }

        foreach ($filterSelection->matchingNominals as $matchingNominalComponent) {
            $matchingNominalAttribute = $matchingNominalComponent->attribute;
            $matchingNominalAttribute->rating = $matchingNominalComponent->rating;
            $this->ratingBasedAssignment($matchingNominalAttribute, $rankedSelection, 'nominalAttributes');
            array_push($rankedSelection->nominalAttributeIDs,$matchingNominalAttribute->id);
        }

        foreach ($filterSelection->matchingOrdinals as $matchingOrdinalComponent) {
            $matchingOrdinalAttribute = $matchingOrdinalComponent->attribute;
            $matchingOrdinalAttribute->rating = $matchingOrdinalComponent->rating;
            $this->ratingBasedAssignment($matchingOrdinalAttribute, $rankedSelection, 'ordinalAttributes');
            array_push($rankedSelection->ordinalAttributeIDs,$matchingOrdinalAttribute->id);
        }

        return $rankedSelection;
    }

    protected function ratingBasedAssignment ($objectToAssign = null, $rankedSelection = null, $type = null) {
        switch ($objectToAssign->rating) {
            case 5:
                $queryObejct = $this->getSingleQueryObject($objectToAssign, $type);
                array_push($rankedSelection->rating5->{$type}, $queryObejct);
                break;
            case 4:
                $queryObejct = $this->getSingleQueryObject($objectToAssign, $type);
                array_push($rankedSelection->rating4->{$type}, $queryObejct);
                break;
            case 3:
                $queryObejct = $this->getSingleQueryObject($objectToAssign, $type);
                array_push($rankedSelection->rating3->{$type}, $queryObejct);
                break;
            case 2:
                $queryObejct = $this->getSingleQueryObject($objectToAssign, $type);
                array_push($rankedSelection->rating2->{$type}, $queryObejct);
                break;
            case 1:
                $queryObejct = $this->getSingleQueryObject($objectToAssign, $type);
                array_push($rankedSelection->rating1->{$type}, $queryObejct);
                break;
        }
    }

    protected function getSingleQueryObject ($objectToAssign = null, $type = null) {
        $queryObject = (object)[];
        switch($type) {
            case 'binaryComponents':
                $queryObject = $this->Ypois->BinaryComponents->get($objectToAssign->id);
                $queryObject->rating = $objectToAssign->rating;
                $queryObject->binaryComponentState = $objectToAssign->binaryComponentState;
                break;

            case 'nominalAttributes':
                $queryObject = $this->Ypois->NominalAttributes->get($objectToAssign->id, [  'contain' => ['NominalComponents'] ]);
                $queryObject->rating = $objectToAssign->rating;
                break;

            case 'ordinalAttributes':
                $queryObject = $this->Ypois->OrdinalAttributes->get($objectToAssign->id, [  'contain' => ['OrdinalComponents.OrdinalAttributes'] ]);
                $queryObject->rating = $objectToAssign->rating;
                break;

        }
        return $queryObject;
    }

    protected function applyNotMatchingBinariesFilter($ypois = null, $filterSelection = null) {
        $orNotMatchingBinaryConditions = ['OR' => []];
        foreach ($filterSelection->notMatchingBinaries as $notMatchingBinary) {
            $newOrCondition = ['BinaryComponents.id' => $notMatchingBinary->id];
            array_push($orNotMatchingBinaryConditions['OR'], $newOrCondition);
        }
        $ypois->notMatching('BinaryComponents', function ($q) use ($orNotMatchingBinaryConditions){
            return $q->where($orNotMatchingBinaryConditions);
        });
        return $ypois;
    }

    protected function buildBinaryJoinConditions($filterSelection = null) {
        $binaryJoinConditions = [];
        foreach ($filterSelection->matchingBinaries as $matchingBinary) {
            $currentAlias = 'bccid_' . $matchingBinary->id;
            $binaryJoinConditions[$currentAlias] = [
                'table' => 'binary_components_ypois',
                'conditions' => [
                    $currentAlias . '.ypoi_id = Ypois.id',
                    $currentAlias  . '.binary_component_id = ' . $matchingBinary->id
                ]
            ];
        }
        return $binaryJoinConditions;
    }

    protected function buildNominalJoinConditions($filterSelection = null) {
        $nominalJoinConditions = [];
        foreach ($filterSelection->matchingNominals as $matchingNominal) {
            $currentAlias = 'ncattrid_' . $matchingNominal->attribute->id;
            $nominalJoinConditions[$currentAlias] = [
                'table' => 'nominal_attributes_ypois',
                'conditions' => [
                    $currentAlias . '.ypoi_id = Ypois.id',
                    $currentAlias  . '.nominal_attribute_id = ' . $matchingNominal->attribute->id
                ]
            ];
        }
        return $nominalJoinConditions;
    }

    protected function buildOrdinalJoinConditions($filterSelection = null) {
        $ordinalJoinConditions = [];
        foreach ($filterSelection->matchingOrdinals as $matchingOrdinal) {
            $currentAlias = 'ncattrid_' . $matchingOrdinal->attribute->id;
            $ordinalJoinConditions[$currentAlias] = [
                'table' => 'ordinal_attributes_ypois',
                'conditions' => [
                    $currentAlias . '.ypoi_id = Ypois.id',
                    $currentAlias  . '.ordinal_attribute_id = ' . $matchingOrdinal->attribute->id
                ]
            ];
        }
        return $ordinalJoinConditions;
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
