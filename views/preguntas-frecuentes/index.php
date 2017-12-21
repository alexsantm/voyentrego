<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PreguntasFrecuentesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preguntas Frecuentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preguntas-frecuentes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Pregunta', ['create'], ['class' => 'btn btn-warning modalButton']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
               'type' => GridView::TYPE_WARNING
           ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'pregunta_frecuente',
//            'fecha',

//            ['class' => 'yii\grid\ActionColumn'],
            
                         ['class' => 'kartik\grid\ActionColumn',  
                            'header'=>'Acciones en Preguntas',
                            'template'=>'{update}{delete}',
                            'buttons'=>[
                                    'update' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                              'class'=>'btn btn-warning btn-md','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
                                    'delete' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-warning btn-md',
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                                    }        
                            ]  
                                    
            ],
            
            
            
            ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Agregar Respuesta',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                $query = app\models\Respuestas::find()
                                        ->where(['preguntas_frecuentes_id'=>$model['id']])
                                        ->asArray()->one();
                                if(empty($query)){  
                                        return Html::a( '<i class="glyphicon glyphicon-plus" style="color:white"></i>',
                                                        ['/respuestas/create', 
                                                         'preguntas_frecuentes_id'=>$model['id'],
                                                        ],
                                                        ['class'=>'btn btn-success btn-lg modalButton', 'title'=>'Agregue una Respuesta', ]
                                        );
                                }
                                else{
                                    return "Respuesta Agregada";
                                }
                        },
                    ]
            ],
            ['class' => 'kartik\grid\ActionColumn',
                    'template'=>'{custom_view}',
                    'header'=>'Actualizar Respuesta',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'buttons' => 
                    [                           
                        'custom_view' => function ($url, $model) {
                                        $id_r = app\models\Respuestas::find()
                                                ->where(['preguntas_frecuentes_id'=>$model['id']])
                                                ->asArray()->one();
                                        $id_respuesta = $id_r['id'];
                                        $preguntas_frecuentes_id = $id_r['preguntas_frecuentes_id'];
                                        
                                        if(!empty($id_r)){
                                            return Html::a( '<i class="glyphicon glyphicon-pencil" style="color:white"></i>',
                                                            ['/respuestas/update', 
                                                                'id'=>$id_respuesta,
                                                                'preguntas_frecuentes_id'=>$preguntas_frecuentes_id,
                                                            ],
                                                            ['class'=>'btn btn-success btn-lg modalButton', 'title'=>'Agregue una Respuesta', ]
                                            );
                                        }
                                        else{
                                             return "Agregue una respuesta";
                                        }
                        },
                    ]
            ],                    
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-xs',
		'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Cerrar</a>',
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