<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ComponentsScenariosFixture
 *
 */
class ComponentsScenariosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'component_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'scenario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_cs_scenario_key(scenario_id)' => ['type' => 'index', 'columns' => ['scenario_id'], 'length' => []],
            'fk_cs_components_key(component_id)' => ['type' => 'index', 'columns' => ['component_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['component_id', 'scenario_id'], 'length' => []],
            'fk_cs_scenario_key(scenario_id)' => ['type' => 'foreign', 'columns' => ['scenario_id'], 'references' => ['scenarios', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_cs_components_key(component_id)' => ['type' => 'foreign', 'columns' => ['component_id'], 'references' => ['components', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'scenario_id' => 1
        ],
    ];
}
