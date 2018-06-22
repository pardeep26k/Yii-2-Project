<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Usedcar */

$this->title = Yii::t('app', 'Create Usedcar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usedcars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usedcar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>