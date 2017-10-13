<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contactanos */

$this->title ='¿Comentarios, Sugerencias o Quejas?';
$this->params['breadcrumbs'][] = ['label' => 'Contactanos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactanos-create">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


<style>
    title{
        text-align: center;
    }
</style>
