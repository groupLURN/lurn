<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseReceiveHeader Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $received_date
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\PurchaseReceiveDetail[] $purchase_receive_details
 */
class PurchaseReceiveHeader extends Entity
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

    protected function _getNumber()
    {
        return $this->_properties['id'] . '-B';
    }
}
