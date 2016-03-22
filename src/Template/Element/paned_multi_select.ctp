<?php
$defaults = [
    'data' => [
        [
            'id' => 100,
            'name' => 'Equipment',
            'quantity' => 3
        ],
        [
            'id' => 101,
            'name' => 'Equipment2',
            'quantity' => 2
        ]
    ]
];

extract($defaults, EXTR_SKIP);
?>

<ul class="nav nav-pills nav-stacked">
    <?php $i = 0; foreach($data as $array) : ?>
    <li <?= $i++ === 0? 'class="active"': ''?>>
        <a onclick="javascript:selectCurrentPill(this)" style="cursor: pointer;">
            <?= $array['quantity'] . "x\t" . $array['name'] ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>

<script>
    function selectCurrentPill(element)
    {
        var $context = $(element).closest("ul");
        $context.find("li").removeClass("active");
        $(element).closest("li").addClass("active");
    }
</script>