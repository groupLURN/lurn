<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrderDetail Entity.
 *
 * @property int $id
 * @property int $purchase_order_header_id
 * @property \App\Model\Entity\PurchaseOrderHeader $purchase_order_header
 * @property int $material_id
 * @property \App\Model\Entity\Material $material
 * @property int $quantity
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\PurchaseReceiveDetail[] $purchase_receive_details
 */
class PurchaseOrderDetail extends Entity
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
