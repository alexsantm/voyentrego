<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanesRecargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes Recargas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planes-recarga-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Registra Plan de Recarga', ['create'], ['class' => 'btn btn-warning modalButton']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
               'type' => GridView::TYPE_WARNING,
                'heading'=> 'Planes de Recarga',
                'footer'=>false,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'valor',
            'valor_promo',

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
</div>

<?php
 yii\bootstrap\Modal::begin([
        //'header' => 'Formulario Recepción de Pedido',
        'id'=>'editModalId',
        'class' =>'modal',
        'size' => 'modal-md',
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