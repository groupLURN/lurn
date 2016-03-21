<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ManpowerRequestDetail Entity.
 *
 * @property int $resource_request_header_id
 * @property \App\Model\Entity\ResourceRequestHeader $resource_request_header
 * @property int $manpower_type_id
 * @property \App\Model\Entity\ManpowerType $manpower_type
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class ManpowerRequestDetail extends Entity
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
        'resource_request_header_id' => false,
        'manpower_type_id' => false,
    ];
}
