<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Destino */

$this->title = 'Nuevo Destino';
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$id_envio = Yii::$app->request->get('id');
?>
<div class="destino-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id_envio' => $id_envio,
    ]) ?>

</div>
