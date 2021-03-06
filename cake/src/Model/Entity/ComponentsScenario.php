<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComponentsScenario Entity.
 *
 * @property int $component_id
 * @property \App\Model\Entity\Component $component
 * @property int $scenario_id
 * @property \App\Model\Entity\Scenario $scenario
 */
class ComponentsScenario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'component_id' => false,
        'scenario_id' => false,
    ];
}
