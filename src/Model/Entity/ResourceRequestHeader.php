<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResourceRequestHeader Entity.
 *
 * @property int $id
 * @property int $from_project_id
 * @property int $to_project_id
 * @property \App\Model\Entity\Project $project
 * @property \Cake\I18n\Time $required_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EquipmentRequestDetail[] $equipment_request_details
 * @property \App\Model\Entity\ManpowerRequestDetail[] $manpower_request_details
 * @property \App\Model\Entity\MaterialRequestDetail[] $material_request_details
 * @property \App\Model\Entity\ResourceTransferHeader[] $resource_transfer_headers
 */
class ResourceRequestHeader extends Entity
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
