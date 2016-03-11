<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RentalRequestHeader Entity.
 *
 * @property int $id
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property int $supplier_id
 * @property \App\Model\Entity\Supplier $supplier
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\RentalReceiveHeader[] $rental_receive_headers
 * @property \App\Model\Entity\RentalRequestDetail[] $rental_request_details
 */
class RentalRequestHeader extends Entity
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
        '*' => true
    ];
}
