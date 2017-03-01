<div class="materials view large-9 medium-8 columns content">
    <h3><?= h($material->name) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($material->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Unit Measure') ?></th>
            <td><?= h($material->unit_measure) ?></td>
        </tr>
        <tr>
            <th><?= __('Suppliers') ?></th>
            <td>
                <?php foreach($material->suppliers as $supplier):?>
                <?= $supplier->name?><br>
                <?php endforeach;?>
            </td>
        </tr>
    </table>
    </table>
</div>