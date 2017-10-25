<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Calificacion */

$this->title = 'Calificar Mensajero';
$this->params['breadcrumbs'][] = ['label' => 'Calificacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$user_id = Yii::$app->request->get('user_id');
$mensajero_id = Yii::$app->request->get('mensajero_id');
$envio_id = Yii::$app->request->get('envio_id');

?>
<div class="calificacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $user_id,
        'mensajero_id' => $mensajero_id,
        'envio_id' => $envio_id,        
    ]) ?>

</div>
