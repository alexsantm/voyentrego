<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoEnvioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo de Envio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-envio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Tipo de Envio', ['create'], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tipo_envio',

                ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{view}{update}{delete}',
                            'buttons'=>[
                                    'view' => function ($url, $model) {     
                                                return Html::a( '<i class="glyphicon glyphicon-eye-open" style="color:white"></i>',
                                                        ['valores/view', 'id'=>$model->id],
                                                        ['class'=>'btn btn-warning btn-md modalButton', 'title'=>'view/edit', ]
                                                ); 
                                    },
                                    'update' => function ($url, $model) {     
                                    return Html::a( '<i class="glyphicon glyphicon-pencil" style="color:white"></i>',
                                                        ['valores/update', 'id'=>$model->id],
                                                        ['class'=>'btn btn-warning btn-md ', 'title'=>'Update', ]
                                                ); 
                                    },
                                    'delete' => function($url, $model) {
                                    return Html::a( '<i class="glyphicon glyphicon-trash" style="color:white"></i>',
                                                        ['valores/delete', 'id'=>$model->id],
                                                        ['class'=>'btn btn-warning btn-md ', 'title'=>'view/edit', 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']
                                                );
                                    }        
                            ]  
                                    
            ],
        ],
    ]); ?>
</div>

<style>
    .skip-export{
        /*border: solid 1px red;*/
        width: 150px !important;
    }
</style> 
