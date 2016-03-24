<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-desktop"></i>
        <span><?= __('Humans & Resources')?></span>
    </a>
    <ul class="sub">
        <li><a href="/clients">Clients</a></li>
        <li><a href="/employees">Employees</a></li>
        <li><a href="/equipment">Equipment</a></li>
        <li><a href="/manpower">Manpower</a></li>
        <li><a href="/materials">Materials</a></li>
        <li><a href="/suppliers">Suppliers</a></li>
        <li><a href="/users">Users</a></li>
    </ul>
</li>

<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-tasks"></i>
        <span>Projects</span>
    </a>
    <ul class="sub">
        <li><a  href="/projects">View Projects</a></li>
    </ul>
</li>

<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-archive"></i>
        <span>General Inventories</span>
    </a>
    <ul class="sub">
        <li><a  href="/equipment-general-inventories">Equipment Inventory</a></li>
        <li><a  href="/materials-general-inventories">Materials Inventory</a></li>
        <li><a  href="/manpower-general-inventories">Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-search"></i>
        <span>Track Resources Schedule</span>
    </a>
    <ul class="sub">
        <li><a  href="/track-equipment-schedule">Track Equipment</a></li>
        <li><a  href="/track-materials-schedule">Track Materials</a></li>
        <li><a  href="/track-manpower-schedule">Track Manpower</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-cube"></i>
        <span>Replenishments</span>
    </a>
    <ul class="sub">
        <li><a href="/rental-request-headers">Rental Requests</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'RentalReceiveHeaders', 'action' => 'index']) ?>>Rental Receives</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseOrderHeaders', 'action' => 'index']) ?>>Purchase Orders</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseReceiveHeaders', 'action' => 'index']) ?>>Purchase Receives</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-recycle"></i>
        <span>Resources Management</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceRequestHeaders', 'action' => 'index']) ?>>Create Resources Request</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceTransferHeaders', 'action' => 'index']) ?>>Create Resources Transfer</a></li>
    </ul>
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
