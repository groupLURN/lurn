<?php
// Third Party CSS
$this->Html->css('/bower_components/gantt/codebase/dhtmlxgantt', ['block' => true]);
// User-defined CSS
$this->Html->css('gantt-chart', ['block' => true]);

// Third Party Script
$this->Html->script('/bower_components/gantt/codebase/sources/dhtmlxgantt', ['block' => 'script-end']);
// User-defined Script
$this->Html->script('gantt-chart', ['block' => 'script-end']);
?>
<?= $this->Flash->render() ?>
<div class="row mt">
    <div class="col-xs-12">
        <div class="content-panel">
            <div class='controls_bar'>
                <div class="row">
                    <div class="col-xs-5 col-xs-offset-1">
                        <strong> Zooming: &nbsp; </strong>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='week'>
                            <span>Hours</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='trplweek'  checked='true'>
                            <span>Days</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='month'>
                            <span>Weeks</span></label>
                        <label>
                            <input name='scales' onclick='zoom_tasks(this)' type='radio' value='year'>
                            <span>Months</span></label>
                    </div>
                    <div class="col-xs-6">
                        <div id="filter_hours">
                            <strong> Display: &nbsp; </strong>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='full_day'>
                                <span>Full day</span>
                            </label>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='work_hours'>
                                <span>Office hours</span>
                            </label>
                        </div>
                        <div id="filter_days">
                            <strong> Display: &nbsp; </strong>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='full_week'>
                                <span>Full week</span>
                            </label>
                            <label>
                                <input name='scales_filter' onclick='set_scale_units(this)' type='radio' value='work_week'>
                                <span>Workdays</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->create() ?>
<?= $this->Form->input('data', ['type' => 'hidden']) ?>

<div id="gantt-chart"></div>

<div class="row mt">
    <div class="col-xs-12">
        <?= $this->Form->button(__('Save Changes'), [
            'class' => 'btn btn-primary btn-submit'
        ]) ?>
    </div>
</div>

<?= $this->Form->end() ?>

<script>
    var __ganttData = <?= $ganttData ?>;
</script>
