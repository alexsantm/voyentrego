<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Destino */

//$this->title = $model->id;
$this->title = $model->direccion_destino;
$this->params['breadcrumbs'][] = ['label' => 'Destinos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destino-view">

    <h1><?php echo('Detalle del detino: '); ?><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
             [
                'attribute' => 'ciudad_id',
                'label' => 'Ciudad',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $service = app\models\Ciudad::findOne($model->ciudad_id);
                            return $service ? $service->ciudad : '-';
               }, $model),                        
             ],
            'envio_id',
            'destinatario',
            'direccion_destino',
            'latitud',
            'longitud',
            'celular',
            'fecha_registro',
            'fecha_asignacion',
            'fecha_finalizacion',
            'kilometros',
            'valor',
            'observacion',
//            'estado_envio_id',
            [
                'attribute' => 'estado_envio_id',
                'label' => 'Estado del Envìo',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                            return $service ? $service->estado : '-';
               }, $model),                        
             ],
           
//            'retorno_destino_id',
            [
                'attribute' => 'retorno_destino_id',
                'label' => 'Retorna a:',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $service = app\models\Destino::findOne($model->retorno_destino_id);
                            return $service ? $service->direccion_destino : '-';
               }, $model),                        
            ],
//            'retorno_inicio',
            [
                'attribute' => 'retorno_inicio',
                'label' => '¿Retorno al Inicio?',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                             if($model->retorno_inicio){
                                return "Si";
                            } 
                            else{
                                return "No";
                            }
               }, $model),                        
            ],           
//            'tipo_envio_id',
            [
                'attribute' => 'tipo_envio_id',
                'label' => 'Tipo de Envío',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                            $service = app\models\TipoEnvio::findOne($model->tipo_envio_id);
                            return $service ? $service->tipo_envio : '-';
               }, $model),                        
            ],           
//            'dimensiones_id',
            [
                'attribute' => 'dimensiones_id',
                'label' => 'Dimensiones',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                             $service = app\models\Dimensiones::findOne($model->dimensiones_id);
                            return $service ? $service->dimension : '-';
               }, $model),                        
            ],           
        ],
    ]) ?>

</div>
