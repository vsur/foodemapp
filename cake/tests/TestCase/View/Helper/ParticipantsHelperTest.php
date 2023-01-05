<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ParticipantsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ParticipantsHelper Test Case
 */
class ParticipantsHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\ParticipantsHelper
     */
    public $Participants;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Participants = new ParticipantsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Participants);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
