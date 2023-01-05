<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\I18n\Time;

/**
 * Participants helper
 */
class ParticipantsHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getShortestInterviewDuration($participant) {
        $shortestTestDuration;
        
        $testDurationDateTime = $participant->submitdate->diff($participant->startdate);
        
        $interviewtime = new Time($participant->startdate);
        $interviewtime->modify('+' . round(floatval($participant->timing->interviewtime), 0) . ' seconds');
        
        $interviewDurationDateTime = $interviewtime->diff($participant->startdate);

        if ( new Time($participant->submitdate) > new Time($interviewtime)) {
            $shortestTestDuration = $testDurationDateTime->format('%H:%i:%s h');
        } else {
            $shortestTestDuration = $interviewDurationDateTime->format('%H:%i:%s h');
        }
        
        return $shortestTestDuration;
    }

    public function getFormatedVideoDuration($participant) {
        $videoDuration;
        
        $videoDuration = gmdate("H:i:s", $participant->timing['612158X18time']) . " h";
        
        return $videoDuration;
    }
    public function getSex($participant) {
        $sex = "NOT SET";
            switch ($participant['612158X3X75']) {
                case 'F':
                    $sex = "♀";
                    break;
                case 'M':
                    $sex = "♂";
                    break;
                case '':
                    $sex = "X";
                    break;
            }
        return $sex;
    }

    public function getOrderedTaskDurations($participant) {
        $listDuration = gmdate("H:i:s", $participant->timing['612158X5time']) . " h";
        $chordDuration = gmdate("H:i:s", $participant->timing['612158X16time']) . " h";
        $mapDuration = gmdate("H:i:s", $participant->timing['612158X17time']) . " h";
        $orderedDurations = "";

        $orders = [
            "list" => $participant['612158X5X262'], 
            "chord" => $participant['612158X16X263'], 
            "map" => $participant['612158X17X264']
        ];

        asort($orders);
        
        foreach ($orders as $key => $value) {
            switch ($key) {
                case 'list':
                    $orderedDurations .= "Liste: " . $listDuration . "<br>";
                    break;
                case 'chord':
                    $orderedDurations .= "Chord: " . $chordDuration . "<br>";
                    break;
                case 'map':
                    $orderedDurations .= "Map: " . $mapDuration . "<br>";
                    break;
            }
        }
        
        return $orderedDurations;
    }

}
