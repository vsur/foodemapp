<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Timing Entity
 *
 * @property int $id
 * @property float|null $interviewtime
 * @property float|null $612158X1time
 * @property float|null $612158X1X2time
 * @property float|null $612158X2time
 * @property float|null $612158X2X4time
 * @property float|null $612158X3time
 * @property float|null $612158X3X5time
 * @property float|null $612158X3X75time
 * @property float|null $612158X3X7time
 * @property float|null $612158X3X6time
 * @property float|null $612158X3X8time
 * @property float|null $612158X6time
 * @property float|null $612158X6X108time
 * @property float|null $612158X6X19time
 * @property float|null $612158X6X21time
 * @property float|null $612158X4time
 * @property float|null $612158X4X9time
 * @property float|null $612158X4X10time
 * @property float|null $612158X4X11time
 * @property float|null $612158X4X12time
 * @property float|null $612158X4X13time
 * @property float|null $612158X4X14time
 * @property float|null $612158X18time
 * @property float|null $612158X18X15time
 * @property float|null $612158X5time
 * @property float|null $612158X5X262time
 * @property float|null $612158X5X16time
 * @property float|null $612158X5X93time
 * @property float|null $612158X5X94time
 * @property float|null $612158X5X95time
 * @property float|null $612158X5X17time
 * @property float|null $612158X5X18time
 * @property float|null $612158X16time
 * @property float|null $612158X16X263time
 * @property float|null $612158X16X23time
 * @property float|null $612158X16X96time
 * @property float|null $612158X16X97time
 * @property float|null $612158X16X98time
 * @property float|null $612158X16X99time
 * @property float|null $612158X16X100time
 * @property float|null $612158X16X24time
 * @property float|null $612158X16X25time
 * @property float|null $612158X17time
 * @property float|null $612158X17X264time
 * @property float|null $612158X17X26time
 * @property float|null $612158X17X101time
 * @property float|null $612158X17X102time
 * @property float|null $612158X17X103time
 * @property float|null $612158X17X104time
 * @property float|null $612158X17X105time
 * @property float|null $612158X17X106time
 * @property float|null $612158X17X107time
 * @property float|null $612158X17X27time
 * @property float|null $612158X17X28time
 * @property float|null $612158X7time
 * @property float|null $612158X7X30time
 * @property float|null $612158X10time
 * @property float|null $612158X10X41time
 * @property float|null $612158X10X70time
 * @property float|null $612158X10X50time
 * @property float|null $612158X10X52time
 * @property float|null $612158X10X71time
 * @property float|null $612158X10X53time
 * @property float|null $612158X10X265time
 * @property float|null $612158X8time
 * @property float|null $612158X8X54time
 * @property float|null $612158X8X55time
 * @property float|null $612158X9time
 * @property float|null $612158X9X72time
 * @property float|null $612158X9X73time
 * @property float|null $612158X9X74time
 *
 * @property \App\Model\Entity\Participant[] $participants
 */
class Timing extends Entity
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
        'interviewtime' => true,
        '612158X1time' => true,
        '612158X1X2time' => true,
        '612158X2time' => true,
        '612158X2X4time' => true,
        '612158X3time' => true,
        '612158X3X5time' => true,
        '612158X3X75time' => true,
        '612158X3X7time' => true,
        '612158X3X6time' => true,
        '612158X3X8time' => true,
        '612158X6time' => true,
        '612158X6X108time' => true,
        '612158X6X19time' => true,
        '612158X6X21time' => true,
        '612158X4time' => true,
        '612158X4X9time' => true,
        '612158X4X10time' => true,
        '612158X4X11time' => true,
        '612158X4X12time' => true,
        '612158X4X13time' => true,
        '612158X4X14time' => true,
        '612158X18time' => true,
        '612158X18X15time' => true,
        '612158X5time' => true,
        '612158X5X262time' => true,
        '612158X5X16time' => true,
        '612158X5X93time' => true,
        '612158X5X94time' => true,
        '612158X5X95time' => true,
        '612158X5X17time' => true,
        '612158X5X18time' => true,
        '612158X16time' => true,
        '612158X16X263time' => true,
        '612158X16X23time' => true,
        '612158X16X96time' => true,
        '612158X16X97time' => true,
        '612158X16X98time' => true,
        '612158X16X99time' => true,
        '612158X16X100time' => true,
        '612158X16X24time' => true,
        '612158X16X25time' => true,
        '612158X17time' => true,
        '612158X17X264time' => true,
        '612158X17X26time' => true,
        '612158X17X101time' => true,
        '612158X17X102time' => true,
        '612158X17X103time' => true,
        '612158X17X104time' => true,
        '612158X17X105time' => true,
        '612158X17X106time' => true,
        '612158X17X107time' => true,
        '612158X17X27time' => true,
        '612158X17X28time' => true,
        '612158X7time' => true,
        '612158X7X30time' => true,
        '612158X10time' => true,
        '612158X10X41time' => true,
        '612158X10X70time' => true,
        '612158X10X50time' => true,
        '612158X10X52time' => true,
        '612158X10X71time' => true,
        '612158X10X53time' => true,
        '612158X10X265time' => true,
        '612158X8time' => true,
        '612158X8X54time' => true,
        '612158X8X55time' => true,
        '612158X9time' => true,
        '612158X9X72time' => true,
        '612158X9X73time' => true,
        '612158X9X74time' => true,
        'participants' => true,
    ];
}
