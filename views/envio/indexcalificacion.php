<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\rating\StarRating;
use kartik\grid\EditableColumnAction;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumen de Calificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
  <h1><?= Html::encode($this->title) ?></h1>
<div class="envio-index">
<?php Pjax::begin(); ?>     
<?php
                echo GridView::widget([
                    'dataProvider'=>$dataProvider,
                    'filterModel'=>$searchModel,
                    'showPageSummary'=>true,
                    'pjax'=>true,
                    'striped'=>false,
                    'hover'=>true,
                    'panel'=>['type'=>'warning', 'heading'=>'Calificaciones'],                    
                    'columns'=>[
                        ['class'=>'kartik\grid\SerialColumn'],
                        [
                            'attribute'=>'', 
                            'width'=>'210px',
                            'vAlign'=>'middle',
                            'filter'=> false,
                            'value' => function($model, $key, $index, $column) {
//                                   return year($model->fecha_registro);
                                   return date("Y", strtotime($model->fecha_registro)); 
                            },
                            'group'=>true,  // enable grouping,
                            'groupedRow'=>true,                    // move grouped column to a single grouped row
                            'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                            'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
                            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                                return [
//                                    'mergeColumns'=>[[0,2]], // columns to merge in summary
                                    'content'=>[             // content to show in each summary cell
                                    ],
                                    'contentFormats'=>[      // content reformatting for each summary cell
                                    ],
                                    'contentOptions'=>[      // content html attributes for each summary cell
                                    ],
                                ];
                            }
                        ],
                        [
                            'attribute'=>'mes', 
                            'width'=>'250px',
                            'vAlign'=>'middle',
                            'hAlign'=>'center',
                            'value' => function($model, $key, $index, $column) {
//                                   return month($model->fecha_registro);
//                                  return date("m", strtotime($model->fecha_registro));  
                                  switch (date("m", strtotime($model->fecha_registro))) {                                    
                                    case 1: return "ENERO";break;
                                    case 2: return "FEBRERO"; break;
                                    case 3: return "MARZO";break;
                                    case 4: return "ABRIL";break;
                                    case 5: return "MAYO";break;
                                    case 6: return "JUNIO";break;
                                    case 7: return "JULIO";break;
                                    case 8: return "AGOSTO";break;
                                    case 9: return "SEPTIEMBRE";break;
                                    case 10: return "OCTUBRE";break;
                                    case 11: return "NOVIEMBRE";break;
                                    case 12: return "DICIEMBRE";break;                                    
                                    }
                            },
                            'group'=>true,  // enable grouping
                            'subGroupOf'=>1, // supplier column index is the parent group,
                            'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
                                return [
                                    'mergeColumns'=>[[8]], // columns to merge in summary
                                    'content'=>[              // content to show in each summary cell
                                        8=>GridView::F_AVG,
                                        7=>'Promedio Mes: ',
                                    ],
                                    'contentFormats'=>[      // content reformatting for each summary cell
                                        8=>['format'=>'number', 'decimals'=>2],
                                    ],
                                    'contentOptions'=>[      // content html attributes for each summary cell
                                        4=>['style'=>'text-align:center'],                        
                                    ],
                                    // html attributes for group summary row
                                    'options'=>['class'=>'success','style'=>'font-weight:bold;']
                                ];
                            },
                        ],
                                    
            [
                'attribute' => 'direccion_origen',
                'hAlign' => 'center',
                'vAlign' => 'middle',
            ],
//             'latitud',
//             'longitud',
            // 'celular',
//             'fecha_registro',
            [
                'attribute' => 'fecha_registro',
                'filterType' => GridView::FILTER_DATE,
                //'width'=>'515px',
                'hAlign'=>'center',
                'vAlign'=>'middle',
//                'width'=>'50%',                
//                'format'=>'date',
                'value'=>function($model, $key, $index, $column) {
                             return $model->fecha_registro;
                         },
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],            
                'filterWidgetOptions' => [
                    'options' => ['placeholder' => 'Escoga una Fecha'], //this code not giving any changes in browser
                    'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND, //this give error Class 'DatePicker' not found
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],            
//             'fecha_fin_envio',
             'total_km',
             'valor_total',
//             'observacion:html',
//            [
//                'attribute' => 'observacion',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//                'format'=>'html',
//                'filter'=>false
//            ],                      
            [
                'label' => "Estado",
                'attribute' => 'estado_envio_id',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\EstadoEnvio::findOne($model->estado_envio_id);
                    return $service ? $service->estado : '-';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(app\models\EstadoEnvio::find()->asArray()->all(), 'id', 'estado'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Seleccione Estado'],        
            ],
//             'tipo_envio_id',
//             'dimensiones_id',
//             'mensajero_id',
//             [
//                'label' => "Mensajero",
//                'attribute' => 'mensajero_id',
//                'hAlign' => 'center',
//                'vAlign' => 'middle',
//                'value'=>function($model, $key, $index, $column) {
//                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->mensajero_id])->asArray()->one();
//                            $full_name = $service['full_name'];
//                            return $full_name ? $full_name : '-';
//                         },                                
//                'filter'=>false        
//            ],                  
            [
                'label' => "Calificación",
                'attribute' => '',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->andWhere(['envio_id'=>$model->id])->asArray()->one();
                    //return $service ? $service['calificacion'] : '-';                    
                    return $service ? $service['calificacion'] : '-'; 
//                        return '';
                },        
//                      'contentOptions' => function ($model, $key, $index, $column) {
//                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->andWhere(['envio_id'=>$model->id])->asArray()->one();
//                    return $service ? $service['calificacion'] : '-';  
//                    $calificacion = $service['calificacion'];
//                   if(($calificacion == 1) || ($calificacion == 2)){
//                        return ['class' => 'alert alert-danger', 'style'=>'border-radius: 10px;'];                           
//                   }
//                   else if(($calificacion == 4) || ($calificacion == 5)){
//                        return ['class' => 'alert alert-success', 'style'=>'border-radius: 10px;'];                           
//                   }
//                   else if(($calificacion == 3)){ 
//                        return ['id' => 'circle',
//                            
//                        ]; 
//                   }
//            },
                'filter'=>false        
            ],
                    ],                                            
                ]);
