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
        <div class="col-lg-10">
            <h1><?php echo('Detalle del envío: '); ?><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-lg-2"><br>
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
        </div>
    </div>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ciudad_id',
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
            'observacion',
            'estado_envio_id',
            'tipo_envio_id',
            'dimensiones_id',
            'mensajero_id',
        ],
    ]) 
    ?>

</div>