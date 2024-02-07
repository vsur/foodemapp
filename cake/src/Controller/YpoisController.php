<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
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
        $this->loadComponent('PoisNComponents');
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        // Check IE
        $isIE = $this->detectIEBrowser();
        if($isIE) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'noie',
            ]);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($key = null)
    {
        $this->checkAccess($key);
        $ypois = $this->paginate($this->Ypois);

        $this->set(compact('ypois'));
        $this->set('_serialize', ['ypois']);
    }

    public function setScenario()
    {
        $this->viewBuilder()->layout('fmappbeta');

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

        // Preparing session for storing geolocation later
        $session = $this->request->session();
        // $session->destroy();  // Uncoment for Debug Purposes
        $session->write('Config.language', 'de');

        $this->set(compact('criteria', 'criterionNames', 'configuredSelection'));
    }

    public function findMatches($displayVariant = null, $eval = null)
    {
        if($eval) {
            $this->viewBuilder()->layout('fmappbetaeval');
        } else {
            $this->viewBuilder()->layout('fmappbeta');
        }

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

        // Store filter tokens from URL
        $configuredSelection = NULL;
        // Store filter objects for later filter query
        $filterSelection = NULL;
        // Store filter component sorte by ranking for filter group assignment
        $rankedSelection = NULL;

        // Use geoloction for sorting
        $sortByGeo = false;
        $distanceSelectQueryString = '';

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

        if (!empty($this->request->query)) {
            $configuredSelection = $this->request->query;
        }

        // Get all matching ypois or all
        $ypois = (object)[];
        if ($configuredSelection) {

            $filterSelection = $this->Ypois->buildFilterObject($configuredSelection);

            $ypois = $this->Ypois->findYpoisByConfiguredSelection($filterSelection, $sortByGeo, $distanceSelectQueryString);

            $ypois = $this->Ypois->getYpoisOrderedByAssocCount($ypois);

        } else {
            $ypois = $this->Ypois->find("all")
                ->contain(
                    [
                        'BinaryComponents' => [  'sort' => ['display_name' => 'ASC', 'name' => 'ASC']    ],
                        'NominalAttributes.NominalComponents',
                        'NominalAttributes' => [  'sort' => ['NominalComponents.display_name' => 'ASC', 'NominalComponents.name' => 'ASC']    ],
                        'OrdinalAttributes' => [  'sort' => ['meter' => 'ASC']   ],
                        'OrdinalAttributes.OrdinalComponents',
                        'OrdinalAttributes.OrdinalComponents.OrdinalAttributes' => [  'sort' => ['OrdinalAttributes.meter' => 'ASC']   ]
                    ]);
            // Check geolocation for sorting
            if($sortByGeo) {
                $ypois->select(
                        ['distance' => $distanceSelectQueryString]
                    )
                ->autoFields(true)
                ->order([
                    'distance' => 'ASC',
                    'name' => 'ASC',
                ]);
            } else {
                $ypois->order([
                    'name' => 'ASC',
                ]);
            }

            $ypois->limit(200); // For Debug only

            $ypois = $this->Ypois->getYpoisOrderedByAssocCount($ypois);

        }
        if($sortByGeo) {
            // Sort manually by distance
            $ypois = $this->Ypois->getYpoisOrderedByDistance($ypois);
        }

        // Build ranked selection from filters
        $rankedSelection = $this->Ypois->buildRankedSelection($filterSelection);

        // Build filter wheel data for D3.js sunburst-viz
         $componentWheelJSONData = $this->D3Data->buildComponentWheelSuburstJSONData($ypois, $rankedSelection);

        // Build chord diagram matrix for D3.js
        $chordDiagramMatrixData = [];
        if($displayVariant == "chord") {
            $chordDiagramMatrixData = $this->D3Data->buildChordDiagramMatrixData($ypois, $rankedSelection);
            /*
             *  Create JSON Files, uncomment next part

                // debug(json_encode($chordDiagramMatrixData));
                $now = Time::now();
                $now->timezone = 'Europe/Paris';
                debug($now->format('Y-m-d_H-i-s'));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_Adjacency_Matrix.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->adjacencyMatrix));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_Pois.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->pois));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_RankedComponents.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->rankedComponents));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_OtherComponents.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->otherComponents));
            */
        }

        $overallComponentCount = $this->PoisNComponents->allComponentsCount($ypois);

        $componentTypesComponentsCount = $this->PoisNComponents->allComponentTypeComponentsCount($ypois);

        if($displayVariant != 'selectViz' && count($ypois) == 0) {
            return $this->redirect([
                'action' => 'findMatches',
                'selectViz',
                '?' => $this->request->query
            ]);
        }

        $this->set(compact(
            'ypois',
            'criteria',
            'criterionNames',
            'displayVariant',
            'configuredSelection',
            'filterSelection',
            'rankedSelection',
            'componentWheelJSONData',
            'chordDiagramMatrixData',
            'overallComponentCount',
            'componentTypesComponentsCount',
            'eval'
        ));
    }

    public function checkMouseData($displayVariant = "list", $participantId = 46)
    {
        $queryDataList = [
            "BC_C-ID_77_BC-STATE_1" => 5,
            "BC_C-ID_50_BC-STATE_1" => 5,
            "NC_C-ID_3_NCATTR-ID_7" => 5,
            "NC_C-ID_7_NCATTR-ID_26" => 4,
            "OC_C-ID_1_OCATTR-ID_2" => 3,
            "OC_C-ID_3_OCATTR-ID_11" => 5,
        ];
        $queryDataChord = [
            "BC_C-ID_103_BC-STATE_1" => 5,
            "NC_C-ID_6_NCATTR-ID_21" => 4,
            "BC_C-ID_75_BC-STATE_1" => 3,
            "BC_C-ID_89_BC-STATE_0" => 5,
        ];
        $queryDataMap = [
            "NC_C-ID_2_NCATTR-ID_4" => 5,
            "BC_C-ID_40_BC-STATE_1" => 5,
            "BC_C-ID_94_BC-STATE_1" => 4,
            "BC_C-ID_77_BC-STATE_1" => 3,
        ];
        $queryData = [];
        switch ($displayVariant) {
            case 'list':
                $queryData = $queryDataList;
                break;
            case 'chord':
                $queryData = $queryDataChord;
                break;
            case 'map':
                $queryData = $queryDataMap;
                break;
        }
        // Handle Choice of Participant Drop Down
        $this->log($this->request->query, "debug");
        if(!empty($this->request->data)) {
            $displayVariant = $this->request->data['display_variant'];
            $participantId = $this->request->data['participants'];
            return $this->redirect([
                'action' => 'checkMouseData',
                $displayVariant,
                $participantId,
                // '?' => $this->request->query
                '?' => $queryData
            ]);
        }
        ini_set('memory_limit', '512M');
        // $this->viewBuilder()->layout('fmappbetaanlyze');
        $this->viewBuilder()->layout('fmappbetaanlyze');
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

        // Store filter tokens from URL
        $configuredSelection = NULL;
        // Store filter objects for later filter query
        $filterSelection = NULL;
        // Store filter component sorte by ranking for filter group assignment
        $rankedSelection = NULL;

        /**********************************************************
         *  FOR DEBUGGING GEO LOCATION IS NOT SET BY JS VALUES,   *
         *                 BUT IS HARDCODED HERE.                 *
         *      IN STANDARD MODE VALUES WOULD BE SET BY JS,       *
         * AS THERE IS THE OPTION TO LET SET THE VALUES BY DEVICE *
         **********************************************************/

         // Use geoloction for sorting
        $sortByGeo = true;
        $distanceSelectQueryString = '6371 * acos (
            cos ( radians( 49.01 ) )
            * cos( radians( lat ) )
            * cos( radians( lng ) - radians( 8.40806 ) )
            + sin ( radians( 49.01 ) )
            * sin( radians( lat ) )
          )';

        $configuredSelection = $queryData;

        // Get all matching ypois or all
        $ypois = (object)[];
        if ($configuredSelection) {

            $filterSelection = $this->Ypois->buildFilterObject($configuredSelection);

            $ypois = $this->Ypois->findYpoisByConfiguredSelection($filterSelection, $sortByGeo, $distanceSelectQueryString);

            $ypois = $this->Ypois->getYpoisOrderedByAssocCount($ypois);

        } else {
            $ypois = $this->Ypois->find("all")
                ->contain(
                    [
                        'BinaryComponents' => [  'sort' => ['display_name' => 'ASC', 'name' => 'ASC']    ],
                        'NominalAttributes.NominalComponents',
                        'NominalAttributes' => [  'sort' => ['NominalComponents.display_name' => 'ASC', 'NominalComponents.name' => 'ASC']    ],
                        'OrdinalAttributes' => [  'sort' => ['meter' => 'ASC']   ],
                        'OrdinalAttributes.OrdinalComponents',
                        'OrdinalAttributes.OrdinalComponents.OrdinalAttributes' => [  'sort' => ['OrdinalAttributes.meter' => 'ASC']   ]
                    ]);
            // Check geolocation for sorting
            if($sortByGeo) {
                $ypois->select(
                        ['distance' => $distanceSelectQueryString]
                    )
                ->autoFields(true)
                ->order([
                    'distance' => 'ASC',
                    'name' => 'ASC',
                ]);
            } else {
                $ypois->order([
                    'name' => 'ASC',
                ]);
            }

            $ypois->limit(200); // For Debug only

            $ypois = $this->Ypois->getYpoisOrderedByAssocCount($ypois);

        }
        if($sortByGeo) {
            // Sort manually by distance
            $ypois = $this->Ypois->getYpoisOrderedByDistance($ypois);
        }

        // Build ranked selection from filters
        $rankedSelection = $this->Ypois->buildRankedSelection($filterSelection);

        // Build filter wheel data for D3.js sunburst-viz
         $componentWheelJSONData = $this->D3Data->buildComponentWheelSuburstJSONData($ypois, $rankedSelection);

        // Build chord diagram matrix for D3.js
        $chordDiagramMatrixData = [];
        if($displayVariant == "chord") {
            $chordDiagramMatrixData = $this->D3Data->buildChordDiagramMatrixData($ypois, $rankedSelection);
            /*
             *  Create JSON Files, uncomment next part

                // debug(json_encode($chordDiagramMatrixData));
                $now = Time::now();
                $now->timezone = 'Europe/Paris';
                debug($now->format('Y-m-d_H-i-s'));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_Adjacency_Matrix.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->adjacencyMatrix));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_Pois.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->pois));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_RankedComponents.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->rankedComponents));
                $path = './' . $now->format('Y-m-d_H-i-s_') . 'JSON_OtherComponents.json';
                $file = new File($path, true);
                $file->write(json_encode($chordDiagramMatrixData->otherComponents));
            */
        }

        $overallComponentCount = $this->PoisNComponents->allComponentsCount($ypois);

        $componentTypesComponentsCount = $this->PoisNComponents->allComponentTypeComponentsCount($ypois);

        // if($displayVariant != 'selectViz' && count($ypois) == 0) {
        //     return $this->redirect([
        //         'action' => 'findMatches',
        //         'selectViz',
        //         '?' => $this->request->query
        //     ]);
        // }

        $this->loadModel('Participants');
        $allParticipants = $this->Participants->find('all');
        if($participantId) {
            $participantData = $this->Participants->get($participantId);
        } else {
            $participantData = null;
        }

        $this->set(compact(
            'ypois',
            'criteria',
            'criterionNames',
            'displayVariant',
            'configuredSelection',
            'filterSelection',
            'rankedSelection',
            'componentWheelJSONData',
            'chordDiagramMatrixData',
            'overallComponentCount',
            'componentTypesComponentsCount',
            'participantData',
            'allParticipants',
        ));
    }

    public function presetGeo($displayVariant = null) {
        $this->viewBuilder()->layout('fmappbeta');
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

        // Store filter tokens from URL
        $configuredSelection = NULL;

        if (!empty($this->request->query)) {
            $configuredSelection = $this->request->query;
        }
        $this->set(compact(
            'criteria',
            'criterionNames',
            'configuredSelection'
        ));
    }


    public function setGeoInSession() {
        $this->autoRender = false;

        if ( $this->request->is('ajax') && $this->request->is('post')) {
            $geoData = json_decode(json_encode($this->request->data), FALSE);

            $session = $this->request->session();
            $session->write('Config.geolocation.latitude', $geoData->latitude);
            $session->write('Config.geolocation.longitude', $geoData->longitude);
            $session->write('Config.geolocation.accuracy', $geoData->accuracy);
            $response =  (object) [
                'message' => 'Data saved to session',
                'data' => $session->read('Config.geolocation')
            ];
            echo json_encode($response);
            return;
        }

        return;
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
    public function add($key = null)
    {
        $this->checkAccess($key);
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
    public function edit($id = null, $key = null)
    {
        $this->checkAccess($key);
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
    public function delete($id = null, $key = null)
    {
        $this->checkAccess($key);
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
