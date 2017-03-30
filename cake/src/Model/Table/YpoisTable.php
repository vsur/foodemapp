<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ypois Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $BinaryComponents
 * @property \Cake\ORM\Association\BelongsToMany $NominalAttributes
 * @property \Cake\ORM\Association\BelongsToMany $OrdinalAttributes
 *
 * @method \App\Model\Entity\Ypois get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ypois newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ypois[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ypois|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ypois patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ypois[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ypois findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class YpoisTable extends Table
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

        $this->setTable('ypois');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('BinaryComponents', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'binary_component_id',
            'joinTable' => 'binary_components_ypois'
        ]);
        $this->belongsToMany('NominalAttributes', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'nominal_attribute_id',
            'joinTable' => 'nominal_attributes_ypois'
        ]);
        $this->belongsToMany('OrdinalAttributes', [
            'foreignKey' => 'ypoi_id',
            'targetForeignKey' => 'ordinal_attribute_id',
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
            ->allowEmpty('name');

        $validator
            ->numeric('lat')
            ->allowEmpty('lat');

        $validator
            ->numeric('lng')
            ->allowEmpty('lng');

        $validator
            ->requirePresence('google_place', 'create')
            ->notEmpty('google_place');

        $validator
            ->requirePresence('businessid', 'create')
            ->notEmpty('businessid')
            ->add('businessid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('icon');

        $validator
            ->numeric('rating')
            ->allowEmpty('rating');

        $validator
            ->allowEmpty('vicinity');

        $validator
            ->integer('city')
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->requirePresence('full_address', 'create')
            ->notEmpty('full_address');

        $validator
            ->allowEmpty('formatted_phone_number');

        $validator
            ->allowEmpty('mail');

        $validator
            ->allowEmpty('website');

        $validator
            ->allowEmpty('social');

        $validator
            ->allowEmpty('description');

        $validator
            ->integer('user_ratings_total')
            ->allowEmpty('user_ratings_total');

        $validator
            ->integer('stars')
            ->requirePresence('stars', 'create')
            ->notEmpty('stars');

        $validator
            ->allowEmpty('opening_hours');

        $validator
            ->allowEmpty('weekday_text');

        $validator
            ->integer('photos')
            ->allowEmpty('photos');

        $validator
            ->integer('reviews')
            ->allowEmpty('reviews');

        $validator
            ->integer('review_count')
            ->allowEmpty('review_count');

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
        $rules->add($rules->isUnique(['businessid']));

        return $rules;
    }
}
