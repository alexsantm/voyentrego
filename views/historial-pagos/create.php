<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\HistorialPagos */

$this->title = 'Create Historial Pagos';
$this->params['breadcrumbs'][] = ['label' => 'Historial Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-pagos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
