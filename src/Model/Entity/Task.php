<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

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
 * @property \App\Model\Entity\Equipment[] $equipment
 * @property \App\Model\Entity\Manpower[] $manpower
 * @property \App\Model\Entity\Material[] $materials
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
}
