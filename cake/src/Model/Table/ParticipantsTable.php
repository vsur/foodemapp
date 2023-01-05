<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Participants Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Timings
 * @property \App\Model\Table\CodesTable&\Cake\ORM\Association\BelongsToMany $Codes
 *
 * @method \App\Model\Entity\Participant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Participant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Participant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Participant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Participant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Participant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Participant findOrCreate($search, callable $callback = null, $options = [])
 */
class ParticipantsTable extends Table
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

        $this->setTable('participants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Timings', [
            'foreignKey' => 'timing_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Codes', [
            'foreignKey' => 'participant_id',
            'targetForeignKey' => 'code_id',
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
            ->scalar('token')
            ->maxLength('token', 36)
            ->allowEmptyString('token');

        $validator
            ->dateTime('submitdate')
            ->allowEmptyDateTime('submitdate');

        $validator
            ->integer('lastpage')
            ->allowEmptyString('lastpage');

        $validator
            ->scalar('startlanguage')
            ->maxLength('startlanguage', 20)
            ->requirePresence('startlanguage', 'create')
            ->notEmptyString('startlanguage');

        $validator
            ->scalar('seed')
            ->maxLength('seed', 31)
            ->allowEmptyString('seed');

        $validator
            ->dateTime('startdate')
            ->requirePresence('startdate', 'create')
            ->notEmptyDateTime('startdate');

        $validator
            ->dateTime('datestamp')
            ->requirePresence('datestamp', 'create')
            ->notEmptyDateTime('datestamp');

        $validator
            ->scalar('612158X1X2')
            ->maxLength('612158X1X2', 5)
            ->allowEmptyString('612158X1X2');

        $validator
            ->scalar('612158X2X4')
            ->maxLength('612158X2X4', 5)
            ->allowEmptyString('612158X2X4');

        $validator
            ->decimal('612158X3X5')
            ->allowEmptyString('612158X3X5');

        $validator
            ->scalar('612158X3X75')
            ->maxLength('612158X3X75', 1)
            ->allowEmptyString('612158X3X75');

        $validator
            ->scalar('612158X3X7')
            ->maxLength('612158X3X7', 5)
            ->allowEmptyString('612158X3X7');

        $validator
            ->scalar('612158X3X6')
            ->allowEmptyString('612158X3X6');

        $validator
            ->scalar('612158X3X8')
            ->maxLength('612158X3X8', 5)
            ->allowEmptyString('612158X3X8');

        $validator
            ->scalar('612158X6X108SQ007')
            ->maxLength('612158X6X108SQ007', 5)
            ->allowEmptyString('612158X6X108SQ007');

        $validator
            ->scalar('612158X6X108SQ008')
            ->maxLength('612158X6X108SQ008', 5)
            ->allowEmptyString('612158X6X108SQ008');

        $validator
            ->scalar('612158X6X108SQ009')
            ->maxLength('612158X6X108SQ009', 5)
            ->allowEmptyString('612158X6X108SQ009');

        $validator
            ->scalar('612158X6X108SQ010')
            ->maxLength('612158X6X108SQ010', 5)
            ->allowEmptyString('612158X6X108SQ010');

        $validator
            ->scalar('612158X6X108SQ011')
            ->maxLength('612158X6X108SQ011', 5)
            ->allowEmptyString('612158X6X108SQ011');

        $validator
            ->scalar('612158X6X108SQ012')
            ->maxLength('612158X6X108SQ012', 5)
            ->allowEmptyString('612158X6X108SQ012');

        $validator
            ->scalar('612158X6X108SQ013')
            ->maxLength('612158X6X108SQ013', 5)
            ->allowEmptyString('612158X6X108SQ013');

        $validator
            ->scalar('612158X6X108SQ014')
            ->maxLength('612158X6X108SQ014', 5)
            ->allowEmptyString('612158X6X108SQ014');

        $validator
            ->scalar('612158X6X108SQ015')
            ->maxLength('612158X6X108SQ015', 5)
            ->allowEmptyString('612158X6X108SQ015');

        $validator
            ->scalar('612158X6X108SQ016')
            ->maxLength('612158X6X108SQ016', 5)
            ->allowEmptyString('612158X6X108SQ016');

        $validator
            ->scalar('612158X6X108SQ017')
            ->maxLength('612158X6X108SQ017', 5)
            ->allowEmptyString('612158X6X108SQ017');

        $validator
            ->scalar('612158X6X108SQ018')
            ->maxLength('612158X6X108SQ018', 5)
            ->allowEmptyString('612158X6X108SQ018');

        $validator
            ->scalar('612158X6X108SQ019')
            ->maxLength('612158X6X108SQ019', 5)
            ->allowEmptyString('612158X6X108SQ019');

        $validator
            ->scalar('612158X6X108SQ020')
            ->maxLength('612158X6X108SQ020', 5)
            ->allowEmptyString('612158X6X108SQ020');

        $validator
            ->scalar('612158X6X108SQ021')
            ->maxLength('612158X6X108SQ021', 5)
            ->allowEmptyString('612158X6X108SQ021');

        $validator
            ->scalar('612158X6X108SQ022')
            ->maxLength('612158X6X108SQ022', 5)
            ->allowEmptyString('612158X6X108SQ022');

        $validator
            ->scalar('612158X6X108SQ023')
            ->maxLength('612158X6X108SQ023', 5)
            ->allowEmptyString('612158X6X108SQ023');

        $validator
            ->scalar('612158X6X108SQ024')
            ->maxLength('612158X6X108SQ024', 5)
            ->allowEmptyString('612158X6X108SQ024');

        $validator
            ->scalar('612158X6X108SQ026')
            ->maxLength('612158X6X108SQ026', 5)
            ->allowEmptyString('612158X6X108SQ026');

        $validator
            ->scalar('612158X6X19')
            ->maxLength('612158X6X19', 5)
            ->allowEmptyString('612158X6X19');

        $validator
            ->scalar('612158X6X21')
            ->maxLength('612158X6X21', 5)
            ->allowEmptyString('612158X6X21');

        $validator
            ->scalar('612158X4X9')
            ->maxLength('612158X4X9', 5)
            ->allowEmptyString('612158X4X9');

        $validator
            ->scalar('612158X4X10')
            ->maxLength('612158X4X10', 5)
            ->allowEmptyString('612158X4X10');

        $validator
            ->scalar('612158X4X11')
            ->maxLength('612158X4X11', 5)
            ->allowEmptyString('612158X4X11');

        $validator
            ->scalar('612158X4X11other')
            ->allowEmptyString('612158X4X11other');

        $validator
            ->scalar('612158X4X12')
            ->maxLength('612158X4X12', 5)
            ->allowEmptyString('612158X4X12');

        $validator
            ->scalar('612158X4X12other')
            ->allowEmptyString('612158X4X12other');

        $validator
            ->scalar('612158X4X13')
            ->maxLength('612158X4X13', 5)
            ->allowEmptyString('612158X4X13');

        $validator
            ->scalar('612158X4X13other')
            ->allowEmptyString('612158X4X13other');

        $validator
            ->scalar('612158X4X14')
            ->maxLength('612158X4X14', 5)
            ->allowEmptyString('612158X4X14');

        $validator
            ->scalar('612158X18X15')
            ->maxLength('612158X18X15', 1)
            ->allowEmptyString('612158X18X15');

        $validator
            ->scalar('612158X5X262')
            ->allowEmptyString('612158X5X262');

        $validator
            ->scalar('612158X5X16')
            ->maxLength('612158X5X16', 5)
            ->allowEmptyString('612158X5X16');

        $validator
            ->scalar('612158X5X93')
            ->maxLength('612158X5X93', 4294967295)
            ->allowEmptyString('612158X5X93');

        $validator
            ->scalar('612158X5X94')
            ->allowEmptyString('612158X5X94');

        $validator
            ->scalar('612158X5X95')
            ->maxLength('612158X5X95', 16777215)
            ->allowEmptyString('612158X5X95');

        $validator
            ->scalar('612158X5X17')
            ->maxLength('612158X5X17', 5)
            ->allowEmptyString('612158X5X17');

        $validator
            ->scalar('612158X5X18')
            ->maxLength('612158X5X18', 5)
            ->allowEmptyString('612158X5X18');

        $validator
            ->scalar('612158X16X263')
            ->allowEmptyString('612158X16X263');

        $validator
            ->scalar('612158X16X23')
            ->maxLength('612158X16X23', 5)
            ->allowEmptyString('612158X16X23');

        $validator
            ->scalar('612158X16X96')
            ->maxLength('612158X16X96', 4294967295)
            ->allowEmptyString('612158X16X96');

        $validator
            ->scalar('612158X16X97')
            ->allowEmptyString('612158X16X97');

        $validator
            ->scalar('612158X16X98')
            ->maxLength('612158X16X98', 16777215)
            ->allowEmptyString('612158X16X98');

        $validator
            ->scalar('612158X16X99')
            ->maxLength('612158X16X99', 16777215)
            ->allowEmptyString('612158X16X99');

        $validator
            ->scalar('612158X16X100')
            ->maxLength('612158X16X100', 4294967295)
            ->allowEmptyString('612158X16X100');

        $validator
            ->scalar('612158X16X24')
            ->maxLength('612158X16X24', 5)
            ->allowEmptyString('612158X16X24');

        $validator
            ->scalar('612158X16X25')
            ->maxLength('612158X16X25', 5)
            ->allowEmptyString('612158X16X25');

        $validator
            ->scalar('612158X17X264')
            ->allowEmptyString('612158X17X264');

        $validator
            ->scalar('612158X17X26')
            ->maxLength('612158X17X26', 5)
            ->allowEmptyString('612158X17X26');

        $validator
            ->scalar('612158X17X101')
            ->maxLength('612158X17X101', 4294967295)
            ->allowEmptyString('612158X17X101');

        $validator
            ->scalar('612158X17X102')
            ->allowEmptyString('612158X17X102');

        $validator
            ->scalar('612158X17X103')
            ->maxLength('612158X17X103', 16777215)
            ->allowEmptyString('612158X17X103');

        $validator
            ->scalar('612158X17X104')
            ->maxLength('612158X17X104', 16777215)
            ->allowEmptyString('612158X17X104');

        $validator
            ->scalar('612158X17X105')
            ->maxLength('612158X17X105', 16777215)
            ->allowEmptyString('612158X17X105');

        $validator
            ->scalar('612158X17X106')
            ->maxLength('612158X17X106', 16777215)
            ->allowEmptyString('612158X17X106');

        $validator
            ->scalar('612158X17X107')
            ->maxLength('612158X17X107', 16777215)
            ->allowEmptyString('612158X17X107');

        $validator
            ->scalar('612158X17X27')
            ->maxLength('612158X17X27', 5)
            ->allowEmptyString('612158X17X27');

        $validator
            ->scalar('612158X17X28')
            ->maxLength('612158X17X28', 5)
            ->allowEmptyString('612158X17X28');

        $validator
            ->scalar('612158X7X30SQ001')
            ->maxLength('612158X7X30SQ001', 5)
            ->allowEmptyString('612158X7X30SQ001');

        $validator
            ->scalar('612158X7X30SQ002')
            ->maxLength('612158X7X30SQ002', 5)
            ->allowEmptyString('612158X7X30SQ002');

        $validator
            ->scalar('612158X7X30SQ003')
            ->maxLength('612158X7X30SQ003', 5)
            ->allowEmptyString('612158X7X30SQ003');

        $validator
            ->scalar('612158X7X30SQ004')
            ->maxLength('612158X7X30SQ004', 5)
            ->allowEmptyString('612158X7X30SQ004');

        $validator
            ->scalar('612158X7X30SQ005')
            ->maxLength('612158X7X30SQ005', 5)
            ->allowEmptyString('612158X7X30SQ005');

        $validator
            ->scalar('612158X7X30SQ006')
            ->maxLength('612158X7X30SQ006', 5)
            ->allowEmptyString('612158X7X30SQ006');

        $validator
            ->scalar('612158X7X30SQ007')
            ->maxLength('612158X7X30SQ007', 5)
            ->allowEmptyString('612158X7X30SQ007');

        $validator
            ->scalar('612158X7X30SQ008')
            ->maxLength('612158X7X30SQ008', 5)
            ->allowEmptyString('612158X7X30SQ008');

        $validator
            ->scalar('612158X7X30SQ009')
            ->maxLength('612158X7X30SQ009', 5)
            ->allowEmptyString('612158X7X30SQ009');

        $validator
            ->scalar('612158X7X30SQ010')
            ->maxLength('612158X7X30SQ010', 5)
            ->allowEmptyString('612158X7X30SQ010');

        $validator
            ->scalar('612158X10X41SQ002')
            ->maxLength('612158X10X41SQ002', 5)
            ->allowEmptyString('612158X10X41SQ002');

        $validator
            ->scalar('612158X10X41SQ003')
            ->maxLength('612158X10X41SQ003', 5)
            ->allowEmptyString('612158X10X41SQ003');

        $validator
            ->scalar('612158X10X41SQ004')
            ->maxLength('612158X10X41SQ004', 5)
            ->allowEmptyString('612158X10X41SQ004');

        $validator
            ->scalar('612158X10X41SQ005')
            ->maxLength('612158X10X41SQ005', 5)
            ->allowEmptyString('612158X10X41SQ005');

        $validator
            ->scalar('612158X10X41SQ006')
            ->maxLength('612158X10X41SQ006', 5)
            ->allowEmptyString('612158X10X41SQ006');

        $validator
            ->scalar('612158X10X41SQ007')
            ->maxLength('612158X10X41SQ007', 5)
            ->allowEmptyString('612158X10X41SQ007');

        $validator
            ->scalar('612158X10X70')
            ->maxLength('612158X10X70', 1)
            ->allowEmptyString('612158X10X70');

        $validator
            ->scalar('612158X10X50')
            ->allowEmptyString('612158X10X50');

        $validator
            ->scalar('612158X10X52')
            ->allowEmptyString('612158X10X52');

        $validator
            ->scalar('612158X10X71')
            ->allowEmptyString('612158X10X71');

        $validator
            ->scalar('612158X10X53')
            ->allowEmptyString('612158X10X53');

        $validator
            ->scalar('612158X10X265')
            ->maxLength('612158X10X265', 5)
            ->allowEmptyString('612158X10X265');

        $validator
            ->scalar('612158X8X54')
            ->allowEmptyString('612158X8X54');

        $validator
            ->scalar('612158X8X55')
            ->maxLength('612158X8X55', 5)
            ->allowEmptyString('612158X8X55');

        $validator
            ->scalar('612158X9X72')
            ->allowEmptyString('612158X9X72');

        $validator
            ->scalar('612158X9X72other')
            ->allowEmptyString('612158X9X72other');

        $validator
            ->scalar('612158X9X73')
            ->allowEmptyString('612158X9X73');

        $validator
            ->scalar('612158X9X74')
            ->maxLength('612158X9X74', 1)
            ->allowEmptyString('612158X9X74');

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
        $rules->add($rules->existsIn(['timing_id'], 'Timings'));

        return $rules;
    }
}
