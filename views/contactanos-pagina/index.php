

<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaginaVoyentregoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Administrador de Información Voyentrego';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagina-voyentrego-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Pagina Voyentrego', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>Haga click en ACTUALIZAR para completar la información de soporte de Voyentrego. Puede ingresar formato texto o HTML</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
               'type' => GridView::TYPE_WARNING,
               'heading'=>'Información de Contacto Voyentrego' 
           ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'texto:html',
             [
                 'label' =>"Texto",               
                 'attribute' => 'texto',
                 'hAlign'=>'center',
                 'vAlign'=>'middle',
                 'format'=>'html',
                'filter'=>false,
            ],
            

//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'kartik\grid\ActionColumn',
                          'template'=>'{update}',
                            'buttons'=>[
                                    'update' => function ($url, $model) {     
                                    return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                                              'class'=>'btn btn-warning btn-md modalButton','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
      
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
        'size' => 'modal-lg',
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

<style>
    .kv-panel-before, #w0-filters{
        display:none;
    }
</style>    