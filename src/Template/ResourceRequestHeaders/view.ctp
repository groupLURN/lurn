<?= $this->assign('title', 'Resource Request'); ?>
<div class="resourceRequestHeaders view large-9 medium-8 columns content">
    <h3><?= h('Resource Request Number ' . $resourceRequestHeader->number) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Resource Request Number') ?></th>
            <td><?= h($resourceRequestHeader->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Request From') ?></th>
            <td><?= $resourceRequestHeader->has('project_from') ? $this->Html->link($resourceRequestHeader->project_from->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project_from->id]) : 'General' ?></td>
        </tr>
        <tr>
            <th><?= __('Request To') ?></th>
            <td><?= $resourceRequestHeader->has('project_to') ? $this->Html->link($resourceRequestHeader->project_to->title, ['controller' => 'Projects', 'action' => 'view', $resourceRequestHeader->project_to->id]) : 'General' ?></td>
        </tr>
        <tr>
            <th><?= __('Date Needed') ?></th>
            <td><?= h($resourceRequestHeader->required_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Requested') ?></th>
            <td><?= h($resourceRequestHeader->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Equipment Requests') ?></h4>
        <?php if (!empty($resourceRequestHeader->equipment)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Equipment Name') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($resourceRequestHeader->equipment as $equipment): ?>
                    <tr>
                        <td><?= h($equipment->name) ?></td>
                        <th><?= h($equipment->_joinData->quantity) ?></th>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Manpower Requested') ?></h4>
        <?php if (!empty($resourceRequestHeader->manpower_types)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Manpower Types') ?></th>
                    <th><?= __('Quantity') ?></th>
                </tr>
                <?php foreach ($resourceRequestHeader->manpower_types as $manpower_type): ?>
                    <tr>
                        <td><?= h($manpower_type->title) ?></td>
                        <td><?= h($manpower_type->_joinData->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Materials Requested') ?></h4>
        <?php if (!empty($resourceRequestHeader->materials)): ?>
            <table cellpadding="0" cellspacing="0" class="table table-striped">
                <tr>
                    <th><?= __('Materials Name') ?></th>
                    <th><?= __('Unit Measure') ?></th>
                    <th><?= __('Quantity Needed') ?></th>
                </tr>
                <?php foreach ($resourceRequestHeader->materials as $materials): ?>
                    <tr>
                        <td><?= h($materials->name) ?></td>
                        <td><?= h($materials->unit_measure) ?></td>
                        <td><?= h($materials->_joinData->quantity) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
