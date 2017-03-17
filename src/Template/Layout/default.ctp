<?php
$this->extend('/Layout/base');
$this->start('additional-sidebar');
?>

<?php 
    if (in_array($employeeType, [0, 4], true)) {
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-desktop"></i>       
        <span><?= __('Project Team & Assets')?> 
        <span class="caret"> </span>
        </span>         
    </a>
    <ul class="sub">
        <?php 
            if ($employeeType == 0) {
        ?>
        <li><a href=<?= $this->Url->build(['controller' => 'Clients', 'action' => 'index']) ?>>Clients</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Employees', 'action' => 'index']) ?>>Employees</a></li><?php 
            }
        ?>
        <li><a href=<?= $this->Url->build(['controller' => 'Equipment', 'action' => 'index']) ?>>Equipment</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Manpower', 'action' => 'index']) ?>>Manpower</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Materials', 'action' => 'index']) ?>>Materials</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'Suppliers', 'action' => 'index']) ?>>Suppliers</a></li>
    </ul>
</li>
<?php 
    }
?>

<li class="sub-menu">
    <a href=<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?> >
        <i class="fa fa-tasks"></i>
        <span>Projects</span>
        <!--span class="caret"> </span-->
    </a>
</li>

<?php 
    if (in_array($employeeType, [0, 4], true)) {
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-archive"></i>
        <span>General Inventories</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentGeneralInventories', 'action' => 'index']) ?>>Equipment Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsGeneralInventories', 'action' => 'index']) ?>>Materials Inventory</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerGeneralInventories', 'action' => 'index']) ?>>Manpower Inventory</a></li>
    </ul>
</li>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-search"></i>
        <span>Track Resources Schedule</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'TrackEquipmentSchedule', 'action' => 'index']) ?>>Track Equipment</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'TrackMaterialsSchedule', 'action' => 'index']) ?>>Track Materials</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'TrackManpowerSchedule', 'action' => 'index']) ?>>Track Manpower</a></li>
    </ul>
</li>
<?php 
    }
?>

<?php 
    if (in_array($employeeType, [0, 4], true)) {
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-cube"></i>
        <span>Replenishments</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <li><a href=<?= $this->Url->build(['controller' => 'RentalRequestHeaders', 'action' => 'index']) ?>>Rental Requests</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'RentalReceiveHeaders', 'action' => 'index']) ?>>Rental Receives</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseOrderHeaders', 'action' => 'index']) ?>>Purchase Orders</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'PurchaseReceiveHeaders', 'action' => 'index']) ?>>Purchase Receives</a></li>
    </ul>
</li>
<?php 
    }
?>

<?php 
    if (in_array($employeeType, [0, 2, 4], true)) {
?>
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="fa fa-recycle"></i>
        <span>Resources Management</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <?php 
            if (in_array($employeeType, [0, 2], true)) {
        ?>
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceRequestHeaders', 'action' => 'index']) ?>>Create Resources Request</a></li>
        <?php 
            }
            if (in_array($employeeType, [0, 4], true)) {
        ?>
        <li><a href=<?= $this->Url->build(['controller' => 'ResourceTransferHeaders', 'action' => 'index']) ?>>Create Resources Transfer</a></li>
        <?php 
            }
        ?>
    </ul>
</li>
<?php 
    }
?>

<?php 
    if (in_array($employeeType, [0, 2, 3, 4], true)) {
?>
<li class="sub-menu">
    <a href="Javascript:;" >
        <i class="fa fa-file"></i>
        <span>Reports</span>
        <span class="caret"> </span>
    </a>
    <ul class="sub">
        <?php 
            if (in_array($employeeType, [0, 4], true)) {
        ?>
        <li><a href=<?= $this->Url->build(['controller' => 'EquipmentGeneralInventoryReport', 'action' => 'index']) ?>>Equipment Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'MaterialsGeneralInventoryReport', 'action' => 'index']) ?>>Materials Inventory Report</a></li>
        <li><a href=<?= $this->Url->build(['controller' => 'ManpowerGeneralInventoryReport', 'action' => 'index']) ?>>Manpower Inventory Report</a></li> 
        <?php 
            }
        ?>    
    </ul>
</li>
<?php 
    }
?>

<?php $this->end(); ?>
<?= $this->fetch('content'); ?>
