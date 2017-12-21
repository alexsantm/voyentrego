<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Valores */

$this->title = 'Nuevo Valor';
$this->params['breadcrumbs'][] = ['label' => 'Valores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
