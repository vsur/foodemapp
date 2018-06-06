<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class D3DataComponent extends Component {

    public function buildFilterWheelSuburstJSON($rankedSelection) {
        $filerWheelData = (object) [{
            "name" => "filterWheel",
            "children" => (object) []
        }];

        

        return $filerWheelJSONData;
    }

}