<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipantsCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParticipantsCodesTable Test Case
 */
class ParticipantsCodesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParticipantsCodesTable
     */
    public $ParticipantsCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ParticipantsCodes',
        'app.Participants',
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
        $config = TableRegistry::getTableLocator()->exists('ParticipantsCodes') ? [] : ['className' => ParticipantsCodesTable::class];
        $this->ParticipantsCodes = TableRegistry::getTableLocator()->get('ParticipantsCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ParticipantsCodes);

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
