<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NominalComponents Model
 *
 * @property \Cake\ORM\Association\HasMany $NominalAttributes
 *
 * @method \App\Model\Entity\NominalComponent get($primaryKey, $options = [])
 * @method \App\Model\Entity\NominalComponent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NominalComponent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NominalComponent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NominalComponent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NominalComponent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NominalComponent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NominalComponentsTable extends Table
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

        $this->setTable('nominal_components');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('NominalAttributes', [
            'foreignKey' => 'nominal_component_id'
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
      $allNominalComponents = $this->find('all');
      if($withAttrs) {
        $allNominalComponents->contain(['NominalAttributes']);
      }
      foreach ($allNominalComponents as $nominalComponent) {
        if(empty($nominalComponent->display_name)) {
          $nominalComponent->display_name = $nominalComponent->name;
          if($nominalComponent->has('nominal_attributes')) {
            foreach ($nominalComponent->nominal_attributes as $nominalAttribute) {
              if(empty($nominalAttribute->display_name)) {
                $nominalAttribute->display_name = $nominalAttribute->name;
              }
            }
          }
        }
      }
      $unifiedNominalComponents = $allNominalComponents;
      return $unifiedNominalComponents;
    }
}
