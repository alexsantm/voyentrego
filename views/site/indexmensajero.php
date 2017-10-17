<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'VoyVengo - Mensajero';
?>
<!--<div class="container" style="border: solid 1px red;">-->
    <!-- Content Header (Page header) -->
    <nav class="seccion_tomate">
      Menú
    </nav>    
    
    <section class="content-header">
      <h1>Estadísticas
        <!--<small>Control panel</small>-->
      </h1>
    </section>

    <!-- Main content -->
<section class="content">
    <section class="contenedor_principal">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </section>  
    
    
    
    
            <section class="contenedor_principal">
        
        <div class="row">
                    <div class="col-lg-12">                
                        <div id="contenedor" class="col-lg-4">                
                             <a href="<?= Url::to(['envio/indexmensajero']) ?>">
                                <section class="historial">
                                    <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></div>
                                    <div class="col-lg-8">
                                        <h2 class="texto_tomate">HISTORIAL</h2>
                                        <span class="texto_tomate">Todos los envíos</span><br>
                                        <span class="texto_tomate">Mis envíos actuales</span><br>
                                        <!--<span class="texto_tomate">Estadísticas</span>-->
                                    </div>
                                </section>
                            </a>    
                        </div>
                        <div id="contenedor" class="col-lg-4">
                            <a href="<?= Url::to(['user/perfil#transferencia']) ?>">
                                <section class=" asesoria">
                                   <div class="col-lg-4  iconos"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                   <div class="col-lg-8">
                                           <h2 class="texto_tomate">MIS PAGOS</h2>
                                           <span class="texto_tomate">Métodos de Pago</span><br>                                        
                                   </div>
                               </section>
                            </a>    
                        </div>
                         <div id="contenedor" class="col-lg-4">
                             <a href="<?= Url::to(['user/perfil#perfil']) ?>">
                                <section class="cuenta">
                                   <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                   <div class="col-lg-8">
                                       <h2 class="texto_tomate">MI CUENTA</h2>
                                       <span class="texto_tomate">Mi perfil</span><br>
                                       <span class="texto_tomate">Cambio Contraseña</span><br>
                                       <!--<span class="texto_tomate">Empresas</span>-->
                                   </div>
                               </section>
                            </a>      
                        </div>  
<!--                        <div id="contenedor" class="col-lg-3">
                             <section class="cuenta">
                                <div class="col-lg-4 iconos"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                <div class="col-lg-8">
                                    <h2 class="texto_tomate">MI CUENTA</h2>
                                    <span class="texto_tomate">Mi perfil</span><br>
                                    <span class="texto_tomate">Cambio Contraseña</span><br>
                                    <span class="texto_tomate">Empresas</span>
                                </div>
                            </section>
                        </div>                -->
                    </div>          
        </div>
        
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <span class="iconos glyphicon glyphicon-road" aria-hidden="true"> <h2 class="texto_tomate" style="display:inline-block">&ensp; ENVIOS PENDIENTES</h2></span>
          
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