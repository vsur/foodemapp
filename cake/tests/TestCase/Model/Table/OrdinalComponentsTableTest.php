<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdinalComponentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdinalComponentsTable Test Case
 */
class OrdinalComponentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdinalComponentsTable
     */
    public $OrdinalComponents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ordinal_components',
        'app.ordinal_attributes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrdinalComponents') ? [] : ['className' => 'App\Model\Table\OrdinalComponentsTable'];
        $this->OrdinalComponents = TableRegistry::get('OrdinalComponents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdinalComponents);

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
