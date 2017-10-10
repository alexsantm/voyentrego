<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Descuento */

$this->title = 'Create Descuento';
$this->params['breadcrumbs'][] = ['label' => 'Descuentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="descuento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
