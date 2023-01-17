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

    public $helpers = ['Form'];

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

    public function getInternetLevel($participant) {
        $iLevel = "";
            switch ($participant['612158X6X21']) {
                case 'AO01':
                    $iLevel = "Beginner";
                    break;
                case 'AO02':
                    $iLevel = "Middle";
                    break;
                case 'AO03':
                    $iLevel = "Expert";
                    break;
            }
        return $iLevel;
    }

    public function getMoods($participant) {
        $moods = "";
        $moodStart = "NOT SET";

        switch ($participant['612158X3X8']) {
            case 'AO01':
                $moodStart = "Schlecht";
                break;
            case 'AO02':
                $moodStart = "Nicht gut";
                break;
            case 'AO03':
                $moodStart = "Neutral";
                break;
            case 'AO04':
                $moodStart = "Gut";
                break;
            case 'AO05':
                $moodStart = "Sehr gut";
                break;
        }

        $moodEnd = "NOT SET";
        switch ($participant['612158X8X55']) {
            case 'AO01':
                $moodEnd = "Schlecht";
                break;
            case 'AO02':
                $moodEnd = "Nicht gut";
                break;
            case 'AO03':
                $moodEnd = "Neutral";
                break;
            case 'AO04':
                $moodEnd = "Gut";
                break;
            case 'AO05':
                $moodEnd = "Sehr gut";
                break;
        }

        $moods = "Start: $moodStart | Ende: $moodEnd";

        return $moods;
    }

    public function getOrderedTaskDurations($participant, $inlineFormatet = FALSE) {
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
        $durationNumber = 1; 
        foreach ($orders as $key => $value) {
            switch ($key) {
                case 'list':
                    $orderedDurations .= "Liste: " . $listDuration;  
                    if($durationNumber<=2) $orderedDurations .= ($inlineFormatet != FALSE ? " | " : "<br>");
                    $durationNumber++; 
                    break;
                case 'chord':
                    $orderedDurations .= "Chord: " . $chordDuration;
                    if($durationNumber<=2) $orderedDurations .= ($inlineFormatet != FALSE ? " | " : "<br>");
                    $durationNumber++; 
                    break;
                case 'map':
                    $orderedDurations .= "Map: " . $mapDuration;
                    if($durationNumber<=2) $orderedDurations .= ($inlineFormatet != FALSE ? " | " : "<br>");
                    $durationNumber++; 
                    break;
            }
        }
        
        return $orderedDurations;
    }

    public function getFavoriteViz($participant) {
        $favoriteViz = "";

        switch ($participant['612158X10X265']) {
            case 'AO01':
                $favoriteViz = "Liste";
                break;
            case 'AO02':
                $favoriteViz = "Chord";
                break;
            case 'AO03':
                $favoriteViz = "Map";
        }

        return $favoriteViz;
    }

    public function getChordMapOverList($participant) {
        $chordMapOverList = "";
        switch ($participant['612158X10X70']) {
            case 'Y':
                $chordMapOverList = '<h5 style="color:green">&check; Chord und Map besser.</h5>';
                break;
            case 'N':
                $chordMapOverList = '<h5 style="color:red">&#10060; Liste besser.</h5>';
                break;
        }
        return $chordMapOverList;
    }

    public function generateCodesList($participant, $codes) {
        $codesList = "";
        $codesList .= '<ul class="codesList">';
        foreach ($codes as $code) {
            $codesList .=  '<li>';
            $participantCodesId = $this->searchIfCodeIsSet($code->id, $participant->codes);
            $codesList .=  $this->Form->hidden("Codes.$code->id.id", ['value' => $code->id]);
            if(is_null($participantCodesId)) {
                $codesList .= $this->Form->checkbox("Codes.$code->id.set", ['checked' => 0]);
                $options = [
                    'chordMapOverList' => 'CMOL', 
                    'list' => 'L',
                    'chord' => 'C',
                    'map' => 'M',
                    'finalComment' => 'FCOM',
                ];
                $codesList .= $this->Form->select("Codes.$code->id._joinData.vizvar",  $options, ['empty' => true]);
                $codesList .= " ";
                $codesList .= $code->field_type->name;
                $codesList .= " ";
                $codesList .= $code->name;
                $codesList .= " ";
                $codesList .= '<span class="commentSwitch">↓</span>';
                $codesList .= " ";
                $codesList .= $this->Form->text("Codes.$code->id._joinData.description", [
                    'label' => FALSE,
                ]);
            } else {    
                $codesList .= $this->Form->checkbox("Codes.$code->id.set", ['checked' => 1]);
                $options = [
                    'chordMapOverList' => 'CMOL', 
                    'list' => 'L',
                    'chord' => 'C',
                    'map' => 'M',
                    'finalComment' => 'FCOM',
                ];
                $codesList .= $this->Form->select("Codes.$code->id._joinData.vizvar",  $options, ['default' => $participant->codes[$participantCodesId]->_joinData->vizvar]);
                $codesList .= " ";
                $codesList .= $code->field_type->name;
                $codesList .= " ";
                $codesList .= $code->name;
                $codesList .= " ";
                $codesList .= '<span class="' . ($participant->codes[$participantCodesId]->_joinData->description == '' ? 'commentSwitch' : 'commentSwitch active' ) . '">↓</span>';
                $codesList .= " ";
                $codesList .= $this->Form->hidden("Codes.$code->id._joinData.id", [
                    'value' => $participant->codes[$participantCodesId]->_joinData->id,
                    'label' => FALSE,
                ]);
                $codesList .= $this->Form->text("Codes.$code->id._joinData.description", [
                    'value' => $participant->codes[$participantCodesId]->_joinData->description,
                    'label' => FALSE,
                ]);
            }
            $codesList .= "</li>";
        }
        $codesList .= '</ul>';
        return $codesList;
    }

    public function searchIfCodeIsSet($id, $participantCodes) {
        foreach ($participantCodes as $key => $participantCode) {
            if ($participantCode->id == $id) {
                        return $key;
                }
        }
        return null;
    }

}
