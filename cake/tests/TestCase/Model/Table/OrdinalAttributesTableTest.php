<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdinalAttributesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdinalAttributesTable Test Case
 */
class OrdinalAttributesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdinalAttributesTable
     */
    public $OrdinalAttributes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ordinal_attributes',
        'app.ordinal_components',
        'app.ypois',
        'app.binary_components',
        'app.binary_components_ypois',
        'app.nominal_attributes',
        'app.nominal_components',
        'app.nominal_attributes_ypois',
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
        $config = TableRegistry::exists('OrdinalAttributes') ? [] : ['className' => 'App\Model\Table\OrdinalAttributesTable'];
        $this->OrdinalAttributes = TableRegistry::get('OrdinalAttributes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdinalAttributes);

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
