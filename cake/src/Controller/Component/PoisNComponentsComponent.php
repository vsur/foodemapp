<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class PoisNComponentsComponent extends Component
{
    public function allComponentsCount($pois)
    {   
        $overallComponentCount = 0;
        foreach ($pois as $poi) {
            $overallComponentCount += count($poi->binary_components);
            $overallComponentCount += count($poi->nominal_attributes);
            $overallComponentCount += count($poi->ordinal_attributes);
        }
        return $overallComponentCount;
    }

    public function allComponentTypeComponentsCount($pois)
    {   
        $componentTypesComponentsCount = (object) [];

        $componentTypesComponentsCount->binaryCount = 0;
        $componentTypesComponentsCount->nominalCount = 0;
        $componentTypesComponentsCount->ordinalCount = 0;

        foreach ($pois as $poi) {
            $componentTypesComponentsCount->binaryCount += count($poi->binary_components);
            $componentTypesComponentsCount->nominalCount += count($poi->nominal_attributes);
            $componentTypesComponentsCount->ordinalCount += count($poi->ordinal_attributes);
        }
        return $componentTypesComponentsCount;
    }
}
