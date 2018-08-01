<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class D3DataComponent extends Component
{
    public function buildFilterWheelSuburstJSONData($rankedSelection)
    {
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

    public function buildChordDiagramMatrixData($ypois, $rankedSelection)
    {
        /*
        Aus yPois ein yPois Name Index Array bauen

        Aus allen yPois bauen Components Array

        Itteriere über Components Array und schmeiße rankedComponents raus.

        Baue Matrix

            Baue ein MatrixIndexArray mit allen Namen

                Paste die yPois names
                Paste alle Ranked
                Paste alle übrigen

            Itteriere über alle yPois um für jeden Eintrag die Matrix row zu bauen

                dabei einfach üfer IndexChek Array Iterieren

                Fill 0 für yPois

                Fill ranked if vorhanden

                Fill rest if vorhanden

            row in Matrix Array
        */
        // Adjacency Matrix for all pois and components
        $adjacencyMatrix = [];

        $ypoisNames = $this->buildYpoisNamesArray($ypois);
        $allContainedCompponents = $this->getAllComponentNames($ypois);
        debug($ypoisNames);
        debug($allContainedCompponents);
        $selectionCleandComponents = $this->removeRankedComponents($allContainedCompponents, $rankedSelection);
        debug($selectionCleandComponents);
        return $adjacencyMatrix;
    }

    protected function buildSingleRankedSegmentData($rating, $ratedComponents, $filerWheelData)
    {
        $ratedChildren =  [];

        // Check and paste ranked binaryComponents as single child
        if (!empty($ratedComponents->binaryComponents)) {
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
        if (!empty($ratedComponents->nominalAttributes)) {
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
        if (!empty($ratedComponents->ordinalAttributes)) {
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

    protected function checkRankedGroup($ratedComponents)
    {
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

    protected function buildYpoisNamesArray($ypois)
    {
        $ypoisNames = [];
        foreach ($ypois as $ypoi) {
            array_push($ypoisNames, $ypoi->name);
        }
        return $ypoisNames;
    }

    protected function getAllComponentNames($ypois)
    {
        $allComponentsFromYpois = [];
        foreach ($ypois as $ypoi) {
            foreach ($ypoi->binary_components as $binaryComponent) {
                // Concat component and id to check if display names are present
                $binaryComponentConcatenation = $this->buildBinaryComponentConcatenationName($binaryComponent);
                if (!in_array($binaryComponentConcatenation, $allComponentsFromYpois)) {
                    array_push($allComponentsFromYpois, $binaryComponentConcatenation);
                }
            }
            foreach ($ypoi->nominal_attributes as $nominal_attribute) {
                // Concat attribute and component and ids to check if display names are present
                $nominalComponentAttributeConcatenation = $this->buildNominalComponentAttributeConcatenationName($nominal_attribute);
                if (!in_array($nominalComponentAttributeConcatenation, $allComponentsFromYpois)) {
                    array_push($allComponentsFromYpois, $nominalComponentAttributeConcatenation);
                }
            }
            foreach ($ypoi->ordinal_attributes as $ordinal_attribute) {
                // Concat attribute and component and check if display names are present
                $ordinalComponentAttributeConcatenation = $this->buildOrdinalComponentAttributeConcatenationName($ordinal_attribute);

                if (!in_array($ordinalComponentAttributeConcatenation, $allComponentsFromYpois)) {
                    array_push($allComponentsFromYpois, $ordinalComponentAttributeConcatenation);
                }
            }
        }
        return $allComponentsFromYpois;
    }

    protected function removeRankedComponents($allContainedCompponents, $rankedSelection)
    {
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if (!empty($ratedComponents->binaryComponents)) {
                foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                    // Concat name for compoarision
                    $binaryConcatedNameForComparison = $this->buildBinaryComponentConcatenationName($binaryComponent);
                    if (in_array($binaryConcatedNameForComparison, $allContainedCompponents)) {
                        $currentIndexToDelete = array_search($binaryConcatedNameForComparison, $allContainedCompponents);
                        array_splice($allContainedCompponents, $currentIndexToDelete, 1);
                    }
                }
            }
            if (!empty($ratedComponents->nominalAttributes)) {
                foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {
                    // Concat name for compoarision
                    $nominalConcatedNameForCompoarision = $this->buildNominalComponentAttributeConcatenationName($nominalAttribute);
                    if (in_array($nominalConcatedNameForCompoarision, $allContainedCompponents)) {
                        $currentIndexToDelete = array_search($nominalConcatedNameForCompoarision, $allContainedCompponents);
                        array_splice($allContainedCompponents, $currentIndexToDelete, 1);
                    }
                }
            }
            if (!empty($ratedComponents->ordinalAttributes)) {
                foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                    // Concat name for compoarision
                    $ordinalConcatedNameForCompoarision = $this->buildOrdinalComponentAttributeConcatenationName($ordinalAttribute);
                    if(in_array($ordinalConcatedNameForCompoarision, $allContainedCompponents)) {
                        $currentIndexToDelete = array_search($ordinalConcatedNameForCompoarision, $allContainedCompponents);
                        array_splice($allContainedCompponents, $currentIndexToDelete, 1);
                    }
                }
            }
        }
        return $allContainedCompponents;
    }

    protected function buildBinaryComponentConcatenationName($binaryComponent)
    {
        $concatedBinaryName = (empty($binaryComponent->display_name) ? $binaryComponent->name : $binaryComponent->display_name) . "_BC_C-ID_" . $binaryComponent->id;
        return $concatedBinaryName;
    }
    protected function buildNominalComponentAttributeConcatenationName($nominalAttribute)
    {
        $concatedNominalName =
            (empty($nominalAttribute->nominal_component->display_name) ? $nominalAttribute->nominal_component->name : $nominalAttribute->nominal_component->display_name) . ": " .
            (empty($nominalAttribute->display_name) ? $nominalAttribute->name : $nominalAttribute->display_name) .
            "_NC_C-ID_" . $nominalAttribute->nominal_component->id . "_NCATTR-ID_" . $nominalAttribute->id;
        return $concatedNominalName;
    }
    protected function buildOrdinalComponentAttributeConcatenationName($ordinalAttribute)
    {
        $concatedOrdinalName =
            (empty($ordinalAttribute->ordinal_component->display_name) ? $ordinalAttribute->ordinal_component->name : $ordinalAttribute->ordinal_component->display_name) . ": " .
            (empty($ordinalAttribute->display_name) ? $ordinalAttribute->name : $ordinalAttribute->display_name) .
            "_OC_C-ID_" . $ordinalAttribute->ordinal_component->id . "_OCATTR-ID_" . $ordinalAttribute->id;
        return $concatedOrdinalName;
    }
}
