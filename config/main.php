<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-' . APPLICATION_ENV . '.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-' . APPLICATION_ENV . '.php')
);
$country = Yii::getAlias('@country');
$globeParamsMain = [];
$globeParamsEnv = [];
if (!empty($country)) {
    if (file_exists(Yii::getAlias('@common') . "/globe/carbay$country/config/params.php")) {
        $globeParamsMain = require(Yii::getAlias('@common') . "/globe/carbay$country/config/params.php");
    }
    if (file_exists(Yii::getAlias('@common') . "/globe/carbay$country/config/params-" . APPLICATION_ENV . ".php")) {
        $globeParamsEnv = require(Yii::getAlias('@common') . "/globe/carbay$country/config/params-" . APPLICATION_ENV . ".php");
    }
    $globeParams = array_merge($globeParamsMain, $globeParamsEnv);
    $params = array_replace_recursive($params, $globeParams);
}

$config = [
    'id' => 'app-backoffice',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => Yii::getAlias('@country') . '/auth/login',
    'homeUrl' => '/', //added
    'controllerNamespace' => 'backoffice\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        Yii::getAlias('@country') => 'backoffice\globe\carbay' . Yii::getAlias('@country') . '\\' . ucfirst(Yii::getAlias('@country')),
    ],
    'components' => [
        'request' => [//added
            'baseUrl' => '',
            'cookieValidationKey' => 'sXSB9Vl6hRwhl3S242bu6gaq0TrcmXBN',
        ],
        'user' => [
            'identityClass' => 'common\models\BackofficeUser',
            'enableAutoLogin' => false,
            'authTimeout' => '1800',
            'loginUrl' => '/auth/login',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>' => Yii::getAlias('@country') . '/<controller>',
                '<controller:\w+>/<id:\d+>' => Yii::getAlias('@country') . '/<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => Yii::getAlias('@country') . '/<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => Yii::getAlias('@country') . '/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

$globeConfigMain = [];
$globeConfigEnv = [];
if (!empty($country)) {
    if (file_exists(Yii::getAlias('@common') . "/globe/carbay$country/config/main.php")) {
        $globeConfigMain = require(Yii::getAlias('@common') . "/globe/carbay$country/config/main.php");
    }

    if (file_exists(Yii::getAlias('@common') . "/globe/carbay$country/config/main-" . APPLICATION_ENV . ".php")) {
        $globeConfigEnv = require(Yii::getAlias('@common') . "/globe/carbay$country/config/main-" . APPLICATION_ENV . ".php");
    }
    $globeConfig = array_merge($globeConfigMain, $globeConfigEnv);
    $config = array_replace_recursive($config, $globeConfig);
}
return $config;
