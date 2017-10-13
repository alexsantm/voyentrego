<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Respuestas */

$this->title = 'Nueva Respuesta';
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$preguntas_frecuentes_id = Yii::$app->request->get('preguntas_frecuentes_id');
?>
<div class="respuestas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preguntas_frecuentes_id' => $preguntas_frecuentes_id,
    ]) ?>

</div>


