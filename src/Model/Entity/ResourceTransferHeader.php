<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResourceTransferHeader Entity.
 *
 * @property int $id
 * @property int $resource_request_header_id
 * @property \App\Model\Entity\ResourceRequestHeader $resource_request_header
 * @property int $from_project_id
 * @property int $to_project_id
 * @property \App\Model\Entity\Project $project
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EquipmentTransferDetail[] $equipment_transfer_details
 * @property \App\Model\Entity\ManpowerTransferDetail[] $manpower_transfer_details
 * @property \App\Model\Entity\MaterialTransferDetail[] $material_transfer_details
 */
class ResourceTransferHeader extends Entity
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

    protected function _getNumber()
    {
        return $this->_properties['id'] . '-B';
    }
}
