<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BinaryComponentsYpoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BinaryComponentsYpoisTable Test Case
 */
class BinaryComponentsYpoisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BinaryComponentsYpoisTable
     */
    public $BinaryComponentsYpois;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.binary_components_ypois',
        'app.binary_components',
        'app.ypois',
        'app.nominal_attributes',
        'app.nominal_components',
        'app.nominal_attributes_ypois',
        'app.ordinal_attributes',
        'app.ordinal_components',
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
        $config = TableRegistry::exists('BinaryComponentsYpois') ? [] : ['className' => 'App\Model\Table\BinaryComponentsYpoisTable'];
        $this->BinaryComponentsYpois = TableRegistry::get('BinaryComponentsYpois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BinaryComponentsYpois);

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
