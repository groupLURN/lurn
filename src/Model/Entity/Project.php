<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity.
 *
 * @property int $id
 * @property int $client_id
 * @property \App\Model\Entity\Client $client
 * @property int $project_manager_id
 * @property int $project_status_id
 * @property \App\Model\Entity\ProjectStatus $project_status
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $end_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Employee[] $employees
 */
class Project extends Entity
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
