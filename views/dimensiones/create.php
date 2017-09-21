<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dimensiones */

$this->title = 'Create Dimensiones';
$this->params['breadcrumbs'][] = ['label' => 'Dimensiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dimensiones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
