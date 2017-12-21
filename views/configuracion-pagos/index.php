<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConfiguracionPagosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuracion Pagos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracion-pagos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Configuracion Pagos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
               'type' => GridView::TYPE_WARNING,
                'heading'=> 'Configuración de Pagos a Mensajeros',
                'footer'=>false,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'numero_pagos_mes',
            'porcentaje',

                                    ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{update}{delete}',
                          //  'template'=>'{delete}',
                            'buttons'=>[
//                                    'view' => function ($url, $model) {     
//                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
//                                              'class'=>'btn btn-warning btn-md modalButton','title' => Yii::t('yii', 'View'),
//                                      ]); 
//                                    },
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
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
