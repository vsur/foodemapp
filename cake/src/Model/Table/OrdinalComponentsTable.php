<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdinalComponents Model
 *
 * @property \Cake\ORM\Association\HasMany $OrdinalAttributes
 *
 * @method \App\Model\Entity\OrdinalComponent get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdinalComponent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdinalComponent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalComponent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdinalComponent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalComponent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalComponent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdinalComponentsTable extends Table
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

        $this->setTable('ordinal_components');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('OrdinalAttributes', [
            'foreignKey' => 'ordinal_component_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('display_name', 'create')
            ->notEmpty('display_name');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }

    public function getAllEntriesWithUnifiedDisplayNames ($withAttrs = null) {
      $allOrdinalComponents = $this->find('all')
      // display_name is probably empty so final sorting sould be done late
      ->order([
        'display_name' => 'ASC',
        'name' => 'ASC'
      ]);
      if($withAttrs) {
        $allOrdinalComponents->contain(['OrdinalAttributes' => [
          'sort' => [
            'OrdinalAttributes.meter' => 'ASC',
            'OrdinalAttributes.display_name' => 'ASC',
            'OrdinalAttributes.name' => 'ASC'
          ]
        ]]);
      }
      foreach ($allOrdinalComponents as $ordinalComponent) {
        if(empty($ordinalComponent->display_name)) {
          $ordinalComponent->display_name = $ordinalComponent->name;
          if($ordinalComponent->has('ordinal_attributes')) {
            foreach ($ordinalComponent->ordinal_attributes as $ordinalAttribute) {
              if(empty($ordinalAttribute->display_name)) {
                $ordinalAttribute->display_name = $ordinalAttribute->name;
              }
            }
          }
        }
      }
      $unifiedOrdinalComponents = $allOrdinalComponents;
      return $unifiedOrdinalComponents;
    }
}
