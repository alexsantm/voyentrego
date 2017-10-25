<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Envio */

//$this->title = $model->id;
$this->title = $model->direccion_origen;
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//print_r(Yii::$app->request->get('id')) ; die();
//$envio_id = Yii::$app->request->get('id'); 
?>
<div class="envio-view">
    <div class="row">
        <div class="col-lg-8">
            <h1><?php echo('Detalle del envío: '); ?><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-4"><br>
            <p>
                <?php
                if($model->estado_envio_id==1){
                    ?><?= Html::a('Detalles de Envío', ['view', 'id' => $model->id], ['class' => 'btn btn-success btn-lg', 'title'=>'Haga click para añadir Destinos']) ?><br><br><?php
                }
                ?>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'ciudad_id',
            [
                'attribute' => 'ciudad_id',
                'label' => 'Ciudad',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $service = app\models\Ciudad::findOne($model->ciudad_id);
                    return $service ? $service->ciudad : '-';
               }, $model),                        
            ],
//            'user_id',
            'remitente',
            'direccion_origen',
            'latitud',
            'longitud',
            'celular',
            'fecha_registro',
            'fecha_fin_envio',
            'total_km',
            'valor_total',
            'observacion:html',
//            'estado_envio_id',
             [
                'attribute' => 'estado_envio_id',
                'label' => 'Estado',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                     $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                    return $service ? $service->estado : '-';
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
//            'mensajero_id',
            [
                'attribute' => 'mensajero_id',
                'label' => 'Mensajero Asignado',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                     $service = app\models\Profile::find()->where(['user_id'=>$model->mensajero_id])->asArray()->one();
                    return $service ? $service['full_name'] : 'No asignado';
               }, $model),                        
            ],
             [
                'attribute' => '',
                'label' => 'Destinos',
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $envio_id = $model->id;
                    $fechaactual = date("Y-m-d");
                    $destino_count = app\models\Destino::find()->where(['envio_id'=>$envio_id])->asArray()->count();
                    return $destino_count;

//                    $service = app\models\Profile::find()->where(['user_id'=>$model->mensajero_id])->asArray()->one();
//                    return $service ? $service['full_name'] : 'No asignado';
               }, $model),                        
            ],
        ],
    ]) 
    ?>

</div>