<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\backoffice\UsedcarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usedcar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'version_id') ?>

    <?= $form->field($model, 'month') ?>

    <?= $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'km') ?>

    <?php // echo $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'car_price') ?>

    <?php // echo $form->field($model, 'show_price') ?>

    <?php // echo $form->field($model, 'downpayment') ?>

    <?php // echo $form->field($model, 'emi') ?>

    <?php // echo $form->field($model, 'no_of_emis') ?>

    <?php // echo $form->field($model, 'sold_price') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'cng_fitted') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'locality') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'dealer_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_by_id') ?>

    <?php // echo $form->field($model, 'flag_not_first_choice') ?>

    <?php // echo $form->field($model, 'insurance') ?>

    <?php // echo $form->field($model, 'dealer_showroom_id') ?>

    <?php // echo $form->field($model, 'usedcar_offer_id') ?>

    <?php // echo $form->field($model, 'usedcar_insurance_expiry') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deactivation_date') ?>

    <?php // echo $form->field($model, 'del_status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>