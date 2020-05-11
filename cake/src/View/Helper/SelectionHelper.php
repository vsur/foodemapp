<?php
namespace App\View\Helper;

use Cake\View\Helper;

class SelectionHelper extends Helper {

    public function createRankedSelectionList($rankedSelection) {
        $selectionList = '<ul class="list-unstyled">';

        // Iterate over rated components
        $selectionList .= $this->buildNStarRatingListItems($rankedSelection->rating5, 5);
        $selectionList .= $this->buildNStarRatingListItems($rankedSelection->rating4, 4);
        $selectionList .= $this->buildNStarRatingListItems($rankedSelection->rating3, 3);
        $selectionList .= $this->buildNStarRatingListItems($rankedSelection->rating2, 2);
        $selectionList .= $this->buildNStarRatingListItems($rankedSelection->rating1, 1);

        $selectionList .= '</ul>';

        return $selectionList;
    }

    public function createAggregatedSelectionRow($rankedSelection) {
        $selectionAggregation = '<ul class="list-inline">';

        // Iterate over rated components
        $selectionAggregation .= $this->buildNStarAggregatedItems($rankedSelection->rating1, 1);
        $selectionAggregation .= $this->buildNStarAggregatedItems($rankedSelection->rating2, 2);
        $selectionAggregation .= $this->buildNStarAggregatedItems($rankedSelection->rating3, 3);
        $selectionAggregation .= $this->buildNStarAggregatedItems($rankedSelection->rating4, 4);
        $selectionAggregation .= $this->buildNStarAggregatedItems($rankedSelection->rating5, 5);

        $selectionAggregation .= '</ul>';

        return $selectionAggregation;

    }

    public function getNStarAggregatedItemsNumber($ratedComponents = null) {

        $binaryComponents = $ratedComponents->binaryComponents;
        $nominalAttributes = $ratedComponents->nominalAttributes;
        $ordinalAttributes = $ratedComponents->ordinalAttributes;

        $aggregationSum = count($binaryComponents) + count($nominalAttributes) + count($ordinalAttributes);

        return $aggregationSum;
    } 

    protected function buildNStarRatingListItems($ratedComponents = null, $N_StarRating = null) {
        $ratingString = '';

        // Iterate over binary components
        foreach ($ratedComponents->binaryComponents as $rankedBinary) {
            $ratingString .= '<li class="binaryComponentContainer clearfix">';

            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<span class="binaryComponentInfo">';
            $ratingString .=    '   <span>';
            $ratingString .=    '       ' . $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name;
            $ratingString .=    '   </span>';
            $ratingString .=    '   <span class="pull-right">';
            $ratingString .=    '       <span class="glyphicon ' . ( $rankedBinary->binaryComponentState ? 'glyphicon-ok text-success' : 'glyphicon-remove text-danger' ) . '" aria-hidden="true"></span>';
            $ratingString .=    '   </span>';
            $ratingString .=    '</span>';

            $ratingString .= '</li>';
        }

        // Iterate over nominal attributes
        foreach($ratedComponents->nominalAttributes as $rankedNominal) {
            $ratingString .= '<li class="nominalComponentContainer clearfix">';

            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' . ($rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder') . '"></figure></div>';
            $ratingString .=    '<span class="componentNameNominalComponent' . ($rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted') . '">' . ($rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name) . '</span> <span class="attributeNameNominalAttribute ' . ($rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted') . '">' . ($rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name) . '</span>';

            $ratingString .= '</li>';
        }

        // Iteratre over ordinal attributes
        foreach($ratedComponents->ordinalAttributes as $rankedOrdinal) {
            $ratingString .= '<li class="ordinalComponentContainer clearfix">';
            
            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<div class="ordinalComponentInfo">';
            $ratingString .=        '<span class="componentNameOrdinalComponent' . ($rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted') . '">' . ($rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name) . '</span>'; 
            $ratingString .=        '<span class="attributeNameOrdinalAttribute pull-right ' . ($rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted') . '">' . ($rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name) . '</span> <br>';
            $ratingString .=    '</div>';

            $ratingString .= '</li>';
        }

        return $ratingString;

    }

    protected function buildNStarAggregatedItems($ratedComponents = null, $N_StarRating = null) {
        $aggregationString = '';

        $binaryComponents = $ratedComponents->binaryComponents;
        $nominalAttributes = $ratedComponents->nominalAttributes;
        $ordinalAttributes = $ratedComponents->ordinalAttributes;

        $aggregationSum = count($binaryComponents) + count($nominalAttributes) + count($ordinalAttributes);

        $aggregationString .= '<li class="clearfix text-center">';
        $aggregationString .=       '<span class="glyphicon glyphicon-star choosenStarAgregation' . ($aggregationSum == 0 ? ' muted' : '') . '" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
        $aggregationString .=       ' ';
        $aggregationString .=       '<span class="aggregationNumber' . ($aggregationSum == 0 ? ' muted' : '') . '">' . $aggregationSum . '</span>';
        $aggregationString .= '</li>';


        return $aggregationString;
    }

}
