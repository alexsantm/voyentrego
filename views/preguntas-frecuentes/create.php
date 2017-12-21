<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PreguntasFrecuentes */

$this->title = 'Nueva Pregunta';
$this->params['breadcrumbs'][] = ['label' => 'Preguntas Frecuentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preguntas-frecuentes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
