<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TarjetaCreditoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tarjeta Creditos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarjeta-credito-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tarjeta Credito', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'creditCard_number',
            'creditCard_expirationDate',
            'creditCard_cvv',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
