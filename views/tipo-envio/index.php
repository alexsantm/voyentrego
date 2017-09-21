<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoEnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo Envios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-envio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tipo Envio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo_envio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
