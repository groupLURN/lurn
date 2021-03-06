<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipment Entity.
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\EquipmentGeneralInventory[] $equipment_general_inventories
 * @property \App\Model\Entity\EquipmentInventory[] $equipment_inventories
 * @property \App\Model\Entity\EquipmentProjectInventory[] $equipment_project_inventories
 * @property \App\Model\Entity\EquipmentTaskInventory[] $equipment_task_inventories
 * @property \App\Model\Entity\Task[] $tasks
 */
class Equipment extends Entity
{

    public static function getTypes()
    {
        return [
            1 => 'In-House',
            2 => 'Rented'
        ];
    }

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
