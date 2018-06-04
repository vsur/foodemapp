<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class D3DataComponent extends Component {
    public function buildFilterWheelSuburstJSON($amount1, $amount2) {
        return $amount1 + $amount2;
    }
}