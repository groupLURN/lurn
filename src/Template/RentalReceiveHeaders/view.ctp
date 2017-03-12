<?= $this->assign('title', 'Rental Receive') ?>
<div class="rentalReceiveHeaders view large-9 medium-8 columns content">
    <h3><?= 'Rental Receive Number ' . h($rentalReceiveHeader->number) ?></h3>
    <table class="vertical-table table table-striped">
        <tr>
            <th><?= __('Rental Receive Number') ?></th>
            <td><?= h($rentalReceiveHeader->number) ?></td>
        </tr>
        <tr>
            <th><?= __('Rental Request Number') ?></th>
            <td><?= h($rentalReceiveHeader->rental_receive_details[0]->rental_request_detail->rental_request_header->number) ?></td>
        </tr>
        <?php if($rentalReceiveHeader->rental_receive_details[0]->rental_request_detail->rental_request_header->has('project')) : ?>
        <tr>
            <th><?= __('Project') ?></th>
            <td><?= h($rentalReceiveHeader->rental_receive_details[0]->rental_request_detail->rental_request_header->project->title) ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th><?= __('Supplier') ?></th>
            <td><?= h($rentalReceiveHeader->rental_receive_details[0]->rental_request_detail->rental_request_header->supplier->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Requested') ?></th>
            <td><?= h(date_format($rentalReceiveHeader->rental_receive_details[0]->rental_request_detail->rental_request_header->created, 'F d, Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Received') ?></th>
            <td><?= h(date_format($rentalReceiveHeader->receive_date, 'F d, Y')) ?></td>
        </tr>
    </table>
    <div class="related">
        <?php if (!empty($rentalReceiveHeader->rental_receive_details)): ?>
        <h3><?= __('Rental Receive Details') ?></h3>
        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tr>
                <th><?= __('Equipment') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
            </tr>
            <?php foreach ($rentalReceiveHeader->rental_receive_details as $rentalReceiveDetails): ?>
            <tr>
                <td><?= h($rentalReceiveDetails->rental_request_detail->equipment->name) ?></td>
                <td><?= h($rentalReceiveDetails->quantity) ?></td>
                <td><?= h($rentalReceiveDetails->start_date) ?></td>
                <td><?= h($rentalReceiveDetails->end_date) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
