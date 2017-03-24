<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NominalAttributesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NominalAttributesTable Test Case
 */
class NominalAttributesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NominalAttributesTable
     */
    public $NominalAttributes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.nominal_attributes',
        'app.nominal_components',
        'app.ypois',
        'app.binary_components',
        'app.binary_components_ypois',
        'app.nominal_attributes_ypois',
        'app.ordinal_attributes',
        'app.ordinal_attributes_ypois'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NominalAttributes') ? [] : ['className' => 'App\Model\Table\NominalAttributesTable'];
        $this->NominalAttributes = TableRegistry::get('NominalAttributes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NominalAttributes);

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
