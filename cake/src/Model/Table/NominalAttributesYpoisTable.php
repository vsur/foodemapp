<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NominalAttributesYpois Model
 *
 * @property \Cake\ORM\Association\BelongsTo $NominalAttributes
 * @property \Cake\ORM\Association\BelongsTo $Ypois
 *
 * @method \App\Model\Entity\NominalAttributesYpois get($primaryKey, $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NominalAttributesYpois findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NominalAttributesYpoisTable extends Table
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

        $this->setTable('nominal_attributes_ypois');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('NominalAttributes', [
            'foreignKey' => 'nominal_attribute_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Ypois', [
            'foreignKey' => 'ypoi_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['nominal_attribute_id'], 'NominalAttributes'));
        $rules->add($rules->existsIn(['ypoi_id'], 'Ypois'));

        return $rules;
    }
}
