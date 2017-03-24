<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdinalAttributesYpoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdinalAttributesYpoisTable Test Case
 */
class OrdinalAttributesYpoisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdinalAttributesYpoisTable
     */
    public $OrdinalAttributesYpois;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ordinal_attributes_ypois',
        'app.ordinal_attributes',
        'app.ordinal_components',
        'app.ypois',
        'app.binary_components',
        'app.binary_components_ypois',
        'app.nominal_attributes',
        'app.nominal_components',
        'app.nominal_attributes_ypois'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrdinalAttributesYpois') ? [] : ['className' => 'App\Model\Table\OrdinalAttributesYpoisTable'];
        $this->OrdinalAttributesYpois = TableRegistry::get('OrdinalAttributesYpois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdinalAttributesYpois);

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
