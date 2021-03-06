<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RentalRequestDetail Entity.
 *
 * @property int $id
 * @property int $rental_request_header_id
 * @property \App\Model\Entity\RentalRequestHeader $rental_request_header
 * @property int $equipment_id
 * @property \App\Model\Entity\Equipment $equipment
 * @property int $quantity
 * @property int $duration
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\RentalReceiveDetail[] $rental_receive_details
 */
class RentalRequestDetail extends Entity
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
