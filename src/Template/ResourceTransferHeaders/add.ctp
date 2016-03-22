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
                'resource' => 'equipment'
            ]
        ],
        'data' => array_map(function($equipment_request_detail)
        {
            return [
                'id' => $equipment_request_detail->equipment_id,
                'name' => $equipment_request_detail->equipment['name'],
                'quantity' => $equipment_request_detail->quantity,
                'list' =>
                    call_user_func(function($equipmentInventories) use ($equipment_request_detail)
                    {
                        $list = [];
                        foreach($equipmentInventories as $equipmentInventory)
                            $list[$equipmentInventory->id] = $equipmentInventory->id . ' - ' .
                                $equipment_request_detail->equipment->name;
                        return $list;
                    }, $equipment_request_detail->equipment['equipment_general_inventories'])
            ];
        }, $selectedResourceRequestHeader->equipment_request_details)
    ]) ?>

    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary btn-submit'
    ]) ?>

    <?= $this->Form->end() ?>
    </div>
</div>
