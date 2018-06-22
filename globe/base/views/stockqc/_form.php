<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Usedcar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usedcar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'version_id')->textInput() ?>

    <?= $form->field($model, 'month')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'km')->textInput() ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_price')->textInput() ?>

    <?= $form->field($model, 'show_price')->textInput() ?>

    <?= $form->field($model, 'downpayment')->textInput() ?>

    <?= $form->field($model, 'emi')->textInput() ?>

    <?= $form->field($model, 'no_of_emis')->textInput() ?>

    <?= $form->field($model, 'sold_price')->textInput() ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cng_fitted')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locality')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'dealer_id')->textInput() ?>

    <?= $form->field($model, 'flag_not_first_choice')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'insurance')->dropDownList([ 'Available' => 'Available', 'Not Available' => 'Not Available', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'dealer_showroom_id')->textInput() ?>

    <?= $form->field($model, 'usedcar_offer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usedcar_insurance_expiry')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deactivation_date')->textInput() ?>

    <?= $form->field($model, 'del_status')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>