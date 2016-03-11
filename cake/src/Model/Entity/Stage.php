<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Stage Entity.
 *
 * @property int $id
 * @property int $component_id
 * @property \App\Model\Entity\Component $component
 * @property int $poi_id
 * @property \App\Model\Entity\Pois $pois
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property float $rating
 */
class Stage extends Entity
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
        'id' => false,
    ];
}
