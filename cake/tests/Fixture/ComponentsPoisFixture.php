<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ComponentsPoisFixture
 *
 */
class ComponentsPoisFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'components_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pois_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modiefied' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'stage' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_c_length_components1_idx' => ['type' => 'index', 'columns' => ['components_id'], 'length' => []],
            'fk_c_length_POIS1_idx' => ['type' => 'index', 'columns' => ['pois_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'components_id', 'pois_id'], 'length' => []],
            'fk_c_length_components1' => ['type' => 'foreign', 'columns' => ['components_id'], 'references' => ['components', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_c_length_POIS1' => ['type' => 'foreign', 'columns' => ['pois_id'], 'references' => ['pois', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'components_id' => 1,
            'pois_id' => 1,
            'created' => '2016-02-25 10:07:38',
            'modiefied' => '2016-02-25 10:07:38',
            'stage' => 1
        ],
    ];
}
