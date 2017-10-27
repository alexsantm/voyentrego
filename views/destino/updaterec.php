<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Destino */

$this->title = 'Actualizar Destino: ' . $model->direccion_destino;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$id_envio = Yii::$app->request->get('id_envio');
//print_r(Yii::$app->request->get()); die();
?>
<div class="destino-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formrec', [
        'model' => $model,
        'id_envio' => $id_envio,
    ]) ?>

</div>
