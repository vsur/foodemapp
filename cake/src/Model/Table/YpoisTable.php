<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ypois Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $BinaryComponents
 * @property \Cake\ORM\Association\BelongsToMany $NominalAttributes
 * @property \Cake\ORM\Association\BelongsToMany $OrdinalAttributes
 *
 * @method \App\Model\Entity\Ypois get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ypois newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ypois[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ypois|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ypois patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ypois[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ypois findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class YpoisTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ypois');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('BinaryComponents', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'binary_component_id',
            'joinTable' => 'binary_components_ypois'
        ]);
        $this->belongsToMany('NominalAttributes', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'nominal_attribute_id',
            'joinTable' => 'nominal_attributes_ypois'
        ]);
        $this->belongsToMany('OrdinalAttributes', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'ordinal_attribute_id',
            'joinTable' => 'ordinal_attributes_ypois'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        $validator
            ->numeric('lat')
            ->allowEmpty('lat');

        $validator
            ->numeric('lng')
            ->allowEmpty('lng');

        $validator
            ->requirePresence('google_place', 'create')
            ->notEmpty('google_place');

        $validator
            ->requirePresence('businessid', 'create')
            ->notEmpty('businessid')
            ->add('businessid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('icon');

        $validator
            ->numeric('rating')
            ->allowEmpty('rating');

        $validator
            ->allowEmpty('vicinity');

        $validator
            ->integer('city')
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('full_address', 'create')
            ->notEmpty('full_address');

        $validator
            ->allowEmpty('formatted_phone_number');

        $validator
            ->allowEmpty('mail');

        $validator
            ->allowEmpty('website');

        $validator
            ->allowEmpty('social');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('user_ratings_total')
            ->allowEmpty('user_ratings_total');

        $validator
            ->integer('stars')
            ->requirePresence('stars', 'create')
            ->notEmpty('stars');

        $validator
            ->allowEmpty('opening_hours');

        $validator
            ->allowEmpty('weekday_text');

        $validator
            ->integer('photos')
            ->allowEmpty('photos');

        $validator
            ->integer('reviews')
            ->allowEmpty('reviews');

        $validator
            ->integer('review_count')
            ->allowEmpty('review_count');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['businessid']));
        
        return $rules;
    }
    
    public function buildFilterObject($configuredSelection = null) {
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
    public function buildRankedSelection($filterSelection = null) {
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
                $queryObject = $this->BinaryComponents->get($objectToAssign->id);
                $queryObject->rating = $objectToAssign->rating;
                $queryObject->binaryComponentState = $objectToAssign->binaryComponentState;
                break;

            case 'nominalAttributes':
                $queryObject = $this->NominalAttributes->get($objectToAssign->id, [  'contain' => ['NominalComponents'] ]);
                $queryObject->rating = $objectToAssign->rating;
                break;

            case 'ordinalAttributes':
                $queryObject = $this->OrdinalAttributes->get($objectToAssign->id, [  'contain' => ['OrdinalComponents.OrdinalAttributes'] ]);
                $queryObject->rating = $objectToAssign->rating;
                break;

        }
        return $queryObject;
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

    public function findYpoisByConfiguredSelection($filterSelection = null) {
        $ypois = $this->find()->contain(
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

        // Order Results
        $ypois->order([
            'name' => 'ASC', 
            
        ]);

        return $ypois;
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
}
