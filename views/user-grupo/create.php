<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserGrupo */

$this->title = 'Asiganción de Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'User Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-grupo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
