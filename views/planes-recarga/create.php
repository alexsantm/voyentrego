<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlanesRecarga */

$this->title = 'Nuevo Plan de Recarga';
$this->params['breadcrumbs'][] = ['label' => 'Planes Recargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planes-recarga-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
