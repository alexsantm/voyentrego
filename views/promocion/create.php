<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Promocion */

$this->title = 'Nueva Promocion';
$this->params['breadcrumbs'][] = ['label' => 'Promocions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
