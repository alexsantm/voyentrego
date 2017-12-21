<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ConfiguracionPagos */

$this->title = 'Create Configuracion Pagos';
$this->params['breadcrumbs'][] = ['label' => 'Configuracion Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracion-pagos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
