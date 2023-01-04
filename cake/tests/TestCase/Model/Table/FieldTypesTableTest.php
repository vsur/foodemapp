<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FieldTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FieldTypesTable Test Case
 */
class FieldTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FieldTypesTable
     */
    public $FieldTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FieldTypes',
        'app.Codes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FieldTypes') ? [] : ['className' => FieldTypesTable::class];
        $this->FieldTypes = TableRegistry::getTableLocator()->get('FieldTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FieldTypes);

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
