<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipmentInventory Entity.
 *
 * @property int $id
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property string $task_id
 * @property \App\Model\Entity\Task $task
 * @property int $equipment_id
 * @property \App\Model\Entity\Equipment $equipment
 * @property int $rental_receive_detail_id
 * @property \App\Model\Entity\RentalReceiveDetail $rental_receive_detail
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class EquipmentInventory extends Entity
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
