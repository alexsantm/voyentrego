<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'VoyVengo - Mensajero';
$user_id = Yii::$app->user->identity['id'];


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
          
          
          
        <div class="col-lg-3  col-md-3 col-sm-12 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
                <div class="icon">
                    <i class="glyphicon glyphicon-thumbs-up"></i>
                </div>
              <h3><?= $favoritismo?></h3>

              <p>Favoritismo</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <div class="col-lg-3  col-md-3 col-sm-12 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <div class="icon">
                    <i class="glyphicon glyphicon-ok"></i>
                </div>
              <!--<h3><sup style="font-size: 20px">%</sup></h3>-->
              <h3><?= $no_envios_exitosos?></h3>
              <p>Envios Finalizados</p>
            </div>
            <!--<a href="#" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>-->
            <?= Html::a('Mas Información<i class="fa fa-arrow-circle-right" style="color:white"></i>',
                        ['//envio/indexmensajero'],
                        ['class'=>'small-box-footer']
                );
            ?>
          </div>
        </div>
        <!-- ./col -->
        
        
        
<!--Envios Asignados-->        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
               <div class="icon">
                <i class="glyphicon glyphicon-list-alt"></i>
                </div>  
              <!--<h3>44</h3>-->
              <h3><?= $no_envios_asignados?></h3>

              <p>Envios Pendientes</p>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            <?= Html::a('Mas Información<i class="fa fa-arrow-circle-right" style="color:white"></i>',
                                                        ['//envio/indexmensajero'],
                                                        ['class'=>'small-box-footer']
                                                );
            ?>  
          </div>
        </div>
        <!-- ./col -->
        
        
<!--Calificacion-->
        <div class="col-lg-3  col-md-3 col-sm-12 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
<!--              <h3>65</h3>-->
            <div class="icon">
              <i class="glyphicon glyphicon-star"></i>
            </div>
                <h3><?= round($calificacion_mes, 2);?></h3>
                <p>Reputación Mensual</p>
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
                        <div id="contenedor" class="col-lg-4 col-md-12 col-sm-12 col-xs-12">                
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
                        <div id="contenedor" class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <!--<a href="<?php // Url::to(['user/perfil#transferencia']) ?>">-->
                            <a href="<?= Url::to(['datos-bancarios-mensajero/view', 'id'=>$user_id ]) ?>">
                                <section class=" asesoria">
                                   <div class="col-lg-4  iconos"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                   <div class="col-lg-8">
                                           <h2 class="texto_tomate">MIS PAGOS</h2>
                                           <span class="texto_tomate">Métodos de Pago</span><br>                                        
                                   </div>
                               </section>
                            </a>    
                        </div>
                         <div id="contenedor" class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                             <!--<a href="<?php // Url::to(['user/perfil#perfil']) ?>">-->
                             <a href="<?= Url::to(['user/profile']) ?>">
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
          <div style="background-color: #FF5515; color:white; padding:10px 10px;"><center><h3>No existen envíos para el dia de hoy</h3></center></div>
    <?php
    }    
    ?>      
          
          
          
      </div>
      </section>
    
    
</section>
    <!-- /.content -->
  <!--</div>-->
  
  
  
  <style>
      .icon{
          color:white !important;
          top: 5px !important;
          /*right: 81px !important;*/
      }
      
      
          @media (max-width: 1198px) {
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
    
     @media (max-width: 990px) {
        .historial, .asesoria, .cuenta {
            width: 100%;
        }
        #contenedor {
              /*IMPORTANTE*/
                  display: block;
              }
    }

    @media (max-width: 768px) {
        .historial, .asesoria, .cuenta {
            width: 100%;
        }
    }
      
</style>      