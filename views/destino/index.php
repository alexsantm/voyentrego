<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Destinos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Destino', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ciudad_id',
            'envio_id',
            'destinatario',
            'direccion_destino',
            // 'latitud',
            // 'longitud',
            // 'celular',
            // 'fecha_registro',
            // 'fecha_asignacion',
            // 'fecha_finalizacion',
            // 'kilometros',
            // 'valor',
            // 'observacion',
            // 'estado_envio_id',
            // 'retorno_destino_id',
            // 'retorno_inicio',
            // 'tipo_envio_id',
            // 'dimensiones_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
