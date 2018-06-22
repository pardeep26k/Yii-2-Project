<?php

namespace backoffice\globe\base\controllers;

use Yii;
use backoffice\components\AdminController;
use common\models\BackLoginForm;
use common\models\BackofficeUser;
use common\models\BackofficeForgotPassword;
use common\models\BackofficeResetPassword;

class AuthController extends AdminController 
{
    public function actionIndex() {
        return $this->runAction('login');
    }

    public function actionLogin() {
        $model = new BackLoginForm();
        if (!\Yii::$app->user->isGuest || ($model->load(Yii::$app->Request->post()) && $model->login())) {
            $userId = Yii::$app->user->id;
            $userDtl = \common\models\BackofficeUser::findOne($userId);
            $this->redirect('/stockqc/index');
        }
        $this->layout = false;
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        $this->layout = true;
        return $this->redirect(Yii::$app->urlManager->createAbsoluteUrl(''));
    }

    /*
     * @auther Shashikant kumar <shashikant.kumar@gaadi.com>
     * Send New password to user registerd Email Address
     * 
     */

    public function actionForgotpassword() {
        $ForgotPassword = new BackofficeForgotPassword();
        if ($ForgotPassword->load(Yii::$app->request->post()) && $ForgotPassword->validate()) {
            $ForgotPassword->newForgotPassword();
            $this->flash('Passwordchanged', 'Password SucessFully Sent');
            $this->redirect('login');
        } else {
            $this->flash('Emailidenter', 'Please Enter Your Registerd Email');
            $this->layout = false;
            return $this->render('ForgotPassword', ['ForgotPassword' => $ForgotPassword]);
        }
    }

    /*
     * * @auther Shashikant kumar <shashikant.kumar@gaadi.com>
     * Reset user password 
     */

    public function actionResetpassword() {
        $user_id = Yii::$app->user->id;
        $ResetPassword = new BackofficeResetPassword();
        if ($ResetPassword->load(Yii::$app->request->post()) && $ResetPassword->validate()) {
            BackofficeUser::updateAll(['password' => md5($ResetPassword->NewPassword)], ['id' => $user_id]);
            $this->flash('Passwordreset', 'Password SucessFully Changed');
            return $this->refresh();
        } else {
            return $this->render('ResetPassword', ['ResetPassword' => $ResetPassword]);
        }
    }

    /**
     * @auther Shashikant kumar <shashikant.kumar@gaadi.com>
     * Authenticate user access key and login server 
     * check user status if alredy active ,login user 
     */
    public function actionConfirm() {
        $key = Yii::$app->request->get('key');
        $domain = 'http://www.' . $_SERVER['SERVER_NAME'];
        $userModel = new BackofficeUser();
        $user = BackOfficeUser::find()->innerJoin('dealer', 'backoffice_user.id=dealer.user_id')
                        ->where([
                            'auth_key' => $key,
                            'domain' => $domain,
                        ])->one();
        //p($user);
        if (!empty($user)) {
            if ($user['user_status'] == 'active') {
                $login = BackofficeUser::findIdentityByAccessToken($key);
                Yii::$app->user->login($login, 3600 * 24 * 30);
                $this->redirect('login');
            } else {
                $userModel->updateAll(['user_status' => 'active'], ['auth_key' => $key]);
                $this->flash('Verify', Yii::t('app', 'Email verified Sucessfully.'));
                $this->redirect('login');
            }
        } else {
            $session = Yii::$app->session;
            unset($session['old_id']);
            unset($session['timestamp']);
            $session->destroy();
            $this->flash('Verify', Yii::t('app', 'Auth key is not valid'));
            $this->redirect('login');
        }
    }

}
