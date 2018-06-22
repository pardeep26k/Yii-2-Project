<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title  = Yii::t('app', 'Backoffice Login');
?>
<link href="/backend/web/css/site.css" rel="stylesheet" type="text/css">
<link href="/backend/web/css/dashboard.css" rel="stylesheet" type="text/css">
<style>
     #login-box {
    color: #4E4E4E;
    font: 12px Arial,Helvetica,sans-serif;
    height: 352px;
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
#login-box h2 {
    font: bold 24px "Calibri", Arial !important;
}
</style>
<div style="float:right;">
    <?= \common\widgets\LanguageSwitcher::Widget() ?>
</div>
<div id="login-container">
        <?php
        if(Yii::$app->session->hasFlash('Passwordchanged')) 
        { 
            echo "<div class ='session-flag'>".Yii :: $app->session->getFlash('Passwordchanged')."</div>";
        }
        ?>
        <div id="login-box">
            <?php ?>

            <h2><?= Html::encode($this->title) ?></h2>
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
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-login'])->label(Yii::t('app', 'User Name').':', ['id' => 'login-box-name']); ?>
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-login'])->label(Yii::t('app', 'Password').':', ['id' => 'login-box-name']); ?>
           
            <?=
            $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8 session-flag\">{error}</div>",
            ])->label(Yii::t('app', 'Remember Me'));
            
            ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11"></br></br>
                    <?= Html::submitButton('', ['class' => 'btn-submit', 'name' => 'login-button']) ?>
                </div>
                </br></br>
                <div class="col-md-6">
                    <?= Html::a(Yii::t('app', 'Forgot Password').' ?', ['forgotpassword']) ?>
                </div>
               

                
            </div>
<?php ActiveForm::end(); 
           ?>
        </div>
</div>