<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $ForgotPassword app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Forget Password');
?>
<link href="/backend/web/css/site.css" rel="stylesheet" type="text/css">
<link href="/backend/web/css/dashboard.css" rel="stylesheet" type="text/css">
<style>
     #login-box {
    color: #4E4E4E;
    font: 12px Arial,Helvetica,sans-serif;
    height: 225px;
    padding: 20px 0 0 30px;
    width: 296px;
    float:none!important;
    margin: auto;
    border: 5px solid #999;
}
label {
    margin-left:0px !important;
    margin-bottom: 5px;
}
</style>
<div style="float:right;">
    <?= \common\widgets\LanguageSwitcher::Widget() ?>
</div>
<div id="login-container">
        <div id="login-box">
            <label id="login-box-name" class="col-lg-1 control-label" for="loginform-username"><?= Yii::t('app', 'Please Enter Your Registerd Email') ?></label>
            </br></br></br>
            <?php
           
            $form = ActiveForm::begin([
                        'id'          => 'login-form',
                        'options'     => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template'     => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8 error-msg\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
            ]);
            ?>
            <?= $form->field($ForgotPassword, 'email')->textInput(['autofocus' => true, 'class' => 'form-login'])->label(Yii::t('app', 'Email').':', ['id' => 'login-box-name']); ?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11"></br></br>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' =>'btn_org4 hideonclick btn btn-primary btn-lg']) ?>
                </div>
            </div>
<?php ActiveForm::end(); 
           ?>
        </div>
</div>        
