<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Descuento */

$this->title = 'Update Descuento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Descuentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="descuento-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php
//    print_r($model);
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
