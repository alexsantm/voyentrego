<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PromocionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promociones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Promocion', ['create'], ['class' => 'btn btn-warning']) ?>
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
            'codigo_promocion',
            'valor_promocion',
            'valor_base',
            'limite',
             'fecha_inicio',
             'fecha_fin',

//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{view}{update}{delete}',
                          //  'template'=>'{delete}',
                            'buttons'=>[
                                    'view' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                                              'class'=>'btn btn-warning btn-md modalButton','title' => Yii::t('yii', 'View'),
                                      ]); 
                                    },
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
