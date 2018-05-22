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

    protected function buildNStarRatingListItems($ratedComponents = null, $N_StarRating = null) {
        $ratingString = '';
        
        // Iterate over binary components
        foreach ($ratedComponents->binaryComponents as $rankedBinary) {
            $ratingString .= '<li class="binaryComponentContainer clearfix">';

            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<span class="componentNameBinarySlider' .  ($rankedBinary->display_name != '' ? '' : ' text-muted') . '">' . ($rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name) .'</span><label class="switch pull-right"><input type="checkbox"' .  ($rankedBinary->binaryComponentState == 'checked' ? 'checked' : '') . ' disabled><span class="slider round"></span></label>';

            $ratingString .= '</li>';
        }

        // Iterate over nominal attributes
        foreach($ratedComponents->nominalAttributes as $rankedNominal) {
            $ratingString .= '<li class="nominalComponentContainer clearfix">';

            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<div class="nominalAttribute pull-right"><figure class="attrIcons ' . ($rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder') . '"></figure></div>';
            $ratingString .=    '<span class="componentNameNominalComponent' . ($rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted') . '">' . ($rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name) . '</span> <br><span class="attributeNameNominalAttribute ' . ($rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted') . '">' . ($rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name) . '</span>';

            $ratingString .= '</li>';
        }

        // Iteratre over ordinal attributes
        foreach($ratedComponents->ordinalAttributes as $rankedOrdinal) {
            $ratingString .= '<li class="ordinalComponentContainer clearfix">';

            $ratingString .=    '<span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">' . $N_StarRating . '</span></span>';
            $ratingString .=    '<span class="componentNameOrdinalComponent' . ($rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted') . '">' . ($rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name) . '</span> <span class="attributeNameOrdinalAttribute ' . ($rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted') . '">' . ($rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name) . '</span> <br>';

            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;

            $ratingString .=    '<input type="range" min="' . $minRange . '" max="' . $maxRange . '" step="1" value="' . $rankedOrdinal->meter . '" disabled>';


            $ratingString .= '</li>';
        }

        return $ratingString;

    }

}