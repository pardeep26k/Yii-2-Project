<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yiister\gentelella\widgets\Panel;
use common\helpers\StockqcHelper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\backoffice\UsedcarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stock Evaluation QC');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/stockqc.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$qcStatusList = StockqcHelper::getQcStatus();
$queryParams = Yii::$app->request->queryParams;
$qcStatus = (!empty($queryParams['UsedcarSearch']['qc_status']))?$queryParams['UsedcarSearch']['qc_status']:'pending';
?>
<style>
    .dataTables_filter { visibility: hidden;}
    div.dataTables_wrapper div.dataTables_length select {
    height: 28px;
    background: rgba(255,255,255,0.9);
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    margin-left: -2px;
    border-color: #ccc !important;
    color: #4386cc !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #4386cc !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
    color: #4386cc !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
}
    </style>
<div class="usedcar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php //= Html::a(Yii::t('app', 'Create Usedcar'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
    <div class="col-md-12 col-xs-12">
        <ul id="myTab1" class="nav nav-tabs">
            <?php
            foreach($qcStatusList as $key => $value)
            {
                ?>
                <li class="<?=($qcStatus == $key)?'active':'';?> qc-status">
                    <a href="/stockqc/index?UsedcarSearch[qc_status]=<?=$key?>" aria-expanded="true"><?=$value?></a>
            </li>
            <?php
            }
            ?>
        </ul>
        <?=Html::hiddenInput('qc_status', 'pending', ['id' => 'qc_status'])?>
        <?php
        Panel::begin(
            [
            ]
        )
        ?>
        <p>
 
        <?= \yiister\gentelella\widgets\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'car_id',
                'value' => 'id',
            ],
            [
                'attribute' => 'dealer_name',
                'value' => 'organization'
            ],
            [
                'attribute' => 'agent_name',
                'value' => 'name'
            ],
            [
                'attribute' => 'city_name',
                'value' => 'name_en'
            ],
            [
                'attribute' => 'reg_no',
                'value' => 'regno'
            ],
            [
                'attribute' => 'upload_date',
                'value' => function ($model) {
                $time = $model->created_at;
                $endTime = date('Y-m-d H:i',strtotime('+1 hour +30 minutes',strtotime($time)));
                 return $endTime;
                },
                'format' => ['date', 'php:d-m-Y H:i:s']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'buttons' => ['doqc' => function ($url, $model) { if($model->qc_status != 'pending') { return "&nbsp;&nbsp;<label class='label label-success'>Done</label>";}else{ return Html::a( '<span class="glyphicon glyphicon-cog"> </span>', $url, ['title' => 'Do Qc', 'data-pjax' => '0', 'calss' => 'doqcele'.$model->id, 'target' => '_blank'] );} }],
                'template' => '{doqc}',
            ],
        ],
        'summary'=>'',              
    ]); ?>
</p>
        <?php Panel::end() ?>
    </div>
</div>
</div>

