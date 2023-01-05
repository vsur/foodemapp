<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Timings Model
 *
 * @property \App\Model\Table\ParticipantsTable&\Cake\ORM\Association\HasMany $Participants
 *
 * @method \App\Model\Entity\Timing get($primaryKey, $options = [])
 * @method \App\Model\Entity\Timing newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Timing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Timing|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Timing saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Timing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Timing[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Timing findOrCreate($search, callable $callback = null, $options = [])
 */
class TimingsTable extends Table
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

        $this->setTable('timings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Participants', [
            'foreignKey' => 'timing_id',
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
            ->numeric('interviewtime')
            ->allowEmptyString('interviewtime');

        $validator
            ->numeric('612158X1time')
            ->allowEmptyString('612158X1time');

        $validator
            ->numeric('612158X1X2time')
            ->allowEmptyString('612158X1X2time');

        $validator
            ->numeric('612158X2time')
            ->allowEmptyString('612158X2time');

        $validator
            ->numeric('612158X2X4time')
            ->allowEmptyString('612158X2X4time');

        $validator
            ->numeric('612158X3time')
            ->allowEmptyString('612158X3time');

        $validator
            ->numeric('612158X3X5time')
            ->allowEmptyString('612158X3X5time');

        $validator
            ->numeric('612158X3X75time')
            ->allowEmptyString('612158X3X75time');

        $validator
            ->numeric('612158X3X7time')
            ->allowEmptyString('612158X3X7time');

        $validator
            ->numeric('612158X3X6time')
            ->allowEmptyString('612158X3X6time');

        $validator
            ->numeric('612158X3X8time')
            ->allowEmptyString('612158X3X8time');

        $validator
            ->numeric('612158X6time')
            ->allowEmptyString('612158X6time');

        $validator
            ->numeric('612158X6X108time')
            ->allowEmptyString('612158X6X108time');

        $validator
            ->numeric('612158X6X19time')
            ->allowEmptyString('612158X6X19time');

        $validator
            ->numeric('612158X6X21time')
            ->allowEmptyString('612158X6X21time');

        $validator
            ->numeric('612158X4time')
            ->allowEmptyString('612158X4time');

        $validator
            ->numeric('612158X4X9time')
            ->allowEmptyString('612158X4X9time');

        $validator
            ->numeric('612158X4X10time')
            ->allowEmptyString('612158X4X10time');

        $validator
            ->numeric('612158X4X11time')
            ->allowEmptyString('612158X4X11time');

        $validator
            ->numeric('612158X4X12time')
            ->allowEmptyString('612158X4X12time');

        $validator
            ->numeric('612158X4X13time')
            ->allowEmptyString('612158X4X13time');

        $validator
            ->numeric('612158X4X14time')
            ->allowEmptyString('612158X4X14time');

        $validator
            ->numeric('612158X18time')
            ->allowEmptyString('612158X18time');

        $validator
            ->numeric('612158X18X15time')
            ->allowEmptyString('612158X18X15time');

        $validator
            ->numeric('612158X5time')
            ->allowEmptyString('612158X5time');

        $validator
            ->numeric('612158X5X262time')
            ->allowEmptyString('612158X5X262time');

        $validator
            ->numeric('612158X5X16time')
            ->allowEmptyString('612158X5X16time');

        $validator
            ->numeric('612158X5X93time')
            ->allowEmptyString('612158X5X93time');

        $validator
            ->numeric('612158X5X94time')
            ->allowEmptyString('612158X5X94time');

        $validator
            ->numeric('612158X5X95time')
            ->allowEmptyString('612158X5X95time');

        $validator
            ->numeric('612158X5X17time')
            ->allowEmptyString('612158X5X17time');

        $validator
            ->numeric('612158X5X18time')
            ->allowEmptyString('612158X5X18time');

        $validator
            ->numeric('612158X16time')
            ->allowEmptyString('612158X16time');

        $validator
            ->numeric('612158X16X263time')
            ->allowEmptyString('612158X16X263time');

        $validator
            ->numeric('612158X16X23time')
            ->allowEmptyString('612158X16X23time');

        $validator
            ->numeric('612158X16X96time')
            ->allowEmptyString('612158X16X96time');

        $validator
            ->numeric('612158X16X97time')
            ->allowEmptyString('612158X16X97time');

        $validator
            ->numeric('612158X16X98time')
            ->allowEmptyString('612158X16X98time');

        $validator
            ->numeric('612158X16X99time')
            ->allowEmptyString('612158X16X99time');

        $validator
            ->numeric('612158X16X100time')
            ->allowEmptyString('612158X16X100time');

        $validator
            ->numeric('612158X16X24time')
            ->allowEmptyString('612158X16X24time');

        $validator
            ->numeric('612158X16X25time')
            ->allowEmptyString('612158X16X25time');

        $validator
            ->numeric('612158X17time')
            ->allowEmptyString('612158X17time');

        $validator
            ->numeric('612158X17X264time')
            ->allowEmptyString('612158X17X264time');

        $validator
            ->numeric('612158X17X26time')
            ->allowEmptyString('612158X17X26time');

        $validator
            ->numeric('612158X17X101time')
            ->allowEmptyString('612158X17X101time');

        $validator
            ->numeric('612158X17X102time')
            ->allowEmptyString('612158X17X102time');

        $validator
            ->numeric('612158X17X103time')
            ->allowEmptyString('612158X17X103time');

        $validator
            ->numeric('612158X17X104time')
            ->allowEmptyString('612158X17X104time');

        $validator
            ->numeric('612158X17X105time')
            ->allowEmptyString('612158X17X105time');

        $validator
            ->numeric('612158X17X106time')
            ->allowEmptyString('612158X17X106time');

        $validator
            ->numeric('612158X17X107time')
            ->allowEmptyString('612158X17X107time');

        $validator
            ->numeric('612158X17X27time')
            ->allowEmptyString('612158X17X27time');

        $validator
            ->numeric('612158X17X28time')
            ->allowEmptyString('612158X17X28time');

        $validator
            ->numeric('612158X7time')
            ->allowEmptyString('612158X7time');

        $validator
            ->numeric('612158X7X30time')
            ->allowEmptyString('612158X7X30time');

        $validator
            ->numeric('612158X10time')
            ->allowEmptyString('612158X10time');

        $validator
            ->numeric('612158X10X41time')
            ->allowEmptyString('612158X10X41time');

        $validator
            ->numeric('612158X10X70time')
            ->allowEmptyString('612158X10X70time');

        $validator
            ->numeric('612158X10X50time')
            ->allowEmptyString('612158X10X50time');

        $validator
            ->numeric('612158X10X52time')
            ->allowEmptyString('612158X10X52time');

        $validator
            ->numeric('612158X10X71time')
            ->allowEmptyString('612158X10X71time');

        $validator
            ->numeric('612158X10X53time')
            ->allowEmptyString('612158X10X53time');

        $validator
            ->numeric('612158X10X265time')
            ->allowEmptyString('612158X10X265time');

        $validator
            ->numeric('612158X8time')
            ->allowEmptyString('612158X8time');

        $validator
            ->numeric('612158X8X54time')
            ->allowEmptyString('612158X8X54time');

        $validator
            ->numeric('612158X8X55time')
            ->allowEmptyString('612158X8X55time');

        $validator
            ->numeric('612158X9time')
            ->allowEmptyString('612158X9time');

        $validator
            ->numeric('612158X9X72time')
            ->allowEmptyString('612158X9X72time');

        $validator
            ->numeric('612158X9X73time')
            ->allowEmptyString('612158X9X73time');

        $validator
            ->numeric('612158X9X74time')
            ->allowEmptyString('612158X9X74time');

        return $validator;
    }
}
