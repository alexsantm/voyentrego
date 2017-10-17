<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DatosBancariosMensajero */

$this->title = 'Datos Bancarios del Mensajero';
$this->params['breadcrumbs'][] = ['label' => 'Datos Bancarios Mensajeros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="datos-bancarios-mensajero-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
