<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Envios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Envio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_WARNING
        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ciudad_id',
            'user_id',
            'remitente',
            'direccion_origen',
             'latitud',
             'longitud',
            // 'celular',
             'fecha_registro',
            // 'fecha_fin_envio',
            // 'total_km',
            // 'valor_total',
             'observacion',
//             'estado_envio_id',
//             'tipo_envio_id',
//             'dimensiones_id',
            // 'mensajero_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
