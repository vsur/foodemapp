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
 * @property \Cake\ORM\Association\BelongsToMany $Components
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
            'foreignKey' => 'pois_id',
            'targetForeignKey' => 'component_id',
            'joinTable' => 'components_pois'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'pois_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        $validator
            ->add('lat', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lat');

        $validator
            ->add('lng', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('lng');

        $validator
            ->requirePresence('google_place', 'create')
            ->notEmpty('google_place');

        $validator
            ->allowEmpty('icon');

        $validator
            ->add('rating', 'valid', ['rule' => 'numeric'])
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
            ->add('user_ratings_total', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('user_ratings_total');

        $validator
            ->allowEmpty('opening_hours');

        $validator
            ->allowEmpty('weekday_text');

        $validator
            ->add('photos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('photos');

        $validator
            ->add('reviews', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('reviews');

        return $validator;
    }
}
