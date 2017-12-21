<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Respuestas */

$this->title = 'Actualizar Respuesta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$preguntas_frecuentes_id = Yii::$app->request->get('preguntas_frecuentes_id');
//print_r($preguntas_frecuentes_id); die();
?>
<div class="respuestas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preguntas_frecuentes_id' => $preguntas_frecuentes_id,
    ]) ?>

</div>
