<?= $this->Flash->render() ?>
<?= $this->assign('title', 'Create Resources Transfer') ?>
<div class="row mt">
    <div class="col-md-12">
    <?= $this->Form->create($resourceTransferHeader) ?>
    <fieldset>
        <legend><?= __('Create Resources Transfer') ?></legend>
        <?php

        echo $this->Form->input('resource_request_header_id', [
            'class' => 'form-control chosen',
            'label' => [
                'class' => 'mt',
                'text' => 'Resources Request Number'
            ],
            'options' => [null => '-'] + $resourceRequestHeadersHash,
            'val' => isset($resources_request_number)? $resources_request_number: 0,
            'onchange' => sprintf("
                if(!confirm('Are you sure you want to change resource request number? This will erase the details below.'))
                {
                    event.preventDefault();
                    return;
                }
                window.location = '%s' + '?resources_request_number=' + $(this).val();
            ", $this->Url->build(['controller' => 'ResourceTransferHeaders', 'action' => 'add']))
        ]);

        echo $this->Form->input('from_project_id', [
            'class' => 'form-control chosen',
            'label' => [
                'text' => 'Transfer From',
                'class' => 'mt'
            ],
            'options' => [null => 'General']
        ]);

        echo $this->Form->input('to_project_id', [
            'class' => 'form-control chosen',
            'label' => [
                'text' => 'Transfer To',
                'class' => 'mt'
            ],
            'options' => $projects
        ]);

        ?>
    </fieldset>
    <?= $this->element('paned_multi_select', [
        'leftPane' => [
            'title' => 'Equipment Requested',
            'enableInitialization' => true
        ],
        'rightPane' => [
            'title' => 'Transfer Equipment',
            'options' => [
                'quantity' => false,
                'resource' => 'equipment_inventories'
            ]
        ],
        'data' => array_map(function($request_detail)
        {
            return [
                'id' => $request_detail->equipment_id,
                'name' => $request_detail->equipment['name'],
                'quantity' => $request_detail->quantity_remaining,
                'list' =>
                    call_user_func(function($equipmentInventories) use ($request_detail)
                    {
                        $list = [];
                        foreach($equipmentInventories as $equipmentInventory)
                            if(
                                $equipmentInventory->rental_receive_detail_id === null ||
                                $equipmentInventory->rental_receive_detail_id !== null &&
                                $equipmentInventory->has('rental_receive_detail')
                            )
                            $list[$equipmentInventory->id] =
                                (
                                    !$equipmentInventory->has('rental_receive_detail')? 'In-House':
                                    'Rental ' . $equipmentInventory->rental_receive_detail->rental_receive_header_id
                                ) . ' / ' . $equipmentInventory->id . ' - ' . $request_detail->equipment->name;
                        return $list;
                    }, $request_detail->equipment['equipment_general_inventories'])
            ];
        }, isset($selectedResourceRequestHeader->equipment_request_details)? $selectedResourceRequestHeader->equipment_request_details: [])
    ]) ?>

    <?= $this->element('paned_multi_select', [
        'leftPane' => [
            'title' => 'Manpower Requested',
            'enableInitialization' => true
        ],
        'rightPane' => [
            'title' => 'Transfer Manpower',
            'options' => [
                'quantity' => false,
                'resource' => 'manpower'
            ]
        ],
        'data' => array_map(function($request_detail)
        {
            return [
                'id' => $request_detail->manpower_type_id,
                'name' => $request_detail->manpower_type['title'],
                'quantity' => $request_detail->quantity_remaining,
                'list' =>
                    call_user_func(function($manpowerInventories) use ($request_detail)
                    {
                        $list = [];
                        foreach($manpowerInventories as $manpowerInventory)
                            $list[$manpowerInventory->id] = $manpowerInventory->name;
                        return $list;
                    }, $request_detail->manpower_type['manpower_general_inventories'])
            ];
        }, isset($selectedResourceRequestHeader->manpower_request_details)? $selectedResourceRequestHeader->manpower_request_details: [])
    ]) ?>


    <?= $this->element('paned_multi_select', [
        'leftPane' => [
            'title' => 'Materials Requested',
            'enableInitialization' => true
        ],
        'rightPane' => [
            'title' => 'Transfer Materials',
            'options' => [
                'quantity' => true,
                'resource' => 'materials'
            ]
        ],
        'isSingularChecker' => false,
        'data' => array_map(function($request_detail)
        {
            return [
                'id' => $request_detail->material_id,
                'name' => $request_detail->material['name'] . ' ' . $request_detail->material->unit_measure,
                'quantity' => $request_detail->quantity_remaining,
                'list' =>
                    call_user_func(function($materialInventories) use ($request_detail)
                    {
                        $list = [];
                        foreach($materialInventories as $materialInventory)
                            $list['Available Quantity = ' . $materialInventory->quantity][$materialInventory->material_id] = $request_detail->material->name . ' ' .
                                $request_detail->material->unit_measure;
                        return $list;
                    }, $request_detail->material['materials_general_inventories'])
            ];
        }, isset($selectedResourceRequestHeader->material_request_details)? $selectedResourceRequestHeader->material_request_details: [])
    ]) ?>

    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary btn-submit',
        'onclick' => "
            if(!confirm('Once the resources transfer is submitted, the resources transfer cannot be edited or deleted. Are you sure with your resources transfer?'))
                event.preventDefault();
            "
    ]) ?>

    <?= $this->Form->end() ?>
    </div>
</div>
