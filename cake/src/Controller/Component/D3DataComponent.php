<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class D3DataComponent extends Component {

    public function buildFilterWheelSuburstJSONData($rankedSelection) {
        $filerWheelData = (object) [
            "name" => "filterWheel",
            "children" => []
        ];
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if ($this->checkRankedGroup($ratedComponents)) {
                array_push($filerWheelData->children, $this->buildSingleRankedSegmentData($rating, $ratedComponents, $filerWheelData));
            }
        }
        $filerWheelJSONData = json_encode($filerWheelData);
        return $filerWheelJSONData;
    }
    protected function buildSingleRankedSegmentData($rating, $ratedComponents, $filerWheelData) {
        $ratedChildren =  [];

        // Check and paste ranked binaryComponents as single child
        if (    !empty($ratedComponents->binaryComponents)  ) {
            foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                $binaryChild = (object) [
                    "name" => $binaryComponent->display_name != '' ? $binaryComponent->display_name : $binaryComponent->name,
                    "rating" => $binaryComponent->rating,
                    "type" => "BC",
                    "id" => $binaryComponent->id,
                    "binaryComponentState" => $binaryComponent->binaryComponentState
                ];
            }
            array_push($ratedChildren, $binaryChild);
        }
        // Check and paste ranked nominalAttributes as single child
        if (    !empty($ratedComponents->nominalAttributes)  ) {
            foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {

                $aggregatedName = $nominalAttribute->nominal_component->display_name != '' ? $nominalAttribute->nominal_component->display_name : $nominalAttribute->nominal_component->name;
                $aggregatedName .= ' ';
                $aggregatedName .= $nominalAttribute->display_name != '' ? $nominalAttribute->display_name : $nominalAttribute->name;

                $nominalChild = (object) [
                    "name" => $aggregatedName,
                    "componentName" => $nominalAttribute->nominal_component->name,
                    "componentDisplayName" => $nominalAttribute->nominal_component->display_name,
                    "attributeName" => $nominalAttribute->name,
                    "attibuteDisplayName" => $nominalAttribute->display_name,
                    "rating" => $nominalAttribute->rating,
                    "type" => "NC",
                    "componentId" => $nominalAttribute->nominal_component->id,
                    "attributeId" => $nominalAttribute->id,
                    "binaryComponentState" => $nominalAttribute->binaryComponentState
                ];
            }
            array_push($ratedChildren, $nominalChild);
        }

        // Check and paste ranked ordinalAttributes as single child
        if (    !empty($ratedComponents->ordinalAttributes)  ) {
            foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                $aggregatedName = $ordinalAttribute->ordinal_component->display_name != '' ? $ordinalAttribute->ordinal_component->display_name : $ordinalAttribute->ordinal_component->name;
                $aggregatedName .= ' ';
                $aggregatedName .= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : $ordinalAttribute->name;

                $ordinalChild = (object) [
                    "name" => $aggregatedName,
                    "componentName" => $ordinalAttribute->ordinal_component->name,
                    "componentDisplayName" => $ordinalAttribute->ordinal_component->display_name,
                    "attributeName" => $ordinalAttribute->name,
                    "attibuteDisplayName" => $ordinalAttribute->display_name,
                    "rating" => $ordinalAttribute->rating,
                    "type" => "OC",
                    "componentId" => $ordinalAttribute->ordinal_component->id,
                    "attributeId" => $ordinalAttribute->id,
                    "binaryComponentState" => $ordinalAttribute->binaryComponentState
                ];
            }
            array_push($ratedChildren, $ordinalChild);
        }

        // Build segemnt Data
        $segmentChildren = (object) [
            "name" => $rating,
            "children" => (object) []
        ];
        $segmentChildren->children = $ratedChildren;

        return $segmentChildren;
    }

    protected function checkRankedGroup($ratedComponents) {
        $ratedComponentsAreFilled = false;
        if (
                !empty($ratedComponents->binaryComponents) ||
                !empty($ratedComponents->nominalAttributes) ||
                !empty($ratedComponents->ordinalAttributes)
            ) {
            $ratedComponentsAreFilled  = true;
        }
        return $ratedComponentsAreFilled;
    }
}