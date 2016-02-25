<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ManpowerTask Entity.
 *
 * @property int $manpower_id
 * @property \App\Model\Entity\Manpower $manpower
 * @property string $task_id
 * @property \App\Model\Entity\Task $task
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class ManpowerTask extends Entity
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
        'manpower_id' => false,
        'task_id' => false,
    ];
}
