<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class D3DataComponent extends Component
{
    public function buildComponentWheelSuburstJSONData($ypois, $rankedSelection)
    {
        $componentWheelData = (object) [
            "name" => "componentWheel",
            "children" => []
        ];
        // Segmentes are devided in 3 or 7 groups
        // * choosen components
        // * other components
        // * 1–5 ranked groups
        //
        // What makes something like
        //
        // {
        //   "name"  : "componentWheel",
        //   "children" : [
        //     {
        //       "name"      :   "choosenComponents",
        //       "children"  :   [
        //         {
        //           "name"      :   "rating5",
        //           "children"  :   [
        //             {
        //               "name"      :   "binaryComponents",
        //               "children"  :   [
        //                 {
        //                   "name": "Italian",
        //                   "rating": "4",
        //                   "type": "BC",
        //                   "id": 64,
        //                   "binaryComponentState": true,
        //                   "value": 1
        //                 },
        //                 {
        //                   "name": "Pizza",
        //                   "rating": "5",
        //                   "type": "BC",
        //                   "id": 79,
        //                   "binaryComponentState": true,
        //                   "value":  1
        //                 }
        //               ]
        //             },
        //             {
        //               "name"      :   "nominalComponents",
        //               "children"  :   [
        //                 {
        //                   "attibuteDisplayName": "",
        //                   "attributeId": "1",
        //                   "attributeName": "casual",
        //                   "componentId": 1,
        //                   "componentName": "Attire",
        //                   "name": "Attire casual",
        //                   "rating": 5,
        //                   "type": "NC",
        //                   "value": 1
        //                 },
        //               ]
        //             },
        //             {
        //               "name"      :   "ordinalComponents",
        //               "children"  :   [
        //                 {
        //                   "attibuteDisplayName": "Auf der Straße",
        //                   "attributeId": "5",
        //                   "attributeName": "street",
        //                   "componentDisplayName": "Parkmöglichkeiten",
        //                   "componentId": 2,
        //                   "componentName": "Attire",
        //                   "name": "Parkmöglichkeiten Auf der Straße",
        //                   "rating": 5,
        //                   "type": "OC",
        //                   "value": 1
        //                 },
        //               ]
        //             },
        //           ]
        //         }
        //       ]
        //     },
        //     {
        //       "name"      :   "otherComponents",
        //       "children"  :   []
        //     },
        //     {
        //       "name"      :   "rating5",
        //       "children"  :   []
        //     },
        //     {
        //       "name"      :   "rating4",
        //       "children"  :   []
        //     },
        //     {
        //       "name"      :   "rating3",
        //       "children"  :   []
        //     }
        //   ]
        // }
        //
        $componentWheelData->children = array_merge($componentWheelData->children, $this->buildChoosenSegmentFields());

        foreach ($rankedSelection as $rating => $ratedComponents) {
            if ($this->checkRankedGroup($ratedComponents)) {
                // Build choosenComponents segment
                // and
                // paste choosenComponent also in single ranked segment
                $ratingNumber = substr($rating, -1);
                $ratingIndexToPutComponetTo = 5 - $ratingNumber; // $componentWheelData->children[0][0]->children[$indexToPutComponetTo]
                $componentWheelData = $this->buildSingleRankedSegmentData($rating, $ratedComponents, $componentWheelData, $ratingIndexToPutComponetTo);
            }
        }
        // Build otherComponents segment
        $otherComponents = $this->buildOtherComponentsArray($ypois, $rankedSelection);
        $componentWheelData = $this->buildOtherSegmentData($componentWheelData, $otherComponents);

        $componentWheelJSONData = json_encode($componentWheelData);
        return $componentWheelJSONData;
    }

    public function buildChordDiagramMatrixData($ypois, $rankedSelection)
    {
        // Adjacency Matrix for all pois and components
        $matrixData = (object) [];
        $adjacencyMatrixIndex = [];

        $ypoisNames = $this->buildYpoisNamesArray($ypois);
        $allContainedComponentsNames = $this->getAllComponentNames($ypois);
        $rankedSelectionComponentsNames = $this->getOnlyRankedComponentNames($rankedSelection);
        $selectionCleandComponentsNames = $this->removeRankedComponentsNames($allContainedComponentsNames, $rankedSelectionComponentsNames);

        $adjacencyMatrixIndex = array_merge($ypoisNames, $rankedSelectionComponentsNames, $selectionCleandComponentsNames);

        $matrixData->adjacencyMatrix = $this->createAdjacencyMatrix($ypois, $rankedSelection, $rankedSelectionComponentsNames, $selectionCleandComponentsNames, $adjacencyMatrixIndex);
        $matrixData->pois = $ypois->toArray();
        $matrixData->rankedComponents = $this->buildRankedComponentsArray($rankedSelection);
        $matrixData->otherComponents =  $this->buildOtherComponentsArray($ypois, $rankedSelection);
        return $matrixData;
    }

    protected function buildChoosenSegmentFields() {
        $componentTypeFields = [
            (object) [
                "name" => "choosenComponents",
                "children" => $this->buildrankedComponentFields()
            ],
            (object) [
                "name" => "otherComponents",
                "children" => $this->buildComponentTypeFields()
            ]
        ];
        foreach ($this->buildrankedComponentFields() as $rankedComponentFieldData) {
            array_push($componentTypeFields, $rankedComponentFieldData);
        }

        return $componentTypeFields;

    }

    protected function buildrankedComponentFields() {
        $rankedComponentFields = [
            (object) [
                "name" => "rating5",
                "children" => $this->buildComponentTypeFields()
            ],
            (object) [
                "name" => "rating4",
                "children" => $this->buildComponentTypeFields()
            ],
            (object) [
                "name" => "rating3",
                "children" => $this->buildComponentTypeFields()
            ],
            (object) [
                "name" => "rating2",
                "children" => $this->buildComponentTypeFields()
            ],
            (object) [
                "name" => "rating1",
                "children" => $this->buildComponentTypeFields()
            ],
        ];

        return $rankedComponentFields;
    }

    protected function buildComponentTypeFields() {
        $binaryComponentFields = (object) [
            "name" => "binaryComponents",
            "children" => []
        ];
        $nominalComponentFields = (object) [
            "name" => "nominalComponents",
            "children" => []
        ];
        $ordinalComponentFields = (object) [
            "name" => "ordinalComponents",
            "children" => []
        ];

        $componentTypeFields = [];

        array_push($componentTypeFields, $binaryComponentFields);
        array_push($componentTypeFields, $nominalComponentFields);
        array_push($componentTypeFields, $ordinalComponentFields);

        return $componentTypeFields;
    }

    protected function buildSingleRankedSegmentData($rating, $ratedComponents, $componentWheelData, $ratingIndexToPutComponetTo)
    {
        // $componentWheelData->children[0][0]->children[$ratingIndexToPutComponetTo]
        // Check and paste ranked binaryComponents as single child
        if (!empty($ratedComponents->binaryComponents)) {
            foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                $binaryChild = $this->buildTransformedComponentDataForSunburstChildItem("BC", $binaryComponent, $withRating = TRUE);
            }
            // Add in choosen group
            array_push($componentWheelData->children[0]->children[$ratingIndexToPutComponetTo]->children[0]->children, $binaryChild);
            // Add in single rating group
            array_push($componentWheelData->children[$ratingIndexToPutComponetTo +2]->children[0]->children, $binaryChild);
        }
        // Check and paste ranked nominalAttributes as single child
        if (!empty($ratedComponents->nominalAttributes)) {
            foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {
                $nominalChild = $this->buildTransformedComponentDataForSunburstChildItem("NC", $nominalAttribute, $withRating = TRUE);
            }
            // Add in choosen group
            array_push($componentWheelData->children[0]->children[$ratingIndexToPutComponetTo]->children[1]->children, $nominalChild);
            // Add in single rating group
            array_push($componentWheelData->children[$ratingIndexToPutComponetTo + 2]->children[1]->children, $nominalChild);
        }

        // Check and paste ranked ordinalAttributes as single child
        if (!empty($ratedComponents->ordinalAttributes)) {
            foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                $ordinalChild = $this->buildTransformedComponentDataForSunburstChildItem("OC", $ordinalAttribute, $withRating = TRUE);
            }
            // Add in choosen group
            array_push($componentWheelData->children[0]->children[$ratingIndexToPutComponetTo]->children[2]->children, $ordinalChild);
            // Add in single rating group
            array_push($componentWheelData->children[$ratingIndexToPutComponetTo + 2]->children[2]->children, $ordinalChild);
        }
        return $componentWheelData;
    }
    protected function buildOtherSegmentData($componentWheelData, $otherComponents)
    {
        foreach($otherComponents as $otherComponent) {
            $componentChild = $this->buildTransformedComponentDataForSunburstChildItem($otherComponent->componentType, $otherComponent);
            switch ($otherComponent->componentType) {
                case 'BC':
                    array_push($componentWheelData->children[1]->children[0]->children, $componentChild);
                    break;
                case 'NC':
                    array_push($componentWheelData->children[1]->children[1]->children, $componentChild);
                    break;
                case 'OC':
                    array_push($componentWheelData->children[1]->children[2]->children, $componentChild);
                    break;
            }
        }
        return $componentWheelData;
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
        $allComponentsNamesFromYpois = [];
        foreach ($ypois as $ypoi) {
            foreach ($ypoi->binary_components as $binaryComponent) {
                // Concat component and id to check if display names are present
                $binaryComponentConcatenation = $this->buildBinaryComponentConcatenationName($binaryComponent);
                if (!in_array($binaryComponentConcatenation, $allComponentsNamesFromYpois)) {
                    array_push($allComponentsNamesFromYpois, $binaryComponentConcatenation);
                }
            }
            foreach ($ypoi->nominal_attributes as $nominal_attribute) {
                // Concat attribute and component and ids to check if display names are present
                $nominalComponentAttributeConcatenation = $this->buildNominalComponentAttributeConcatenationName($nominal_attribute);
                if (!in_array($nominalComponentAttributeConcatenation, $allComponentsNamesFromYpois)) {
                    array_push($allComponentsNamesFromYpois, $nominalComponentAttributeConcatenation);
                }
            }
            foreach ($ypoi->ordinal_attributes as $ordinal_attribute) {
                // Concat attribute and component and check if display names are present
                $ordinalComponentAttributeConcatenation = $this->buildOrdinalComponentAttributeConcatenationName($ordinal_attribute);

                if (!in_array($ordinalComponentAttributeConcatenation, $allComponentsNamesFromYpois)) {
                    array_push($allComponentsNamesFromYpois, $ordinalComponentAttributeConcatenation);
                }
            }
        }
        return $allComponentsNamesFromYpois;
    }

    protected function removeRankedComponentsNames($allContainedComponentsNames, $rankedSelectionComponents)
    {
        foreach ($rankedSelectionComponents as $rankedSelectionComponent) {
            if (in_array($rankedSelectionComponent, $allContainedComponentsNames)) {
                $currentIndexToDelete = array_search($rankedSelectionComponent, $allContainedComponentsNames);
                array_splice($allContainedComponentsNames, $currentIndexToDelete, 1);
            }
        }
        return $allContainedComponentsNames;
    }
    protected function buildRankedComponentsArray($rankedSelection)
    {
        $rankedComponents = [];
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if (!empty($ratedComponents->binaryComponents)) {
                foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                    $binaryComponent->componentType = 'BC';
                    array_push($rankedComponents, $binaryComponent);
                }
            }
            if (!empty($ratedComponents->nominalAttributes)) {
                foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {
                    $nominalAttribute->componentType = 'NC';
                    $nominalAttribute->attributeType = 'NCATTR';
                    $nominalAttribute->nominal_component->componentType = 'NC';
                    array_push($rankedComponents, $nominalAttribute);
                }
            }
            if (!empty($ratedComponents->ordinalAttributes)) {
                foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                    $ordinalAttribute->componentType = 'OC';
                    $ordinalAttribute->attributeType = 'OCATTR';
                    $ordinalAttribute->ordinal_component->componentType = 'OC';
                    array_push($rankedComponents, $ordinalAttribute);
                }
            }
        }
        return $rankedComponents;
    }
    protected function buildOtherComponentsArray($ypois, $rankedSelection)
    {
        $selectionCleandComponents = [];
        $selectionCleandComponentsIds = (object) [];
        $selectionCleandComponentsIds->binaryComponentsIds = [];
        $selectionCleandComponentsIds->nominalAttributesIds = [];
        $selectionCleandComponentsIds->ordinalAttributesIds = [];
        $selcetedComponentsIds = (object) [];
        $selcetedComponentsIds->binaryComponentsIds = [];
        $selcetedComponentsIds->nominalAttributesIds = [];
        $selcetedComponentsIds->ordinalAttributesIds = [];
        // Get only components IDs from selection to devide selecetd and other components
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if (!empty($ratedComponents->binaryComponents)) {
                foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                    array_push($selcetedComponentsIds->binaryComponentsIds, $binaryComponent->id);
                }
            }
            if (!empty($ratedComponents->nominalAttributes)) {
                foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {
                    array_push($selcetedComponentsIds->nominalAttributesIds, $nominalAttribute->id);
                }
            }
            if (!empty($ratedComponents->ordinalAttributes)) {
                foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                    array_push($selcetedComponentsIds->ordinalAttributesIds, $ordinalAttribute->id);
                }
            }
        }
        // Iterate over ypois and extract only not selected components
        foreach ($ypois as $ypoi) {
            foreach ($ypoi->binary_components as $binaryComponent) {
                // Not already pushed
                if(!in_array($binaryComponent->id, $selectionCleandComponentsIds->binaryComponentsIds)) {
                    // Not a ranked Component
                    if(!in_array($binaryComponent->id, $selcetedComponentsIds->binaryComponentsIds)) {
                        array_push($selectionCleandComponentsIds->binaryComponentsIds, $binaryComponent->id);
                        $binaryComponent->componentType = 'BC';
                        array_push($selectionCleandComponents, $binaryComponent);
                    }
                }
            }
            foreach ($ypoi->nominal_attributes as $nominal_attribute) {
                // Not already pushed
                if(!in_array($nominal_attribute->id, $selectionCleandComponentsIds->nominalAttributesIds)) {
                    // Not a ranked Component
                    if(!in_array($nominal_attribute->id, $selcetedComponentsIds->nominalAttributesIds)) {
                        array_push($selectionCleandComponentsIds->nominalAttributesIds, $nominal_attribute->id);
                        $nominal_attribute->componentType = 'NC';
                        $nominal_attribute->attributeType = 'NCATTR';
                        $nominal_attribute->nominal_component->componentType = 'NC';
                        array_push($selectionCleandComponents, $nominal_attribute);
                    }
                }
            }
            foreach ($ypoi->ordinal_attributes as $ordinal_attribute) {
                // Not already pushed
                if(!in_array($ordinal_attribute->id, $selectionCleandComponentsIds->ordinalAttributesIds)) {
                    // Not a ranked Component
                    if(!in_array($ordinal_attribute->id, $selcetedComponentsIds->ordinalAttributesIds)) {
                        array_push($selcetedComponentsIds->ordinalAttributesIds, $ordinal_attribute->id);
                        // debug($ordinal_attribute);
                        $ordinal_attribute->componentType = 'OC';
                        $ordinal_attribute->attributeType = 'OCATTR';
                        $ordinal_attribute->ordinal_component->componentType = 'OC';
                        array_push($selectionCleandComponents, $ordinal_attribute);
                    }
                }
            }
        }
        return $selectionCleandComponents;
    }
    protected function getOnlyRankedComponentNames($rankedSelection)
    {
        $rankedSelectionNames = [];
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if (!empty($ratedComponents->binaryComponents)) {
                foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                    // Concat name for compoarision
                    $binaryConcatedNameForComparison = $this->buildBinaryComponentConcatenationName($binaryComponent);
                    array_push($rankedSelectionNames, $binaryConcatedNameForComparison);
                }
            }
            if (!empty($ratedComponents->nominalAttributes)) {
                foreach ($ratedComponents->nominalAttributes as $nominalAttribute) {
                    // Concat name for compoarision
                    $nominalConcatedNameForCompoarision = $this->buildNominalComponentAttributeConcatenationName($nominalAttribute);
                    array_push($rankedSelectionNames, $nominalConcatedNameForCompoarision);
                }
            }
            if (!empty($ratedComponents->ordinalAttributes)) {
                foreach ($ratedComponents->ordinalAttributes as $ordinalAttribute) {
                    // Concat name for compoarision
                    $ordinalConcatedNameForCompoarision = $this->buildOrdinalComponentAttributeConcatenationName($ordinalAttribute);
                    array_push($rankedSelectionNames, $ordinalConcatedNameForCompoarision);
                }
            }
        }
        return $rankedSelectionNames;
    }

    protected function createAdjacencyMatrix($ypois, $rankedSelection, $rankedSelectionComponents, $selectionCleandComponentsNames, $adjacencyMatrixIndex)
    {
        $adjacencyMatrix = [];
        // Create adjacency column with blanks
        $ypoisAdjacencyRow = array_fill(0, count($adjacencyMatrixIndex), 0);
        // Paste needed rows
        foreach ($adjacencyMatrixIndex as $row) {
            array_push($adjacencyMatrix, $ypoisAdjacencyRow);
        }

        foreach ($ypois as $currentYpoiIndex => $ypoi) {

            // Iterate over all contained components and check $adjacencyMatrixIndex index to create adjacency
            foreach ($ypoi->binary_components as $binaryComponent) {
                // Concat component and id to prepare adjacency
                $binaryComponentConcatenation = $this->buildBinaryComponentConcatenationName($binaryComponent);
                // Get index in $adjacencyMatrixIndex for current component
                $componentIndex = array_search($binaryComponentConcatenation, $adjacencyMatrixIndex);
                if($componentIndex) {
                    $adjacencyMatrix = $this->setAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex);
                }
            }
            foreach ($ypoi->nominal_attributes as $nominal_attribute) {
                // Concat component and id to prepare adjacency
                $nominalComponentAttributeConcatenation = $this->buildNominalComponentAttributeConcatenationName($nominal_attribute);
                // Get index in $adjacencyMatrixIndex for current component
                $componentIndex = array_search($nominalComponentAttributeConcatenation, $adjacencyMatrixIndex);
                if($componentIndex) {
                    $adjacencyMatrix = $this->setAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex);
                }
            }
            foreach ($ypoi->ordinal_attributes as $ordinal_attribute) {
                // Concat component and id to prepare adjacency
                $ordinalComponentAttributeConcatenation = $this->buildOrdinalComponentAttributeConcatenationName($ordinal_attribute);
                // Get index in $adjacencyMatrixIndex for current component
                $componentIndex = array_search($ordinalComponentAttributeConcatenation, $adjacencyMatrixIndex);
                if($componentIndex) {
                    $adjacencyMatrix = $this->setAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex);
                }
            }
        }

        // Iterate over all rankedComponents and cehck $adjacencyMatrixIndex index to create adjacency for NOT binaryComponents
        foreach ($rankedSelection as $rating => $ratedComponents) {
            if (!empty($ratedComponents->binaryComponents)) {
                foreach ($ratedComponents->binaryComponents as $binaryComponent) {
                    if(!$binaryComponent->binaryComponentState) {
                        // Concat component and id to prepare adjacency
                        $binaryComponentConcatenation = $this->buildBinaryComponentConcatenationName($binaryComponent);
                        // Get index in $adjacencyMatrixIndex for current component
                        $componentIndex = array_search($binaryComponentConcatenation, $adjacencyMatrixIndex);
                        debug($componentIndex);
                        $adjacencyMatrix = $this->setNotBinaryAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex, $ypois);
                    }
                }
            }
        }
        return $adjacencyMatrix;
    }

    protected function setAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex) {
        // Set adjacency in column for current ypoi
        $adjacencyMatrix[$currentYpoiIndex][$componentIndex] = 1;
        // Set adjacency in row for found component
        $adjacencyMatrix[$componentIndex][$currentYpoiIndex] = 1;
        return $adjacencyMatrix;
    }

    protected function setNotBinaryAdjecencies($adjacencyMatrix, $currentYpoiIndex, $componentIndex, $ypois) {
        // Calculate self reference factor of ypois number
        $selfReferenceFactor = count($ypois->toArray());
        // Set adjacency in in self reference
        $adjacencyMatrix[$componentIndex][$componentIndex] = $selfReferenceFactor; 
        return $adjacencyMatrix;
    }


