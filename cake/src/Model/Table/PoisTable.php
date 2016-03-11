<?php
namespace App\Model\Table;

use App\Model\Entity\Pois;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pois Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 */
class PoisTable extends Table
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

        $this->table('pois');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Components', [
            'foreignKey' => 'poi_id',
            'targetForeignKey' => 'component_id',
            'joinTable' => 'stages'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'poi_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'pois_tags'
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
            ->allowEmpty('icon');

        $validator
            ->numeric('rating')
            ->allowEmpty('rating');

        $validator
            ->allowEmpty('vicinity');

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
            ->allowEmpty('opening_hours');

        $validator
            ->allowEmpty('weekday_text');

        $validator
            ->integer('photos')
            ->allowEmpty('photos');

        $validator
            ->integer('reviews')
            ->allowEmpty('reviews');

        return $validator;
    }
}
