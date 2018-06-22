<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
//if(APPLICATION_ENV != 'production')
//{
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', APPLICATION_ENV);
//}

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap-'.APPLICATION_ENV.'.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');


$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-'.APPLICATION_ENV.'.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-'.APPLICATION_ENV.'.php')
);
$application = new yii\web\Application($config);
$application->run();
