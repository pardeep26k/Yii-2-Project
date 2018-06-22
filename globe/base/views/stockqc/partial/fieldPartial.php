<?php
use yii\helpers\Html;

$disabled = false;
if($field->field == 'model' || $field->field == 'power' || $field->field == 'make' || $field->field == 'Displacement' || $field->field == 'SeatingCapacity' || $field->field == 'versionTemp')
{
    $disabled = true;
}
?>

<label for=""> <?= $field->label?><span class="symbol required" aria-required="true"></span></label>
<?php  if($inputType=='textInput'){?>
    <?php echo Html::textInput('field_'.$field->field, $fieldValues[$field->field]['value'],['class'=>"form-control",'id'=> 'field_'.$field->field,'placeholder' => ucwords($field->field), 'disabled' => $disabled]);?>
<?php }?>
<?php  if($inputType=='dropDownList'){?>
    <?php echo Html::dropDownList('field_'.$field->field, $fieldValues[$field->field]['value'],$fieldValues[$field->field]['items'],['class'=>"js-example-basic-single js-states form-control",'id'=> 'field_'.$field->field,'placeholder' => ucwords($field->field), 'disabled' => $disabled]);?>
<?php }?>
<?php if($inputType=='calender'){?>
<div class="row">
    <div class="col-md-12">
        <input type="text" class="form-control datepicker" name="<?='field_'.$field->field;?>" id="<?='field_'.$field->field;?>" value="<?=$fieldValues[$field->field]['value'];?>" data-date-format="yyyy-mm-dd" style="padding-left: 8px !important;" readonly="">
    </div>
</div>
<?php } ?>
