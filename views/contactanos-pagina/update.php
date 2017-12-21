<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContactanosPagina */

//$this->title = 'Actualizar Sección de Contactanos: ' . $model->id;
$this->title = 'Actualizar Sección de Contactanos';
$this->params['breadcrumbs'][] = ['label' => 'Contactanos Paginas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contactanos-pagina-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Puede ingresar texto, o hacer click en "FUENTE HTML" y pegar código HTML en el sitio</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
