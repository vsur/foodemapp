<?php
namespace App\Model\Table;

use App\Model\Entity\PoisTag;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PoisTags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Pois
 * @property \Cake\ORM\Association\BelongsTo $Tags
 */
class PoisTagsTable extends Table
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

        $this->table('pois_tags');
        $this->displayField('id');
        $this->primaryKey(['id', 'pois_id', 'tags_id']);

        $this->belongsTo('Pois', [
            'foreignKey' => 'poi_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
        $rules->add($rules->existsIn(['poi_id'], 'Pois'));
        $rules->add($rules->existsIn(['tag_id'], 'Tags'));
        return $rules;
    }
}
