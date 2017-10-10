<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DescuentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Descuentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="descuento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Descuento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
               'type' => GridView::TYPE_WARNING,
                'heading' =>'Descuentos',
                'footer'=>false
           ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'codigo_descuento',
            'valor_descuento',
            'fecha_inicio',
            'fecha_fin',
//            'archivo_promocion',
             [
             'attribute' => 'archivo_promocion',
             'format' => 'raw',
             'label'=>'Archivo de Promocion',
             'hAlign'=>'center',
             'vAlign'=>'middle',    
             'value' => function ($model) {   
                if ($model->archivo_promocion!='')
                  //return '<img src="'.Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia.'" width="50px" height="auto">'; else return 'no image';
                  return Html::a(Html::img(Yii::$app->homeUrl. '/images/promociones/'.$model->archivo_promocion), Yii::$app->homeUrl. '/images/promociones/'.$model->archivo_promocion, ['rel' => 'fancybox']);
             },
             'format' => ['raw'],
            ],

//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'kartik\grid\ActionColumn',
                          //'template'=>'{view}{update}{delete}',
                            'template'=>'{update}',
                            'buttons'=>[
//                                    'view' => function ($url, $model) {     
//                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
//                                              'class'=>'btn btn-success btn-md modalButton','title' => Yii::t('yii', 'View'),
//                                      ]); 
//                                    },
                                    'update' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                              'class'=>'btn btn-success btn-md','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
//                                    'delete' => function($url, $model) {
//                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], ['class'=>'btn btn-success btn-md',
//                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);        
//                                    }        
                            ]                                      
            ],          
                     
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<style>
    .kv-align-center img{
        /*border: solid 2px red;*/
        width: 65px;
        height: 65px;
    }
    
</style> 
