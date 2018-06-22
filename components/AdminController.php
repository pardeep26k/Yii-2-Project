<?php

namespace backoffice\components;

use common\components\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller {

    public $layout = '//backoffice_layout';
    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'forgotpassword','stocksearch'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}
