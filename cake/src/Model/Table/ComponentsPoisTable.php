<?php
namespace App\Model\Table;

use App\Model\Entity\ComponentsPois;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComponentsPois Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Components
 * @property \Cake\ORM\Association\BelongsTo $Pois
 */
class ComponentsPoisTable extends Table
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

        $this->table('components_pois');
        $this->displayField('id');
        $this->primaryKey(['id', 'components_id', 'pois_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Components', [
            'foreignKey' => 'components_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Pois', [
            'foreignKey' => 'pois_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('modiefied', 'valid', ['rule' => 'datetime'])
            ->requirePresence('modiefied', 'create')
            ->notEmpty('modiefied');

        $validator
            ->add('stage', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('stage');

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
        $rules->add($rules->existsIn(['components_id'], 'Components'));
        $rules->add($rules->existsIn(['pois_id'], 'Pois'));
        return $rules;
    }
}
