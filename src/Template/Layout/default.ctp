<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-desktop"></i>
        <span><?= __('Project Team & Assets')?></span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'Clients']) ?>>Clients</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Employees']) ?>>Employees</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Equipment']) ?>>Equipment</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Manpower']) ?>>Manpower</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Materials']) ?>>Materials</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Suppliers']) ?>>Suppliers</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Users']) ?>>Users</a></li>
    </ul>
</li>

<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-tasks"></i>
        <span>Projects</span>
    </a>
    <ul class="sub">
        <li><a  href=<?= $this->Url->build(['controller' => 'Projects']) ?>>View Projects</a></li>
    </ul>
</li>

<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-archive"></i>
        <span>General Inventories</span>
    </a>
    <ul class="sub">
        <li><a  href=<?= $this->Url->build(['controller' => 'EquipmentGeneralInventories']) ?>>Equipment Inventory</a></li>
        <li><a  href=<?= $this->Url->build(['controller' => 'MaterialsGeneralInventories']) ?>>Materials Inventory</a></li>
        <li><a  href=<?= $this->Url->build(['controller' => 'ManpowerGeneralInventories']) ?>>Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-search"></i>
        <span>Track Resources Schedule</span>
    </a>
    <ul class="sub">
        <li><a  href=<?= $this->Url->build(['controller' => 'TrackEquipmentSchedule']) ?>>Track Equipment</a></li>
        <li><a  href=<?= $this->Url->build(['controller' => 'TrackMaterialsSchedule']) ?>>Track Materials</a></li>
        <li><a  href=<?= $this->Url->build(['controller' => 'TrackManpowerSchedule']) ?>>Track Manpower</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-cube"></i>
        <span>Replenishments</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'RentalRequestHeaders']) ?>>Rental Requests</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'RentalReceiveHeaders']) ?>>Rental Receives</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseOrderHeaders']) ?>>Purchase Orders</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseReceiveHeaders']) ?>>Purchase Receives</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-recycle"></i>
        <span>Resources Management</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceRequestHeaders']) ?>>Create Resources Request</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceTransferHeaders']) ?>>Create Resources Transfer</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-file"></i>
        <span>General Reports</span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentGeneralInventoryReport']) ?>>Equipment Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsGeneralInventoryReport']) ?>>Materials Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerGeneralInventoryReport']) ?>>Manpower Inventory Report</a></li>
    </ul>
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
