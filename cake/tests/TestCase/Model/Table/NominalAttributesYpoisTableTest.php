<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NominalAttributesYpoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NominalAttributesYpoisTable Test Case
 */
class NominalAttributesYpoisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NominalAttributesYpoisTable
     */
    public $NominalAttributesYpois;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.nominal_attributes_ypois',
        'app.nominal_attributes',
        'app.ypois',
        'app.binary_components',
        'app.binary_components_ypois',
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
        $config = TableRegistry::exists('NominalAttributesYpois') ? [] : ['className' => 'App\Model\Table\NominalAttributesYpoisTable'];
        $this->NominalAttributesYpois = TableRegistry::get('NominalAttributesYpois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NominalAttributesYpois);

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
