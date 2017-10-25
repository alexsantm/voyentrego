

<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaginaVoyentregoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pagina Voyentregos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagina-voyentrego-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Pagina Voyentrego', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
               'type' => GridView::TYPE_WARNING
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
                                              'class'=>'btn btn-success btn-md','title' => Yii::t('yii', 'Update'),
                                      ]); 
                                    },
      
                            ]  
                                    
            ],
        ],
    ]); ?>
</div>
