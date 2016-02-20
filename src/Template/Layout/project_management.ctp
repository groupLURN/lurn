<?php
$this->extend('/Layout/default');

$this->start('additional-sidebar');
?>
    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-book"></i>
            <span>Project Management</span>
        </a>
        <ul class="sub">
            <li><a  href="/projects">Task Management</a></li>
        </ul>
    </li>
<?php $this->end(); ?>