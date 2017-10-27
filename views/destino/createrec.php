<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Destino */

$this->title = 'Nuevo Destino Recurrente';
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$id_envio = Yii::$app->request->get('id');

$fechas = Yii::$app->request->get('fechas');
$array_id = Yii::$app->request->get('array_id');
//print_r($fechas); 
//print_r($array_id); 
//die();
?>
<div class="destino-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formrec', [
        'model' => $model,
        'id_envio' => $id_envio,
        'fechas' => $fechas,
        'array_id' => $array_id,
    ]) ?>

</div>
