<?php

$defaults = [
    'action'            => 'add', 
    'hidden'            => false, 
    'id'                => 'incident-report-involved-input',
    'itemsDefault'      => ['' => '-Add Items Lost-'],
    'personsDefault'    => ['' => '-Add Persons Involved-']
];

extract($defaults, EXTR_SKIP);

?>

<div id=<?= $id ?>>

    <h4 id="injured-details-header" class="mt"></i>Details of Injured Person/s</h4>

        <?= 
        $this->Form->input('person-list', [
            'class' => 'chosen form-control',
            'label' => [
                        'class' => 'mt',
                        'text' => 'Add Persons involved'
                    ],
            'name' => false,
            'options' => isset($personsInvolved) ? $personsInvolved : $personsDefault
        ]) 
    ?>

            
    <div id="injured-details">
        <?php

            echo $this->Form->input('injured-name', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                   
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-age', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Age/Date of Birth',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-address', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [
                    'text' => 'Address of Injured Person',                    
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-contact', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                
                    'class' => 'mt',
                    'text' => 'Injrued Contact Number'
                ]
            ]);

            echo $this->Form->input('injured-occupation', [
                'class' => 'form-control',
                'disabled' => true,
                'label' => [                 
                    'class' => 'mt'
                ]
            ]);

            echo $this->Form->input('injured-summary', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt',
                    'text' => 'Summary of the injury caused by the incident (parts of the body and severity)'
                ],
                'name' => null,
                'type' => 'textarea'
            ]);
        ?>

    </div>

    <div>
        <button id="add-involved" type="button" class="mt btn btn-default">Add Person</button>
    </div>

    <label class="mt">Persons Involved</label>
    <ol id="persons-involved">
        None.
    </ol>

    <div id="items-lost-details">
        <h4></i>Lost Items/Materials</h4>

        <?php                
            echo $this->Form->input('item-list', [
                'class' => 'chosen form-control',
                'label' => [                   
                    'class' => 'mt',
                    'text' => 'Add Lost Items'
                ],
                'name' => false,
                'options' => $itemsDefault
            ]);

            echo $this->Form->input('item-quantity', [
                'class' => 'form-control',
                'label' => [
                    'class' => 'mt'
                ],
                'name' => false
            ]);

        ?>

        <div>
            <button id="add-item" type="button" class="mt btn btn-default">Add Item</button>
        </div>

        <label class="mt">Lost Items</label>
        <ol id="items-lost">
            None.
        </ol>               
    </div>
</div>
