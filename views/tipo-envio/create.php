<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoEnvio */

$this->title = 'Create Tipo Envio';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-envio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
