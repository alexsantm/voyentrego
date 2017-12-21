<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecargaTransferenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administrador de Recargas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recarga-transferencia-index">  

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>NOTA: Se debe cotejar el valor del Documento de Transferencia con la columna VALOR. En caso de estar correcto, en ESTADO se debe escoger CONFIRMADO</p>
    
    
    <?php
    //Fancybox
    echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '800px',
        'maxHeight' => '800px',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => true,
        'width' => '800px',
        'height' => '800px',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => true,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 30, 'height' => 30],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
    ?>
    

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'panel' => [
               'type' => GridView::TYPE_WARNING
           ],
        'rowOptions'=>function($model){
            if($model['estado_id'] == 2){
//                return ['class' => 'alert alert-danger'];
                return ['style'=>' background-color:#F2DEDE;'];
            }
            else {
//                return ['class' => 'alert alert-success'];
                return ['style'=>' background-color:#DFF0D8;'];
            }
        },   
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            'user_id',
            [
                'attribute' => 'user_id',
                'label'=>'Usuario',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value'=>function($model, $key, $index, $column) {
                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
                         },
            ],
//            'fecha',
            [
                'attribute' => 'fecha',
                'hAlign'=>'center',
                'vAlign'=>'middle',
            ],                      
//            'doc_referencia',
             [
             'attribute' => 'doc_referencia',
             'format' => 'raw',
             'label'=>'Documento de Referencia',
             'hAlign'=>'center',
             'vAlign'=>'middle',    
             'value' => function ($model) {   
                if ($model->doc_referencia!='')
                  //return '<img src="'.Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia.'" width="50px" height="auto">'; else return 'no image';
                  return Html::a(Html::img(Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia), Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia, ['rel' => 'fancybox']);
             },
             'format' => ['raw'],
            ],                 
//            'valor',
//            [
//                'attribute' => 'valor',
//                'hAlign'=>'center',
//                'vAlign'=>'middle',
//            ],   
            [
                'class'=>'kartik\grid\EditableColumn',  
                'attribute'=>'valor',
                'header'=>'Valor',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'format'=>'raw',             
                   'editableOptions' => [
                     'format' => Editable::FORMAT_BUTTON,   
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    ],
                'filter'=> false, 
            ],                        
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'estado_id',
                //'width' => '20px !important',
                'label' => 'Estado',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Estado::findOne($model->estado_id);
                    return $service ? $service->estado : '-';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(app\models\Estado::find()->asArray()->all(), 'id', 'estado'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Escoga un Estado'],

                'editableOptions' => [
                    'header' => 'Estado',
                    'placement'=> 'left',  
                    'format' => Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'editableValueOptions' => ['class' => 'text-success h4'],
                    'data' => ArrayHelper::map(\app\models\Estado::find()->where(['id'=>4])->all(), 'id', 'estado'),
                ],        
            ], 
//            'valor_promo',    
             [
                'attribute'=>'valor_promo',
                'header'=>'Valor Promoción',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'filter'=> false, 
            ],             

//            ['class' => 'yii\grid\ActionColumn'],
              ['class' => 'kartik\grid\ActionColumn',
                          //'template'=>'{view}{update}{delete}',
                            'template'=>'{delete}',
                            'buttons'=>[
//                                    'view' => function ($url, $model) {     
//                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
//                                              'class'=>'btn btn-success btn-md modalButton','title' => Yii::t('yii', 'View'),
//                                      ]); 
//                                    },
//                                    'update' => function ($url, $model) {     
//                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
//                                              'class'=>'btn btn-success btn-md','title' => Yii::t('yii', 'Update'),
//                                      ]); 
//                                    },
                                    'delete' => function($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-warning btn-md',
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
                                    }        
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
        'size' => 'modal-lg',
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

<style>
    .kv-align-center img{
        /*border: solid 2px red;*/
        width: 65px;
        height: 65px;
    }
    
    th.kv-align-center{
        color: #337ab7;
    }
    
</style>    