/*
    protected function addYpoisAdjacenciesToMatrix($adjacencyMatrix, $ypois, $adjacencyMatrixIndex)
    {
        foreach ($ypois as $ypoi) {
            // Create adjacency row with blanks
            $ypoisAdjacencyRow = array_fill(0, count($adjacencyMatrixIndex), 0);

            // Iterate over all contained components and check $adjacencyMatrixIndex index to create adjacency
            foreach ($ypoi->binary_components as $binaryComponent) {
                // Concat component and id to prepare adjacency
                $binaryComponentConcatenation = $this->buildBinaryComponentConcatenationName($binaryComponent);
                // Get index in $adjacencyMatrixIndex for current component
                $currentIndex = array_search($binaryComponentConcatenation, $adjacencyMatrixIndex);
                $ypoisAdjacencyRow[$currentIndex] = 1;
            }
            foreach ($ypoi->nominal_attributes as $nominal_attribute) {
                // Concat component and id to prepare adjacency
                $nominalComponentAttributeConcatenation = $this->buildNominalComponentAttributeConcatenationName($nominal_attribute);
                // Get index in $adjacencyMatrixIndex for current component
                $currentIndex = array_search($nominalComponentAttributeConcatenation, $adjacencyMatrixIndex);
                $ypoisAdjacencyRow[$currentIndex] = 1;
            }
            foreach ($ypoi->ordinal_attributes as $ordinal_attribute) {
                // Concat component and id to prepare adjacency
                $ordinalComponentAttributeConcatenation = $this->buildOrdinalComponentAttributeConcatenationName($ordinal_attribute);
                // Get index in $adjacencyMatrixIndex for current component
                $currentIndex = array_search($ordinalComponentAttributeConcatenation, $adjacencyMatrixIndex);
                $ypoisAdjacencyRow[$currentIndex] = 1;
            }

            // Push created ypoi row to matrix
            array_push($adjacencyMatrix, $ypoisAdjacencyRow);

        }
        return $adjacencyMatrix;
    }

    protected function addRankedAdjacenciesToMatrix($adjacencyMatrix, $rankedSelectionComponents, $adjacencyMatrixIndex)
    {
        debug($rankedSelectionComponents);
        foreach ($rankedSelectionComponents as $rankedSelectionComponent) {
            // code...
        }
        return $adjacencyMatrix;
    }*/

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
    protected function buildTransformedComponentDataForSunburstChildItem($componentType, $component, $withRating = NULL) {
        $componentAsSunBurstChildItem = (object) [];

        switch ($componentType) {
            case "BC":
                $binaryComponent = $component;
                $componentAsSunBurstChildItem = (object) [
                    "name" => $binaryComponent->display_name != '' ? $binaryComponent->display_name : $binaryComponent->name,
                    // "rating" => $binaryComponent->rating,
                    "type" => "BC",
                    "id" => $binaryComponent->id,
                ];
                if(isset($binaryComponent->binaryComponentState)) {
                    $componentAsSunBurstChildItem->binaryComponentState = $binaryComponent->binaryComponentState;
                }
                if($withRating) {
                    $componentAsSunBurstChildItem->rating = $binaryComponent->rating;
                }
                break;
            case "NC":
                $nominalAttribute = $component;
                $aggregatedName = $nominalAttribute->nominal_component->display_name != '' ? $nominalAttribute->nominal_component->display_name : $nominalAttribute->nominal_component->name;
                $aggregatedName .= ' ';
                $aggregatedName .= $nominalAttribute->display_name != '' ? $nominalAttribute->display_name : $nominalAttribute->name;

                $componentAsSunBurstChildItem = (object) [
                    "name" => $aggregatedName,
                    "componentName" => $nominalAttribute->nominal_component->name,
                    "componentDisplayName" => $nominalAttribute->nominal_component->display_name,
                    "attributeName" => $nominalAttribute->name,
                    "attibuteDisplayName" => $nominalAttribute->display_name,
                    // "rating" => $nominalAttribute->rating,
                    "type" => "NC",
                    "componentId" => $nominalAttribute->nominal_component->id,
                    "attributeId" => $nominalAttribute->id,
                    "binaryComponentState" => $nominalAttribute->binaryComponentState
                ];
                if($withRating) {
                    $componentAsSunBurstChildItem->rating = $nominalAttribute->rating;
                }
                break;
            case "OC":
                $ordinalAttribute = $component;
                $aggregatedName = $ordinalAttribute->ordinal_component->display_name != '' ? $ordinalAttribute->ordinal_component->display_name : $ordinalAttribute->ordinal_component->name;
                $aggregatedName .= ' ';
                $aggregatedName .= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : $ordinalAttribute->name;

                $componentAsSunBurstChildItem = (object) [
                    "name" => $aggregatedName,
                    "componentName" => $ordinalAttribute->ordinal_component->name,
                    "componentDisplayName" => $ordinalAttribute->ordinal_component->display_name,
                    "attributeName" => $ordinalAttribute->name,
                    "attibuteDisplayName" => $ordinalAttribute->display_name,
                    // "rating" => $ordinalAttribute->rating,
                    "type" => "OC",
                    "componentId" => $ordinalAttribute->ordinal_component->id,
                    "attributeId" => $ordinalAttribute->id,
                    "binaryComponentState" => $ordinalAttribute->binaryComponentState
                ];
                if($withRating) {
                    $componentAsSunBurstChildItem->rating = $ordinalAttribute->rating;
                }
                break;
        }

        return $componentAsSunBurstChildItem;
    }
}
