<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProjectsFile Entity
 *
 * @property int $id
 * @property int $project_id
 * @property string $file_name
 * @property string $file_location
 * @property string $file_type
 *
 * @property \App\Model\Entity\Project $project
 */
class ProjectsFile extends Entity
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
        'id' => false
    ];
}
