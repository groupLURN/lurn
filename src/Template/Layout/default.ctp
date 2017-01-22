<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-desktop"></i>       
        <span><?= __('Project Team & Assets')?> 
        <span class="caret"> </span>
        </span>         
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'clients', 'action' => 'index']) ?>>Clients</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'employees', 'action' => 'index']) ?>>Employees</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'equipment', 'action' => 'index']) ?>>Equipments</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'manpower', 'action' => 'index']) ?>>Manpower</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'materials', 'action' => 'index']) ?>>Materials</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'suppliers', 'action' => 'index']) ?>>Suppliers</a></li>
    </ul>
</li>

<li class="sub-menu">
    <a href=<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?> >
        <i class="fa fa-tasks"></i>
        <span>Projects</span>
        <!--span class="caret"> </span-->
    </a>
    <!--<ul class="sub">
       <li><a href=<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>>View All Projects</a></li>
       <li><a href=<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>>Projects Planning</a></li>
    </ul>-->
</li>

<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-archive"></i>
        <span>General Inventories</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'equipment-general-inventories', 'action' => 'index']) ?>>Equipment Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'materials-general-inventories', 'action' => 'index']) ?>>Materials Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'manpower-general-inventories', 'action' => 'index']) ?>>Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-search"></i>
        <span>Track Resources Schedule</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'track-equipment-schedule', 'action' => 'index']) ?>>Track Equipment</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'track-materials-schedule', 'action' => 'index']) ?>>Track Materials</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'track-manpower-schedule', 'action' => 'index']) ?>>Track Manpower</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-cube"></i>
        <span>Replenishments</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'rental-request-headers', 'action' => 'index']) ?>>Rental Requests</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'RentalReceiveHeaders', 'action' => 'index']) ?>>Rental Receives</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseOrderHeaders', 'action' => 'index']) ?>>Purchase Orders</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseReceiveHeaders', 'action' => 'index']) ?>>Purchase Receives</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-recycle"></i>
        <span>Resources Management</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceRequestHeaders']) ?>>Create Resources Request</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceTransferHeaders']) ?>>Create Resources Transfer</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="Javascript:;" >
        <i class="fa fa-file"></i>
        <span>Reports</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentGeneralInventoryReport']) ?>>Equipment Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsGeneralInventoryReport']) ?>>Materials Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerGeneralInventoryReport']) ?>>Manpower Inventory Report</a></li>     
        <li><a href=<?= $this->Url->build(['controller' => 'IncidentReportHeaders', 'action' => 'index']) ?>>Incident Reports</a></li>
    </ul>
</li>
<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
