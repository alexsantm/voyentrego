<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'VoyVengo';
$user = Yii::$app->user->identity;
?>
<!--<div class="container" style="border: solid 1px red;">-->
    <!-- Content Header (Page header) -->
    <nav class="seccion_tomate">
        <div><h3>Menú Principal</h3></div>
    </nav>
    <!--<h1>Estadísticas<small>Control panel</small></h1>-->

    <!-- Main content -->
<section class="content">
        <section class="contenedor_principal">
        
        <div class="row">

                    <div class="col-lg-8">                
                        <div id="contenedor" class="col-lg-6">                
                             <a href="<?= Url::to(['envio/index']) ?>">
                                <section class="historial">
                                    <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></div>
                                    <div class="col-lg-8">
                                        <h2 class="texto_tomate">HISTORIAL</h2>
                                        <span class="texto_tomate">Todos los envíos</span><br>
                                        <span class="texto_tomate">Mis envíos actuales</span><br>
                                        <span class="texto_tomate">Estadísticas</span>
                                    </div>
                                </section>
                            </a>    
                        </div>
                        <div id="contenedor" class="col-lg-6">
                             <section class=" asesoria">
                                <div class="col-lg-4  iconos"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                        <h2 class="texto_tomate">ASESORIA</h2>
                                        <span class="texto_tomate">Preguntas Frecuentes</span><br>
                                        <span class="texto_tomate">Calificación de mensajeros</span><br>
                                        <span class="texto_tomate">Reportar una queja</span><br>
                                </div>
                            </section>
                        </div>
                        <div id="contenedor" class=" col-lg-6">
                            <a href="<?= Url::to(['user/perfil#recarga']) ?>">
                                <section class="saldo">
                                    <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                    <div class="col-lg-8">
                                        <h2 class="texto_tomate">SALDO</h2>
                                        <span class="texto_tomate">Carga de saldo</span><br>
                                        <span class="texto_tomate">Métodos de pago</span><br>                                    
                                    </div>
                                </section>
                            </a>     
                        </div>
                        <div id="contenedor" class="col-lg-6">
                             <section class="cuenta">
                                <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                    <h2 class="texto_tomate">MI CUENTA</h2>
                                    <span class="texto_tomate">Mi perfil</span><br>
                                    <span class="texto_tomate">Cambio Contraseña</span><br>
                                    <span class="texto_tomate">Empresas</span>
                                </div>
                            </section>
                        </div>                
                    </div>
            
                    <div class=" row col-lg-4">
                        <!--<center>-->
                            <!--<div class="promociones">-->
                                 <?php 
//                                $fecha_actual = date("Y-m-d"); 
//                                $model = new \app\models\Descuento;
////                                 if ($model->check_in_range($fecha_inicio, $fecha_fin, $fecha_actual)) {
////                                     print_r("si esta dentro del rango");
////                                 }
////                                 else{
////                                     print_r("no esta dentro del rango");
////                                 }
//                                 if((!empty($foto_promocion)) && ($model->check_in_range($fecha_inicio, $fecha_fin, $fecha_actual))){
//                                        echo Html::img('@web/images/promociones/'.$foto_promocion, ['style'=>'width:100%; height:357px;']);
//                                    }
//                                    else{
//                                        echo Html::img('@web/images/promociones/no_promocion.png', ['style'=>'width:100%; height:357px;']);
//                                    }
                                    
                                    echo Html::img('@web/images/promociones/no_promocion.png', ['style'=>'width:100%; height:357px;']);
                                ?>
                            <!--</div>-->
                        <!--</center>-->    
                    </div>            
        </div>
        
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <span class="iconos glyphicon glyphicon-road" aria-hidden="true"> <h2 class="texto_tomate" style="display:inline-block">&ensp; ENVIOS EN CAMINO</h2></span>
          
    <?php // Verifico si existe Dataprovider para que aparezca el Grid
    if ($dataProvider->totalCount > 0) {
        
    ?>
          
          <div class="envio-index">
                <?php Pjax::begin(); ?>    
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel,
                    'panel' => [
                        'type' => GridView::TYPE_WARNING,
                        'heading'=>'ENVIOS PARA HOY', 
                        'footer'=>false
                    ],
                    'columns' => [
            //            ['class' => 'yii\grid\SerialColumn'],

//                        'id',
//                        'ciudad_id',
                        [
                            'label' => "Ciudad",
                            'attribute' => 'ciudad_id',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            //'width'=>'450px',
                            'value' => function($model, $key, $index, $column) {
                                $service = app\models\Ciudad::findOne($model->ciudad_id);
                                return $service ? $service->ciudad : '-';
                            },
                        ],
//                        'user_id',
                        'remitente',
                        'direccion_origen',
    //                     'latitud',
    //                     'longitud',
                        // 'celular',
                         'fecha_registro',
                        // 'fecha_fin_envio',
                        // 'total_km',
                        // 'valor_total',
    //                     'observacion',
//                         'estado_envio_id',
                        [
                            'label' => "Paradas",
                            'attribute' => '',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            //'width'=>'450px',
                            'value' => function($model, $key, $index, $column) {
                                $envio_id = $model->id;
                                $fechaactual = date("Y-m-d");
                                $destino_count = app\models\Destino::find()->where(['envio_id'=>$envio_id])->andWhere(['fecha_registro'=>$fechaactual])->asArray()->count();
                                return $destino_count;
                                //return $service ? $service->estado : '-';
                            },
                        ],                        
                        [
                            'label' => "Estado",
                            'attribute' => 'estado_envio_id',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                            //'width'=>'450px',
                            'value' => function($model, $key, $index, $column) {
                                $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                                return $service ? $service->estado : '-';
                            },
                        ],
                        
                //             'tipo_envio_id',
            //             'dimensiones_id',
                        // 'mensajero_id',

//                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); 
                ?>
                <?php Pjax::end(); ?>
          </div>
    <?php
    }
    else{
    ?>
          <div class="alert alert-info"><center><h4>No existen envíos para el dia de hoy</h4></center></div>
    <?php
    }    
    ?>      
          
          
          
      </div>
      </section>
</section>
    <!-- /.content -->
  <!--</div>-->
  
  
  
  <style>
      .kv-panel-before, .kv-panel-after{
        display:none;
      }
      thead{
        color: #3c8dbc;
      }

@media (max-width: 1199px) {
  .iconos {
    display: none;
  }
  .items {
    text-align: right;
  }
    
  /*Centrar horizontalmente las cajas*/  
    #contenedor {
    /*IMPORTANTE*/
        display: flex;
        justify-content: center;
        align-items: center;
    }
    h2{
        text-align: center;
    }
}

@media (max-width: 765px) {
    .historial, .asesoria, .saldo, .cuenta {
        width: 100%;
    }
}
</style>