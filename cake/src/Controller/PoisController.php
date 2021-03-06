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
    public function matchesPie($sorting = "Rating") {
      $selectOperator = "AND";
      $this->viewBuilder()->layout('Foodmapp');

      // START Auslagern?
      // Hole IDs zu Componenten
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


      $this->loadModel('Components');
      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // ENDE AUSLAGERN HOLE IDS zu Componenten


      // START AUSLAGERN SORTING
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // ENDE SORTING OPTONS


      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);

      //
      if($searchParams[0] != 'findAll') {

        $pois->matching('Stages', function ($q) use ($searchParams, $selectOperator){
          // Iterate over $searchParams
          for($i = 0; $i < count($searchParams); $i++ ) {
            $q->orWhere([
              'AND' => [
                ['Stages.rating >' => $searchParams[$i]['rating']],
                ['Stages.component_id' => $searchParams[$i]['id']]
              ]
            ]);
          }
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;

        if($selectOperator == "AND") {
          $foundResults = array();
          foreach($pois as $poiIndex => $poi) {
            $contain = array();
            foreach($searchParams as $searchParam) {
              foreach($poi->components as $component) {
                if($component['id'] == $searchParam['id']) {
                  if($component->_joinData->rating >= $searchParam['rating']){
                    $contain[] = $searchParam['id'];
                  }
                }
              }
            }
            if(count($contain) == count($searchParams)) {
              $foundResults[] = $poi;
            }
          }
          $pois = $foundResults;
        }

        // Normalize the Components
        $normalizedComponents = [];
        // Find overall Componentset in all Pois
        foreach($pois as $poiIndex => $poi) {
          foreach ($poi->components as $component) {
            $cleanedComponentData = (object) array();
            $cleanedComponentData->id = $component->id;
            $cleanedComponentData->name = $component->name;
            if(!in_array($cleanedComponentData, $normalizedComponents)) {
              array_push($normalizedComponents, $cleanedComponentData);
            }
          }
        }
        // 2. Iteriere über alle Pois
        // 3. Schaue ob aktuellen allComponet is in poi component array_push
        // Ja gut, NEIN => fürge hinzu mit JoinDatat ratin = 0
        // 4. Sortiere Pois Components nach Name/Rating usw.

        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    // public function matchesAster($selectOperator = "OR", $sorting = "Rating") {
    public function matchesAster($sorting = "Rating") {
      $selectOperator = "OR";
      // debug($this->request->pass);
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

      $this->loadModel('Components');
      // TODO Hier auch nach Finad ALl oder bene keine Sear PArams abfragen
      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);

      // Check if script was called with any params and try to get associoated data
      // TODO hier stimmt einfach immner noch nix mit der SELECT Abfrage!

      //////////////////////
      // DAHER IGNORIERN! //
      //////////////////////

      if($searchParams[0] != 'findAll') {

        $pois->matching('Stages', function ($q) use ($searchParams, $selectOperator){

          // Iterate over $searchParams
          for($i = 0; $i < count($searchParams); $i++ ) {
            // Check $selectOperator and fire AND or OR
            switch ($selectOperator) {
                case 'OR':
                  $q->orWhere([
                    'AND' => [
                      ['Stages.rating >' => $searchParams[$i]['rating']],
                      ['Stages.component_id' => $searchParams[$i]['id']]
                    ]
                  ]);
                case 'AND':
                  $q->andWhere([
                    'AND' => [
                      ['Stages.rating >' => $searchParams[$i]['rating']],
                      ['Stages.component_id' => $searchParams[$i]['id']]
                    ]
                  ]);
            }
          }
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;

        //pr($pois);
        $foundResults = array();
        foreach($pois as $poiIndex => $poi) {
          $contain = array();
          foreach($searchParams as $searchParam) {
            foreach($poi->components as $component) {
              if($component['id'] == $searchParam['id']) {
                $contain[] = $searchParam['id'];
              }
            }
          }
          if(count($contain) == count($searchParams)) {
            $foundResults[] = $poi;
          }
        }

        // pr($foundResults);

        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop

        $pois = $foundResults;

      }

      // ✓ Find Index
      // ✓ Lösche aus Array und speicher zwischen
      // ✓ PAcke an den Anfang
      // ✓ Mache es iterierbar

      // TODO
      // • Umschalter für AND und OR als Parameter
      // • Farbe
      // • Dann die Drei Alternartiven Mehr ausschlachten

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesBar($sorting = "Rating") {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }



      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);
      //
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
          }
          // debug($q);
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;
        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesTreemap($sorting = "Rating") {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);
      // debug($pois->toArray());
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
          }
          // debug($q);
          return $q;
        })
        ->limit(5)
        ->distinct(['Pois.id'])
        ;
        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesMap() {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      $pois = $this->Pois->find('all', [
        'contain' => ['Components', 'Stages']
      ]);
      //
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
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
    public function matchesMapDia($sorting = "Rating") {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);

      //
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
          }
          // debug($q);
          return $q;
        })
        ->limit(20)
        ->distinct(['Pois.id'])
        ;
        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesChord($sorting = "Rating") {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);
      //
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
          }
          // debug($q);
          return $q;
        })
        ->limit(5)
        ->distinct(['Pois.id'])
        ;
        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
      }

      $this->set(compact('pois'));
      $this->set('_serialize', ['pois']);
    }

    /**
     * FMapp Step 3 method
     *
     * @return \Cake\Network\Response|null
     */
    public function matchesSunburst($sorting = "Rating") {
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

      $this->loadModel('Components');

      $machtingComponentNames = $this->Components->find('all');
      for($i = 0; $i < count($searchParams); $i++ ) {
        $machtingComponentNames->orWhere([
          'Components.name' => $searchParams[$i]['name']
        ]);
      }

      foreach ($machtingComponentNames as $matchingComponent) {
        for ($i = 0; $i < count($searchParams); $i++) {
          if( $searchParams[$i]['name'] == $matchingComponent->name) {
            $searchParams[$i]['id'] =  $matchingComponent->id;
          }
        }
      }

      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      switch ($sorting) {
        case 'Rating':
          $sortingOption = [
            'sort' => ['Stages.rating' => 'DESC' ]
          ];
          break;

        case 'AlphaASC':
          $sortingOption = [
            'sort' => ['Components.name' => 'ASC']
          ];
          break;

        case 'AlphaDESC':
          $sortingOption = [
            'sort' => ['Components.name' => 'DESC']
          ];
          break;

      }
      // Sort components by rating maybe Components.name => 'ASC' is better, because results are more or less constistent
      $pois = $this->Pois->find('all', [
        'contain' => [
          'Components' => $sortingOption,
          'Stages'
        ]
      ]);
      //
      // Check if script was callen with any params and try to get associoated data
      if($searchParams[0] != 'findAll') {
        $pois->matching('Stages', function ($q) use ($searchParams){
          /*
              HIER GING MAL WAS; Aber FALSCH!
              Deswegen jetzt halt einfach mit OR
          */
          for($i = 0; $i < count($searchParams); $i++ ) {
              /*
               *
               *  Hier umschalten
               *

              $q->andWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);

               *
               */
              $q->orWhere([
                'AND' => [
                  ['Stages.rating >' => $searchParams[$i]['rating']],
                  ['Stages.component_id' => $searchParams[$i]['id']]
                ]
              ]);
              /*
               */
          }
          // debug($q);
          return $q;
        })
        ->limit(5)
        ->distinct(['Pois.id'])
        ;
        // Try to get $searchParams Components as frist components in result
        // Walk throu all $pois if sorting is set by Rating
        foreach ($pois as $poiIndex => $poi) {
          // Iterate over searchParams
          foreach ($searchParams as $searchParamIndex => $singleChoosenComponent) {
            // Walk throu all components of a poi to place matching components at the beginning
            foreach ($poi->components as $componentsIndex => $component) {
              // Check if a searchParam machtes the recent component
              if($component->name == $singleChoosenComponent['name']) {
                $matchingComponent = $component;
                unset($poi->components[$componentsIndex]);
                array_unshift($poi->components, $matchingComponent);
              }
            }
          }
        } // End frist foreach loop
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
