<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseReceiveDetail Entity.
 *
 * @property int $id
 * @property int $purchase_receive_header_id
 * @property \App\Model\Entity\PurchaseReceiveHeader $purchase_receive_header
 * @property int $purchase_order_detail_id
 * @property \App\Model\Entity\PurchaseOrderDetail $purchase_order_detail
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class PurchaseReceiveDetail extends Entity
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
