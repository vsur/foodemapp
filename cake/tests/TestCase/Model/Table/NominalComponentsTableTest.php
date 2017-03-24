<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NominalComponentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NominalComponentsTable Test Case
 */
class NominalComponentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NominalComponentsTable
     */
    public $NominalComponents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.nominal_components',
        'app.nominal_attributes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NominalComponents') ? [] : ['className' => 'App\Model\Table\NominalComponentsTable'];
        $this->NominalComponents = TableRegistry::get('NominalComponents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NominalComponents);

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
