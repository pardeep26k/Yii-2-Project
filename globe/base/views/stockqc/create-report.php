<?php

use yii\helpers\Html;
use yiister\gentelella\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model common\models\ReportSqlLog */
$this->title = Yii::t('app', 'Create Report');
?>

<div class="usedcar-view">
    <h3><?= Html::encode($this->title) ?></h3>
    <p>
        <?php
        Panel::begin(
            [
                //'header' => Yii::t('app', ''),
            ]
        )
        ?>
       
    <div class="col-md-5">
        <?= Html::beginForm(['createreport'], 'post', ['name' => 'create_report', 'id' => 'create_report','data-parsley-validate']) ?>
        <div class="form-group">
            <label for=''><?= Yii::t('app', 'Create Sql Query') ?></label>
            <?= Html::textArea('createSql','',['placeholder'=>'Select Query'  ,'class'=>'tarea form-control']) ?>
        </div>
        <div class="form-group">
            <label for=''><?= Yii::t('app', 'Report Name') ?></label>
            <?= Html::input('report_name', 'report_name', '', ['id' => 'name', 'class' => 'form-control text-box', 'placeholder' => Yii::t('app', 'Report Name'), 'required' => 'required']) ?>           
        </div>
        <?= Html::submitButton(Yii::t('app', 'submit'), ['id' => 'search_button','name'=>'submit', 'class' => 'btn btn-success custom-btn'])?>
        <?= Html::endForm() ?>
    </div>
        
        
        
        <?php Panel::end() ?>
    </p>
</div>
 <div class="x_content">
    <br />
        <?php  Panel::begin()?>       
            <div style="color:red;">
                <?= $results;  ?>
            </div>
        <?php Panel::end() ?>
    </div>

