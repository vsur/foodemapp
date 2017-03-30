<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\YpoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\YpoisTable Test Case
 */
class YpoisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\YpoisTable
     */
    public $Ypois;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ypois',
        'app.binary_components',
        'app.binary_components_ypois',
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
        $config = TableRegistry::exists('Ypois') ? [] : ['className' => 'App\Model\Table\YpoisTable'];
        $this->Ypois = TableRegistry::get('Ypois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ypois);

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
