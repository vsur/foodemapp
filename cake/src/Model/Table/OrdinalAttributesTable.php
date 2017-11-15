<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdinalAttributes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $OrdinalComponents
 * @property \Cake\ORM\Association\BelongsToMany $Ypois
 *
 * @method \App\Model\Entity\OrdinalAttribute get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdinalAttribute newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdinalAttribute[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalAttribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdinalAttribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalAttribute[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdinalAttribute findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdinalAttributesTable extends Table
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

        $this->setTable('ordinal_attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OrdinalComponents', [
            'foreignKey' => 'ordinal_component_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Ypois', [
            'foreignKey' => 'ordinal_attribute_id',
            'targetForeignKey' => 'ypoi_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('display_name', 'create')
            ->notEmpty('display_name');

        $validator
            ->decimal('meter')
            ->requirePresence('meter', 'create')
            ->notEmpty('meter');

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
        $rules->add($rules->existsIn(['ordinal_component_id'], 'OrdinalComponents'));

        return $rules;
    }

    public function getAllEntriesWithUnifiedDisplayNames () {
      $allOrdinalAttributes = $this->find('all');
      foreach ($allOrdinalAttributes as $ordinalAttribute) {
        if(empty($ordinalAttribute->display_name)) {
          $ordinalAttribute->display_name = $ordinalAttribute->name;
        }
      }
      $unifiedOrdinalAttributes = $allOrdinalAttributes;
      return $unifiedOrdinalAttributes;
    }
}
