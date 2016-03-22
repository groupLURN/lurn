<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipmentTransferDetail Entity.
 *
 * @property int $resource_transfer_header_id
 * @property \App\Model\Entity\ResourceTransferHeader $resource_transfer_header
 * @property int $equipment_inventory_id
 * @property \App\Model\Entity\EquipmentInventory $equipment_inventory
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class EquipmentTransferDetail extends Entity
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
        'resource_transfer_header_id' => false,
        'equipment_inventory_id' => false,
    ];
}
