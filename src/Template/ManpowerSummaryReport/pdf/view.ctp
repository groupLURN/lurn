<?= $this->assign('title', 'Manpower Summary Report') ?>
<?php if (sizeOf($equipmentInventories) > 0): ?>
<table cellspacing="0" class="table table-striped report">
   
</tbody>
</table>
<?php else: ?>
<p>No data available.</p>
<?php endif; ?>