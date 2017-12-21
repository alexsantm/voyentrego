<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Problema */

$this->title = 'Create Problema';
$this->params['breadcrumbs'][] = ['label' => 'Problemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problema-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
