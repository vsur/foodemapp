<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ParticipantsCode Entity
 *
 * @property int $id
 * @property int $participant_id
 * @property int $code_id
 * @property string|null $vizvar
 * @property string|null $description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Participant $participant
 * @property \App\Model\Entity\Code $code
 */
class ParticipantsCode extends Entity
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
        'participant_id' => true,
        'code_id' => true,
        'vizvar' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'participant' => true,
        'code' => true,
    ];
}
