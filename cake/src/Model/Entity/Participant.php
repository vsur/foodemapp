<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Participant Entity
 *
 * @property int $id
 * @property int $timing_id
 * @property string|null $token
 * @property \Cake\I18n\Time|null $submitdate
 * @property int|null $lastpage
 * @property string $startlanguage
 * @property string|null $seed
 * @property \Cake\I18n\Time $startdate
 * @property \Cake\I18n\Time $datestamp
 * @property string|null $612158X1X2
 * @property string|null $612158X2X4
 * @property float|null $612158X3X5
 * @property string|null $612158X3X75
 * @property string|null $612158X3X7
 * @property string|null $612158X3X6
 * @property string|null $612158X3X8
 * @property string|null $612158X6X108SQ007
 * @property string|null $612158X6X108SQ008
 * @property string|null $612158X6X108SQ009
 * @property string|null $612158X6X108SQ010
 * @property string|null $612158X6X108SQ011
 * @property string|null $612158X6X108SQ012
 * @property string|null $612158X6X108SQ013
 * @property string|null $612158X6X108SQ014
 * @property string|null $612158X6X108SQ015
 * @property string|null $612158X6X108SQ016
 * @property string|null $612158X6X108SQ017
 * @property string|null $612158X6X108SQ018
 * @property string|null $612158X6X108SQ019
 * @property string|null $612158X6X108SQ020
 * @property string|null $612158X6X108SQ021
 * @property string|null $612158X6X108SQ022
 * @property string|null $612158X6X108SQ023
 * @property string|null $612158X6X108SQ024
 * @property string|null $612158X6X108SQ026
 * @property string|null $612158X6X19
 * @property string|null $612158X6X21
 * @property string|null $612158X4X9
 * @property string|null $612158X4X10
 * @property string|null $612158X4X11
 * @property string|null $612158X4X11other
 * @property string|null $612158X4X12
 * @property string|null $612158X4X12other
 * @property string|null $612158X4X13
 * @property string|null $612158X4X13other
 * @property string|null $612158X4X14
 * @property string|null $612158X18X15
 * @property string|null $612158X5X262
 * @property string|null $612158X5X16
 * @property string|null $612158X5X93
 * @property string|null $612158X5X94
 * @property string|null $612158X5X95
 * @property string|null $612158X5X17
 * @property string|null $612158X5X18
 * @property string|null $612158X16X263
 * @property string|null $612158X16X23
 * @property string|null $612158X16X96
 * @property string|null $612158X16X97
 * @property string|null $612158X16X98
 * @property string|null $612158X16X99
 * @property string|null $612158X16X100
 * @property string|null $612158X16X24
 * @property string|null $612158X16X25
 * @property string|null $612158X17X264
 * @property string|null $612158X17X26
 * @property string|null $612158X17X101
 * @property string|null $612158X17X102
 * @property string|null $612158X17X103
 * @property string|null $612158X17X104
 * @property string|null $612158X17X105
 * @property string|null $612158X17X106
 * @property string|null $612158X17X107
 * @property string|null $612158X17X27
 * @property string|null $612158X17X28
 * @property string|null $612158X7X30SQ001
 * @property string|null $612158X7X30SQ002
 * @property string|null $612158X7X30SQ003
 * @property string|null $612158X7X30SQ004
 * @property string|null $612158X7X30SQ005
 * @property string|null $612158X7X30SQ006
 * @property string|null $612158X7X30SQ007
 * @property string|null $612158X7X30SQ008
 * @property string|null $612158X7X30SQ009
 * @property string|null $612158X7X30SQ010
 * @property string|null $612158X10X41SQ002
 * @property string|null $612158X10X41SQ003
 * @property string|null $612158X10X41SQ004
 * @property string|null $612158X10X41SQ005
 * @property string|null $612158X10X41SQ006
 * @property string|null $612158X10X41SQ007
 * @property string|null $612158X10X70
 * @property string|null $612158X10X50
 * @property string|null $612158X10X52
 * @property string|null $612158X10X71
 * @property string|null $612158X10X53
 * @property string|null $612158X10X265
 * @property string|null $612158X8X54
 * @property string|null $612158X8X55
 * @property string|null $612158X9X72
 * @property string|null $612158X9X72other
 * @property string|null $612158X9X73
 * @property string|null $612158X9X74
 *
 * @property \App\Model\Entity\Timing $timing
 * @property \App\Model\Entity\Code[] $codes
 */
