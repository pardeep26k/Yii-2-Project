<?php

namespace backend\models;

use Yii;
abstract class Model extends \yii\db\ActiveRecord
{
 abstract function getModels();

 abstract function getFormData();
}
