<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Usedcar */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usedcars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usedcar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'description:ntext',
            'version_id',
            'month',
            'year',
            'km',
            'owner',
            'car_price',
            'show_price',
            'downpayment',
            'emi',
            'no_of_emis',
            'sold_price',
            'color',
            'cng_fitted',
            'city',
            'locality',
            'active',
            'dealer_id',
            'created_by',
            'created_by_id',
            'flag_not_first_choice',
            'insurance',
            'dealer_showroom_id',
            'usedcar_offer_id',
            'usedcar_insurance_expiry',
            'source',
            'created_at',
            'updated_at',
            'deactivation_date',
            'del_status',
        ],
    ]) ?>

</div>