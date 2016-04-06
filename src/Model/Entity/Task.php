<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use DateTime;

/**
 * Task Entity.
 *
 * @property string $id
 * @property string $milestone_id
 * @property \App\Model\Entity\Milestone $milestone
 * @property string $title
 * @property bool $is_finished
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $end_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $comments
 * @property \App\Model\Entity\EquipmentInventory[] $equipment_inventories
 * @property \App\Model\Entity\Manpower[] $manpower
 * @property \App\Model\Entity\MaterialsTaskInventory[] $materials_task_inventories
 * @property \App\Model\Entity\Equipment[] $equipment
 * @property \App\Model\Entity\ManpowerType[] $manpower_types
 * @property \App\Model\Entity\Material[] $materials
 * @property \App\Model\Entity\EquipmentReplenishmentDetail[] $equipment_replenishment_details
 * @property \App\Model\Entity\ManpowerTypeReplenishmentDetail[] $manpower_type_replenishment_details
 * @property \App\Model\Entity\MaterialReplenishmentDetail[] $material_replenishment_details
 */
class Task extends Entity
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
        'id' => true,
    ];

    protected function _getParentUid()
    {
        if(isset($this->_properties['parent_uid']))
            return $this->_properties['parent_uid'];
        else
            return null;
    }

    protected function _getStatus()
    {
        $now = new DateTime();

        if($this->is_finished === false && $now < $this->start_date)
            return 'Pending';
        else if($this->is_finished === false && $this->start_date <= $now && $now <= $this->end_date)
            return 'In Progress';
        else if($this->is_finished === false && $now > $this->end_date)
            return 'Overdue';
        else if($this->is_finished === true);
            return 'Done';
    }

}
