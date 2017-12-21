<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReporteProblemaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte Problemas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reporte-problema-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reporte Problema', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'envio_id',
            'user_id',
            'problema_id',
            'fecha',
            // 'imagen',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
