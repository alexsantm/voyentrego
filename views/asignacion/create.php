<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Asignacion */

$this->title = 'Nueva Asignación';
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