?>
<?php Pjax::end(); ?>

</div>

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
		'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
    ]);
        echo "<div class='modalContent'></div>";
    yii\bootstrap\Modal::end();

        $this->registerJs(
        "$(document).on('ready pjax:success', function() {
                $('.modalButton').click(function(e){
                   e.preventDefault(); //for prevent default behavior of <a> tag.
                   var tagname = $(this)[0].tagName;
                   $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
               });
            });
        ");
?>

<span id="rating-static rating-30"></span>        
<style>
    thead{
        color: #3c8dbc;
      }
      
    /*Estrellas*/
    .rating-static {
        width: 60px;
        height: 16px;
        display: block;
        background: url('http://www.itsalif.info/blogfiles/rating/star-rating.png') 0 0 no-repeat;
        
        margin-top: 50%;
        margin-left: 25%;
        margin-right: 25%;        
    }
    
/*    td{
        text-align: center;
        position: relative;
        top: 50%;
        -ms-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }*/
    .rating-5 { background-position: 0 0; }
    .rating-4 { background-position: -12px 0; } 
    .rating-3 { background-position: -24px 0; }
    .rating-2 { background-position: -36px 0; }
    .rating-1 { background-position: -48px 0; }
    .rating-0 { background-position: -60px 0; }
    
    
    
    
    .div {
  position: relative;
  width: 0;
  height: 0;
  border-left: 75px solid transparent;
  border-right: 75px solid transparent;
  border-bottom: 150px solid green;
}

.div:after {
  position: absolute;
  width: 0;
  height: 0;
  top: 50px;
  left: -75px;
  content: "";
  border-left: 75px solid transparent;
  border-right: 75px solid transparent;
  border-top: 150px solid green;
}

#circle {
    width: 50px;
    height: 50px;
    background: #7fee1d;
    -moz-border-radius: 60px;
    -webkit-border-radius: 60px;
    border-radius: 60px;
}


</style>    