<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="outerDiv">	
    <div class="innerDiv">
        <?php
        if (Yii :: $app->session->hasFlash('Passwordreset')) {
            echo "<div class ='session-flag'>" . Yii :: $app->session->remove('Passwordreset') . "</div>";
        }
        $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'options' => ['style' => 'text-align:center'],
                        'template' => "{label}\n<div class=\"\">{input}</div>\n<div class=\"error-msgg\">{error}</div>",
                    ],
        ]);
        echo $form->field($ResetPassword, 'CurrentPassword')->passwordInput(['class' => 'form-control-field'])->label('Current Password:', ['class' => 'from-label']);
        echo $form->field($ResetPassword, 'NewPassword')->passwordInput(['class' => 'form-control-field'])->label('New Password:', ['class' => 'from-label']);
        echo $form->field($ResetPassword, 'CofirmNewPassword')->passwordInput(['class' => 'form-control-field'])->label('Cofirm New Password:', ['class' => 'from-label']);
        echo Html::submitbutton('Submit', ['class' => 'btnn']);

        $form = ActiveForm::end();
        ?></div>
</div>