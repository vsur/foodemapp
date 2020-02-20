<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequestEvaluationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequestEvaluationsTable Test Case
 */
class RequestEvaluationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RequestEvaluationsTable
     */
    public $RequestEvaluations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.request_evaluations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RequestEvaluations') ? [] : ['className' => 'App\Model\Table\RequestEvaluationsTable'];
        $this->RequestEvaluations = TableRegistry::get('RequestEvaluations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequestEvaluations);

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
