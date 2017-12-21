<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReporteProblema */

$this->title = 'Create Reporte Problema';
$this->params['breadcrumbs'][] = ['label' => 'Reporte Problemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reporte-problema-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
