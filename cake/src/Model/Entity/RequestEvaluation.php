<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequestEvaluation Entity
 *
 * @property int $id
 * @property string $query_parameters
 * @property int $ypois_count
 * @property int $choosen_components_count
 * @property int $other_components_count
 * @property string $comming_from_view
 * @property string $view_to_evaluate
 * @property string $name
 * @property string $email
 * @property int $grade
 * @property string $comment
 */
class RequestEvaluation extends Entity
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
        'id' => false
    ];
}
