<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TarjetaCredito */

$this->title = 'Create Tarjeta Credito';
$this->params['breadcrumbs'][] = ['label' => 'Tarjeta Creditos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarjeta-credito-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
