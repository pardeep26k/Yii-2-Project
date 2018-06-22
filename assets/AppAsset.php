<?php

namespace backoffice\assets;

use yii\web\AssetBundle;
/**
 * @author Sujit Verma <sujit.verma@girnarsoft.com>
 */
class AppAsset extends AssetBundle
{
    public $depends = [
        'yiister\gentelella\assets\Asset',
    ];
}
