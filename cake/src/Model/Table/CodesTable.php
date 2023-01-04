<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Codes Model
 *
 * @property \App\Model\Table\FieldTypesTable&\Cake\ORM\Association\BelongsTo $FieldTypes
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\BelongsToMany $Participants
 *
 * @method \App\Model\Entity\Code get($primaryKey, $options = [])
 * @method \App\Model\Entity\Code newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Code[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Code|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Code saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Code patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Code[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Code findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CodesTable extends Table
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

        $this->setTable('codes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FieldTypes', [
            'foreignKey' => 'field_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Participants', [
            'foreignKey' => 'code_id',
            'targetForeignKey' => 'participant_id',
            'joinTable' => 'participants_codes',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
        $rules->add($rules->existsIn(['field_type_id'], 'FieldTypes'));

        return $rules;
    }
}
