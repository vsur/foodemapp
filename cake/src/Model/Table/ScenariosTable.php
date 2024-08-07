<?php
namespace App\Model\Table;

use App\Model\Entity\Scenario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Scenarios Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Components
 */
class ScenariosTable extends Table
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

        $this->table('scenarios');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Components', [
            'foreignKey' => 'scenario_id',
            'targetForeignKey' => 'component_id',
            'joinTable' => 'components_scenarios'
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
            ->allowEmpty('description');

        $validator
            ->allowEmpty('thumbnail');

        $validator
            ->integer('counter')
            ->allowEmpty('counter');

        return $validator;
    }
}
