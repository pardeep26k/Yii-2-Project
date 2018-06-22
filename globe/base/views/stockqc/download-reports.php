<?php

use yii\helpers\Html;
use yiister\gentelella\widgets\Panel;

/* @var $this yii\web\View */
/* @var $model common\models\ReportSqlLog */
$this->title = Yii::t('app', 'Download Report');
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
        <?= Html::beginForm(['downloadreports'], 'post', ['name' => 'create_report', 'id' => 'create_report', 'data-parsley-validate', 'class' => 'form-vertical form-label-left']) ?>
        <div class="form-group">
            <div class="col-xs-12">
                <div class="input-append date input-group " id="qc3"  >
                <ul style="margin:0; padding:0;">
                    <?php foreach ($modelData as $key => $value): ?>
                        <li class="downloadreport" style="font-size:medium;margin-bottom: 20px;">
                            <a href="/stockqc/downloaddata?id=<?= $value->id ?>"><?= ucfirst($value->report_name); ?></a>
                            <div style="float:right;margin-left:500px;" id="<?= $value->id ?>"><a href="/stockqc/deletedata?id=<?= $value->id ?>"><input type="button" value="Delete" name="delete"></a></div></li>
                        
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="from_error" style="color:red;"></div>
        </div>
    </div>

    <?= Html::endForm() ?>
</div>
<?php Panel::end() ?>
</p>
</div>
<div class="x_content">
    <br />
      
    
    
  
</div>

