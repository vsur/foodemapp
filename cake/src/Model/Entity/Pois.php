<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pois Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $google_place
 * @property string $icon
 * @property float $rating
 * @property string $vicinity
 * @property string $formatted_phone_number
 * @property string $mail
 * @property string $website
 * @property string $social
 * @property string $description
 * @property int $user_ratings_total
 * @property string $opening_hours
 * @property string $weekday_text
 * @property int $photos
 * @property int $reviews
 * @property \App\Model\Entity\Tag[] $tags
 */
class Pois extends Entity
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
