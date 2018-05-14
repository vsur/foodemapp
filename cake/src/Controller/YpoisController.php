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

            $ypois = $this->Ypois->find()
                ->contain(['BinaryComponents', 'NominalAttributes.NominalComponents', 'OrdinalAttributes.OrdinalComponents'])
                /*
                ->notMatching('BinaryComponents', function ($q) {
                    return $q
                        ->where(['BinaryComponents.id' => 77])
                        ->orWhere(['BinaryComponents.id' => 81])
                        ;
                })

                Ein Not Matching auf den Nominalen- bzw Ordinalen-Attributen bleibt erst mal offen.
                Später kann dies noch dazu gebaut werden. Für die Nominal wäre dies tatsächlich sinnvoll, da viele Ypois oft entsprechende Attribute nicht haben – ergo vielleicht zu wenig Ergebnisse zurück geliefert werden.
                Um das Abzufangen müsste man quasi bei ich will Nichtraucher nicht nach diesem Attr suchen sondern eben auf: has NOT die anderen beiden.

                Für die Ordinalen-Attribute macht aber das negieren wahrscheinlich keinen Sinn.

                ->notMatching('NominalAttributes', function ($q) {
                    return $q
                        ->where(['NominalAttributes.id' => 1])
                        ->orWhere(['NominalAttributes.id' => 9])
                        ;
                })
                ->notMatching('OrdinalAttributes', function ($q) {
                    return $q
                        ->where(['OrdinalAttributes.id' => 4])
                        ->orWhere(['OrdinalAttributes.id' => 8])
                        ;
                })
                */

                /*
                 * JOIN ON TRUE Binary Components
                ->join([
                    'a' => [
                        'table' => 'binary_components_ypois',
                        'conditions' =>
                            [
                                'a.ypoi_id = Ypois.id',
                                'a.binary_component_id = 75',
                            ]
                    ],
                    'b' => [
                        'table' => 'binary_components_ypois',
                        'conditions' =>
                            [
                                'b.ypoi_id = Ypois.id',
                                'b.binary_component_id = 80',
                            ]
                    ]
                ])
                 */

                /*
                 * JOIN ON Nominal Attributes
                 */
                ->join([
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
                ])

                /*
                 * JOIN ON Ordinal Attributes
                 */
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
                ->enableAutoFields(true);
            /*
            $rawYpois = $this->Ypois->query('
                SELECT * FROM ypois
                WHERE ypois.id IN (SELECT ypois_id FROM binary_components_ypois WHERE binary_components_id = 3)
            ');
            debug($rawYpois->sql());


            $ypois->matching('BinaryComponents', function ($q) use ($configuredSelection) {
                debug($configuredSelection);
                // return $q->where(['BinaryComponents.id' => $configuredSelection["test"]]);
                return $q->where(function ($exp) use ($configuredSelection) {
                    // Conditions aufbauen
                    $exp
                        ->eq('BinaryComponents.id', $configuredSelection["test"])
                        // ->eq('BinaryComponents.id', 93)
                        ;
                    // $exp->add(['BinaryComponents.id' => $configuredSelection["test"]]);
                    $hasBinaryConditions = $exp;
            // ->eq('author_id', 5);
                    $hasNotBinaryConditions;
                    $hasNominalAttributeConditions;
                    $hasOrdinalAttributeConditions;

                    return $exp->and_([$hasBinaryConditions]);
                });
                */
                /*
                 * Lässt sich das umbauen?
                 * ->where(function (QueryExpression $exp) {
                    return $exp
                        ->eq('author_id', 2)
                        ->eq('published', true)
                        ->notEq('spam', true)
                        ->gt('view_count', 10);
                });
            });
            */
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
                    // TODO Unterscheidung auf Matching/NotMatching noch einbauen
                    array_push($filters->matchingBinaries, $settedComponent);
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
