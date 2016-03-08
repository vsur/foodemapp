<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComponentsScenariosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComponentsScenariosTable Test Case
 */
class ComponentsScenariosTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.components_scenarios',
        'app.components',
        'app.pois',
        'app.components_pois',
        'app.tags',
        'app.pois_tags',
        'app.scenarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ComponentsScenarios') ? [] : ['className' => 'App\Model\Table\ComponentsScenariosTable'];
        $this->ComponentsScenarios = TableRegistry::get('ComponentsScenarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ComponentsScenarios);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
