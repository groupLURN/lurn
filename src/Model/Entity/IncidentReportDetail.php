<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IncidentReportDetail Entity
 *
 * @property int $id
 * @property int $incident_report_header_id
 * @property string $type
 * @property string $value
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\IncidentReportHeader $incident_report_header
 */
class IncidentReportDetail extends Entity
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
