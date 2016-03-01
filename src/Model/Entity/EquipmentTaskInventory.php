<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipmentTaskInventory Entity.
 *
 * @property int $equipment_id
 * @property \App\Model\Entity\Equipment $equipment
 * @property int $project_id
 * @property \App\Model\Entity\Project $project
 * @property string $task_id
 * @property \App\Model\Entity\Task $task
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class EquipmentTaskInventory extends Entity
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
        'equipment_id' => false,
        'project_id' => false,
        'task_id' => false,
    ];
}
