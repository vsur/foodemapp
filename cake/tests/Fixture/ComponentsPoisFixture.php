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
        'component_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'poi_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modiefied' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'stage' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_cp_poi_key(poi_id)' => ['type' => 'index', 'columns' => ['poi_id'], 'length' => []],
            'fk_cp_component_key(component_id)' => ['type' => 'index', 'columns' => ['component_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['component_id', 'poi_id'], 'length' => []],
            'fk_cp_component_key(component_id)' => ['type' => 'foreign', 'columns' => ['component_id'], 'references' => ['components', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_cp_poi_key(poi_id)' => ['type' => 'foreign', 'columns' => ['poi_id'], 'references' => ['pois', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'component_id' => 1,
            'poi_id' => 1,
            'created' => '2016-03-08 14:54:52',
            'modiefied' => '2016-03-08 14:54:52',
            'stage' => 1
        ],
    ];
}
