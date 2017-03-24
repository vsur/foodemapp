<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NominalAttributes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $NominalComponents
 * @property \Cake\ORM\Association\BelongsToMany $Ypois
 *
 * @method \App\Model\Entity\NominalAttribute get($primaryKey, $options = [])
 * @method \App\Model\Entity\NominalAttribute newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NominalAttribute[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NominalAttribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttribute[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttribute findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NominalAttributesTable extends Table
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

        $this->setTable('nominal_attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('NominalComponents', [
            'foreignKey' => 'nominal_component_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Ypois', [
            'foreignKey' => 'nominal_attribute_id',
            'targetForeignKey' => 'ypois_id',
            'joinTable' => 'nominal_attributes_ypois'
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
            ->notEmpty('name');

        $validator
            ->requirePresence('display_name', 'create')
            ->notEmpty('display_name');

        $validator
            ->allowEmpty('icon_path');

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
        $rules->add($rules->existsIn(['nominal_component_id'], 'NominalComponents'));

        return $rules;
    }
}
