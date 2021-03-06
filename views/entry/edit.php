
<?php
$form = $this->beginWidget('HActiveForm', array(
    'id' => 'pages-edit-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <?php if (!$CalendarPlusEntry->isNewRecord) : ?>
                    <?php echo Yii::t('CalendarPlusModule.views_entry_edit', '<strong>Edit</strong> event'); ?>
                <?php else: ?>
                    <?php echo Yii::t('CalendarPlusModule.views_entry_edit', '<strong>Create</strong> event'); ?>
                <?php endif; ?>
            </h4>
        </div>
        <div class="modal-body">

            <?php if ($createFromGlobalCalendar): ?>
                <p><?php echo Yii::t('CalendarPlusModule.views_entry_edit', '<strong>Note:</strong> This event will be created on your profile. To create a space event open the calendar on the desired space.'); ?></p>
            <?php endif; ?>

            <?php echo $form->errorSummary($CalendarPlusEntry); ?>


            <div class="form-group">
                <?php echo $form->labelEx($CalendarPlusEntry, 'title'); ?>
                <?php echo $form->textField($CalendarPlusEntry, 'title', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'Title'))); ?>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($CalendarPlusEntry, 'description'); ?>
                <?php echo $form->textArea($CalendarPlusEntry, 'description', array('class' => 'form-control', 'rows' => '3', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'Description'))); ?>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($CalendarPlusEntry, 'is_public', array()); ?> <?php echo $CalendarPlusEntry->getAttributeLabel('is_public'); ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <?php echo $form->checkBox($CalendarPlusEntry, 'all_day', array('id' => 'allDayCheckbox')); ?> <?php echo $CalendarPlusEntry->getAttributeLabel('all_day'); ?>
                    </label>
                </div>
            </div>

            <div id="datepicker_datetime">
                <div class="form-group">
                    <?php echo $form->labelEx($CalendarPlusEntry, 'start_time'); ?>
                    <?php echo $form->dateTimeField($CalendarPlusEntry, 'start_time', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'Start Date/Time')), array('pickTime' => true)); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($CalendarPlusEntry, 'end_time'); ?>
                    <?php echo $form->dateTimeField($CalendarPlusEntry, 'end_time', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'End Date/Time')), array('pickTime' => true)); ?>
                </div>
            </div>

            <div id="datepicker_date">
                <div class="form-group">
                    <?php echo $form->labelEx($CalendarPlusEntry, 'start_time_date'); ?>
                    <?php echo $form->dateTimeField($CalendarPlusEntry, 'start_time_date', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'Start Date')), array('pickTime' => false)); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($CalendarPlusEntry, 'end_time_date'); ?>
                    <?php echo $form->dateTimeField($CalendarPlusEntry, 'end_time_date', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'End Date')), array('pickTime' => false)); ?>
                </div>
            </div>


            <div class="form-group">
                <?php
                $modes = array(
                    CalendarPlusEntry::PARTICIPATION_MODE_NONE => Yii::t('CalendarPlusModule.views_entry_edit', 'No participants'),
                    //calendarplusPlusEntry::PARTICIPATION_MODE_INVITE => Yii::t('CalendarPlusModule.base', 'Select participants'),
                    CalendarPlusEntry::PARTICIPATION_MODE_ALL => Yii::t('CalendarPlusModule.views_entry_edit', 'Everybody can participate')
                );
                ?>
                <?php echo $form->labelEx($CalendarPlusEntry, 'participant_mode'); ?>
                <?php echo $form->dropDownList($CalendarPlusEntry, 'participation_mode', $modes, array('id' => 'participation_mode', 'class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'End Date/Time')), array('pickTime' => true)); ?>
            </div>

            <div class="form-group" id="selectedUsersField">
                <?php echo $form->labelEx($CalendarPlusEntry, 'selected_participants'); ?>
                <?php echo $form->textField($CalendarPlusEntry, 'selected_participants', array('class' => 'form-control', 'placeholder' => Yii::t('CalendarPlusModule.views_entry_edit', 'Participants'))); ?>
            </div>                
        </div>



        <div class="modal-footer">

            <?php
            echo HHtml::ajaxButton(Yii::t('CalendarPlusModule.views_entry_edit', 'Save'), $this->createContainerUrl('//calendarplus/entry/edit', array('id' => $CalendarPlusEntry->id)), array(
                'type' => 'POST',
                'beforeSend' => 'function(){ setModalLoader(); }',
                'success' => 'function(html){ $("#globalModal").html(html);}',
                    ), array('class' => 'btn btn-primary', 'id' => 'inviteBtn'));
            ?>

            <?php
            if (!$CalendarPlusEntry->isNewRecord) {
                echo CHtml::link(Yii::t('CalendarPlusModule.views_entry_edit', 'Delete'), $this->createContainerUrl('//calendarplus/entry/delete', array('id' => $CalendarPlusEntry->id)), array('class' => 'btn btn-danger'));
            }
            ?>

            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?php echo Yii::t('CalendarPlusModule.views_entry_edit', 'Close'); ?></button>

            <div id="event-loader" class="loader loader-modal hidden"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div>

        </div>


    </div>
</div>
<script>
    $("#allDayCheckbox").change(function() {
        if ($("#allDayCheckbox").attr("checked")) {
            $("#datepicker_datetime").hide();
            $("#datepicker_date").show();
        } else {
            console.log("show");
            $("#datepicker_datetime").show();
            $("#datepicker_date").hide();
        }
    });

    $("#participation_mode").change(function() {
        if ($("#participation_mode").val() == <?php echo CalendarPlusEntry::PARTICIPATION_MODE_INVITE; ?>) {
            $("#selectedUsersField").show();
        } else {
            $("#selectedUsersField").hide();
        }
    });
    if ($("#participation_mode").val() != <?php echo CalendarPlusEntry::PARTICIPATION_MODE_INVITE; ?>) {
            $("#selectedUsersField").hide();
    }

    if ($("#allDayCheckbox").attr("checked")) {
        console.log("hide");
        $("#datepicker_datetime").hide();
        $("#datepicker_date").show();
    } else {
        console.log("show");
        $("#datepicker_datetime").show();
        $("#datepicker_date").hide();
    }

    // set focus to input for space name
    $('#CalendarPlusEntry_title').focus();

    // Shake modal after wrong validation
<?php if ($form->errorSummary($CalendarPlusEntry) != null) { ?>
        $('.modal-dialog').removeClass('fadeIn');
        $('.modal-dialog').addClass('shake');
<?php } ?>

</script>


<?php $this->endWidget(); ?>

<script>
    function openViewModal(id) {
        var viewUrl = '<?php echo Yii::app()->getController()->createContainerUrl('entry/view', array('id' => '-id-')); ?>';
        viewUrl = viewUrl.replace('-id-', encodeURIComponent(id));

        $('#globalModal').modal('hide');
        $('#globalModal').modal({
            show: 'true',
            remote: viewUrl
        });
    }
</script>