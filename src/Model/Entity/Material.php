<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Material Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $unit_measure
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\MaterialsGeneralInventory[] $materials_general_inventories
 * @property \App\Model\Entity\MaterialsProjectInventory[] $materials_project_inventories
 * @property \App\Model\Entity\MaterialsTaskInventory[] $materials_task_inventories
 * @property \App\Model\Entity\Task[] $tasks
 */
class Material extends Entity
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
