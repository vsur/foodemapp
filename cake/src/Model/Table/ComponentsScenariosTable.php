<?php
namespace App\Model\Table;

use App\Model\Entity\ComponentsScenario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComponentsScenarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Components
 * @property \Cake\ORM\Association\BelongsTo $Scenarios
 */
class ComponentsScenariosTable extends Table
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

        $this->table('components_scenarios');
        $this->displayField('id');
        $this->primaryKey(['id', 'components_id', 'scenarios_id']);

        $this->belongsTo('Components', [
            'foreignKey' => 'component_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Scenarios', [
            'foreignKey' => 'scenario_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['component_id'], 'Components'));
        $rules->add($rules->existsIn(['scenario_id'], 'Scenarios'));
        return $rules;
    }
}