class Participant extends Entity
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
        'timing_id' => true,
        'token' => true,
        'submitdate' => true,
        'lastpage' => true,
        'startlanguage' => true,
        'seed' => true,
        'startdate' => true,
        'datestamp' => true,
        '612158X1X2' => true,
        '612158X2X4' => true,
        '612158X3X5' => true,
        '612158X3X75' => true,
        '612158X3X7' => true,
        '612158X3X6' => true,
        '612158X3X8' => true,
        '612158X6X108SQ007' => true,
        '612158X6X108SQ008' => true,
        '612158X6X108SQ009' => true,
        '612158X6X108SQ010' => true,
        '612158X6X108SQ011' => true,
        '612158X6X108SQ012' => true,
        '612158X6X108SQ013' => true,
        '612158X6X108SQ014' => true,
        '612158X6X108SQ015' => true,
        '612158X6X108SQ016' => true,
        '612158X6X108SQ017' => true,
        '612158X6X108SQ018' => true,
        '612158X6X108SQ019' => true,
        '612158X6X108SQ020' => true,
        '612158X6X108SQ021' => true,
        '612158X6X108SQ022' => true,
        '612158X6X108SQ023' => true,
        '612158X6X108SQ024' => true,
        '612158X6X108SQ026' => true,
        '612158X6X19' => true,
        '612158X6X21' => true,
        '612158X4X9' => true,
        '612158X4X10' => true,
        '612158X4X11' => true,
        '612158X4X11other' => true,
        '612158X4X12' => true,
        '612158X4X12other' => true,
        '612158X4X13' => true,
        '612158X4X13other' => true,
        '612158X4X14' => true,
        '612158X18X15' => true,
        '612158X5X262' => true,
        '612158X5X16' => true,
        '612158X5X93' => true,
        '612158X5X94' => true,
        '612158X5X95' => true,
        '612158X5X17' => true,
        '612158X5X18' => true,
        '612158X16X263' => true,
        '612158X16X23' => true,
        '612158X16X96' => true,
        '612158X16X97' => true,
        '612158X16X98' => true,
        '612158X16X99' => true,
        '612158X16X100' => true,
        '612158X16X24' => true,
        '612158X16X25' => true,
        '612158X17X264' => true,
        '612158X17X26' => true,
        '612158X17X101' => true,
        '612158X17X102' => true,
        '612158X17X103' => true,
        '612158X17X104' => true,
        '612158X17X105' => true,
        '612158X17X106' => true,
        '612158X17X107' => true,
        '612158X17X27' => true,
        '612158X17X28' => true,
        '612158X7X30SQ001' => true,
        '612158X7X30SQ002' => true,
        '612158X7X30SQ003' => true,
        '612158X7X30SQ004' => true,
        '612158X7X30SQ005' => true,
        '612158X7X30SQ006' => true,
        '612158X7X30SQ007' => true,
        '612158X7X30SQ008' => true,
        '612158X7X30SQ009' => true,
        '612158X7X30SQ010' => true,
        '612158X10X41SQ002' => true,
        '612158X10X41SQ003' => true,
        '612158X10X41SQ004' => true,
        '612158X10X41SQ005' => true,
        '612158X10X41SQ006' => true,
        '612158X10X41SQ007' => true,
        '612158X10X70' => true,
        '612158X10X50' => true,
        '612158X10X52' => true,
        '612158X10X71' => true,
        '612158X10X53' => true,
        '612158X10X265' => true,
        '612158X8X54' => true,
        '612158X8X55' => true,
        '612158X9X72' => true,
        '612158X9X72other' => true,
        '612158X9X73' => true,
        '612158X9X74' => true,
        'timing' => true,
        'codes' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
