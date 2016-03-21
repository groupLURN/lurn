<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResourceRequestDetail Entity.
 *
 * @property int $id
 * @property int $resource_request_header_id
 * @property \App\Model\Entity\ResourceRequestHeader $resource_request_header
 * @property int $equipment_id
 * @property \App\Model\Entity\Equipment $equipment
 * @property int $material_id
 * @property \App\Model\Entity\Material $material
 * @property int $manpower_type_id
 * @property \App\Model\Entity\ManpowerType $manpower_type
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EquipmentTransferDetail[] $equipment_transfer_details
 * @property \App\Model\Entity\ManpowerTransferDetail[] $manpower_transfer_details
 * @property \App\Model\Entity\MaterialTransferDetail[] $material_transfer_details
 */
class ResourceRequestDetail extends Entity
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
