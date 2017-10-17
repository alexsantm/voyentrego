<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CalificacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificaciones de Mensajeros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calificacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Calificacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>   
 
    

<?php
echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'info', 'heading'=>'Mensajeros'],
    'rowOptions'=>function($model){
            if( ($model['calificacion'] == 1) || ($model['calificacion'] == 2) ){
                return ['class' => 'danger'];
                //return ['style'=>' background-color:#BAD0E9;'];
            }
            else if(($model['calificacion'] == 3)) {
                return ['class' => 'warning'];
//                return ['style'=>' background-color:#F7F7DD;'];
            }
            if( ($model['calificacion'] == 4) || ($model['calificacion'] == 5) ){
                return ['class' => 'success'];
                //return ['style'=>' background-color:#BAD0E9;'];
            }
    }, 
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'mensajero_id', 
            'label'=>'Mensajero',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value'=>function($model, $key, $index, $column) {
                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->mensajero_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
            },
//            'filterType'=>GridView::FILTER_SELECT2,
//            'filter'=>ArrayHelper::map(\app\models\Profile::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
//            'filterWidgetOptions'=>[
//                'pluginOptions'=>['allowClear'=>true],
//            ],
//            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'envio_id', 
            'label'=>'No. Envío',
            'hAlign' => 'center',
            'vAlign' => 'middle',
//            'value'=>function ($model, $key, $index, $widget) { 
//                return $model->category->category_name;
//            },
//            'filterType'=>GridView::FILTER_SELECT2,
//            'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'), 
//            'filterWidgetOptions'=>[
//                'pluginOptions'=>['allowClear'=>true],
//            ],
//            'filterInputOptions'=>['placeholder'=>'Any category']
        ],
        [
            'attribute'=>'user_id',
            'label'=>'Usuario',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'value'=>function($model, $key, $index, $column) {
                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
            },
        ],
        [
            'attribute'=>'calificacion',
            'hAlign' => 'center',
            'vAlign' => 'middle',
//            'value'=>function($model, $key, $index, $column) {                
//                            $var = '<strong>'.$model->calificacion.'</strong>';
//                            return $var;
//            },
//            'format'=>['decimal', 2],
//            'pageSummary'=>true,
//            'pageSummaryFunc'=>GridView::F_AVG
        ],
                    
//        [
//                'label' => "Calificación",
//                'attribute' => '',
//                'hAlign' => 'center',
//                'vAlign' => 'middle',
////                'value' => function($model, $key, $index, $column) {
////                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->asArray()->one();
////                        return '';
////                },        
//                      'contentOptions' => function ($model, $key, $index, $column) {
//                          print_r($model['callificacion']); die();
////                    $service = \app\models\Calificacion::find()->where(['mensajero_id'=>$model->mensajero_id])->asArray()->one();
//                    //return $service ? $service['calificacion'] : '-';  
//                    $calificacion = $model->calificacion;
//                   if(($calificacion == 1) || ($calificacion == 2)){
//                        return ['class' => 'alert alert-danger', 'style'=>'border-radius: 10px;'];                           
//                   }
//                   else if(($calificacion == 4) || ($calificacion == 5)){
//                        return ['class' => 'alert alert-success', 'style'=>'border-radius: 10px;'];                           
//                   }
//                   else if(($calificacion == 3)){ 
//                        return ['class' => 'rating-static rating-'.$calificacion,
//                            
//                        ]; 
//                   }
//            },
//                'filter'=>false        
//        ], 
                    
        [
            'attribute'=>'observacion',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'format'=>'html',            
            'filter'=>false,
//            'format'=>['decimal', 0],
//            'pageSummary'=>true
        ],
    ],
]);

?>

    
    
    
<?php Pjax::end(); ?>
</div>