<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RentalReceiveHeader Entity.
 *
 * @property int $id
 * @property int $rental_request_header_id
 * @property \App\Model\Entity\RentalRequestHeader $rental_request_header
 * @property \Cake\I18n\Time $receive_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\RentalReceiveDetail[] $rental_receive_details
 */
class RentalReceiveHeader extends Entity
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
