<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Manpower Entity.
 *
 * @property int $id
 * @property int $project_id
 * @property int $manpower_type_id
 * @property \App\Model\Entity\ManpowerType $manpower_type
 * @property string $name
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $task_id
 * @property \App\Model\Entity\Task[] $tasks
 */
class Manpower extends Entity
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
