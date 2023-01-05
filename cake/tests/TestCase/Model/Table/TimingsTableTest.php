<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TimingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TimingsTable Test Case
 */
class TimingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TimingsTable
     */
    public $Timings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Timings',
        'app.Participants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Timings') ? [] : ['className' => TimingsTable::class];
        $this->Timings = TableRegistry::getTableLocator()->get('Timings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Timings);

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
}
