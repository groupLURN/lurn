<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RentalReceiveDetail Entity.
 *
 * @property int $id
 * @property int $rental_receive_header_id
 * @property \App\Model\Entity\RentalReceiveHeader $rental_receive_header
 * @property int $rental_request_detail_id
 * @property \App\Model\Entity\RentalRequestDetail $rental_request_detail
 * @property int $quantity
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $end_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class RentalReceiveDetail extends Entity
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
