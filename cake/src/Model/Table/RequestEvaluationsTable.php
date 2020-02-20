<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequestEvaluations Model
 *
 * @method \App\Model\Entity\RequestEvaluation get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestEvaluation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestEvaluation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestEvaluation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestEvaluation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestEvaluation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestEvaluation findOrCreate($search, callable $callback = null, $options = [])
 */
class RequestEvaluationsTable extends Table
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

        $this->setTable('request_evaluations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->requirePresence('query_parameters', 'create')
            ->notEmpty('query_parameters');

        $validator
            ->integer('ypois_count')
            ->requirePresence('ypois_count', 'create')
            ->notEmpty('ypois_count');

        $validator
            ->integer('choosen_components_count')
            ->requirePresence('choosen_components_count', 'create')
            ->notEmpty('choosen_components_count');

        $validator
            ->integer('other_components_count')
            ->requirePresence('other_components_count', 'create')
            ->notEmpty('other_components_count');

        $validator
            ->requirePresence('comming_from_view', 'create')
            ->notEmpty('comming_from_view');

        $validator
            ->requirePresence('view_to_evaluate', 'create')
            ->notEmpty('view_to_evaluate');

        $validator
            ->allowEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->integer('grade')
            ->requirePresence('grade', 'create')
            ->notEmpty('grade');

        $validator
            ->requirePresence('comment', 'create')
            ->notEmpty('comment');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
