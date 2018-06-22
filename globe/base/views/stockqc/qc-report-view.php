<?php

use yii\helpers\Html;
use yiister\gentelella\widgets\Panel;

/* @var $this yii\web\View */
/* @var $result common\models\Usedcar */
$this->title = Yii::t('app', 'Qc Report');
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
        <div class="x_content">
        <br />
        <?= Html::beginForm(['qcreport'], 'post', ['name' => 'qcreport_stockqc', 'id' => 'qcreport_stockqc', 'enctype' => 'multipart/form-data', 'data-parsley-validate', 'class' => 'form-vertical form-label-left']) ?>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                 <div class="input-append date input-group " id="qc3"  data-date-format="dd-mm-yyyy">
                                   
               <?= \yii\jui\DatePicker::widget([
                   'name' => 'report_from',
		    'language' => 'en',
		    'dateFormat' => 'yyyy-MM-dd',
		    'options' => ['class' => 'span2 form-control add-on follow_calender calender','placeholder' => Yii::t('app', 'From'), 'style'=>'cursor:pointer;','readonly'=>'readonly', 'id' => 'report_from']
		]); ?>
                             </div>
                <div id="from_error" style="color:red;"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
               <div class="input-append date input-group " id="qc4"  data-date-format="dd-mm-yyyy">
                                   
                    <?= \yii\jui\DatePicker::widget([
                    'name' => 'report_to',
		    'language' => 'en',
		    'dateFormat' => 'yyyy-MM-dd',
		    'options' => ['class' => 'span2 form-control add-on follow_calender calender','placeholder'=>Yii::t('app', 'To'), 'style'=>'cursor:pointer;','readonly'=>'readonly', 'id' => 'report_to']
		]); ?>
                              </div>
                <div id="to_error" style="color:red;"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?= Html::input('email', 'email', '', ['id' => 'email', 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => Yii::t('app', 'Enter Email'), 'required' => 'required']) ?>
            </div>
        </div>
        <div class="form-group">
          <div class="col-md-1 col-sm-3 col-xs-12">
            <?= Html::submitButton(Yii::t('app', 'Send Mail'), ['id' => 'search_button','name'=>'send_mail', 'class' => 'btn btn-success','style'=>'margin-left: 94px;
                                                                                                                                                    margin-top: -4px'])?>
            <?= Html::submitButton(Yii::t('app', 'Download'), ['id' => 'search_button','name'=>'download', 'class' => 'btn btn-success','style' =>' margin-top: -59px;'])?>
          </div>
        </div>
        <?= Html::endForm() ?>
        </div>
        <?php Panel::end() ?>
    </p>
   
</div>
 <div class="x_content">
    <br />
        <?php  Panel::begin()?>       
            <div style="color:red;">
                <?php echo $results; ?>
            </div>
        <?php Panel::end() ?>
    </div>

