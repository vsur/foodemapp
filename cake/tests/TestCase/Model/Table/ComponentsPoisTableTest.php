<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComponentsPoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComponentsPoisTable Test Case
 */
class ComponentsPoisTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.components_pois',
        'app.components',
        'app.pois',
        'app.tags',
        'app.pois_tags',
        'app.scenarios',
        'app.components_scenarios'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ComponentsPois') ? [] : ['className' => 'App\Model\Table\ComponentsPoisTable'];
        $this->ComponentsPois = TableRegistry::get('ComponentsPois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ComponentsPois);

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
