<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RutaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rutas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ruta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ruta',
            'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
