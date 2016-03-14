<?php
namespace App\Model\Table;

use App\Model\Entity\Component;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Components Model
 *
 * @property \Cake\ORM\Association\HasMany $Stages
 * @property \Cake\ORM\Association\BelongsToMany $Scenarios
 */
class ComponentsTable extends Table
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

        $this->table('components');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Stages', [
            'foreignKey' => 'component_id'
        ]);
        $this->belongsToMany('Scenarios', [
            'foreignKey' => 'component_id',
            'targetForeignKey' => 'scenario_id',
            'joinTable' => 'components_scenarios'
        ]);
        $this->belongsToMany('Pois', [
            'foreignKey' => 'component_id',
            'targetForeignKey' => 'poi_id',
            'joinTable' => 'stages'
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

        return $validator;
    }
}
