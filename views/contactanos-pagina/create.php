<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ContactanosPagina */

$this->title = 'Create Contactanos Pagina';
$this->params['breadcrumbs'][] = ['label' => 'Contactanos Paginas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactanos-pagina-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
