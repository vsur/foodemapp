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
 * @property \Cake\ORM\Association\BelongsToMany $Locations
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
        $this->belongsToMany('Locations', [
            'foreignKey' => 'component_id',
            'targetForeignKey' => 'location_id',
            'joinTable' => 'components_locations'
        ]);
        $this->belongsToMany('Scenarios', [
            'foreignKey' => 'component_id',
            'targetForeignKey' => 'scenario_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        return $validator;
    }
}
