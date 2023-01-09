<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Code Entity
 *
 * @property int $id
 * @property int $field_type_id
 * @property string $name
 * @property string $description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\FieldType $field_type
 * @property \App\Model\Entity\Participant[] $participants
 */
class Code extends Entity
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
        'field_type_id' => true,
        'name' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'field_type' => true,
        'participants' => true,
    ];
}