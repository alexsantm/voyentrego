<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialPagosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Pagos - Mensual';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historial-pagos-mensual-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Historial Pagos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'id' => 'indexmensual',
        'dataProvider' => $dataProvider,
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            'refreshGrid' => true,
        ],
        'filterModel' => $searchModel,
           'panel' => [
               'type' => GridView::TYPE_WARNING,
               'heading'=>'Pagos Mensuales' 
           ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'mensajero_id',
             [
                'attribute' => 'mensajero_id',
                'label'=>'Mensajero',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value'=>function($model, $key, $index, $column) {
                            $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->mensajero_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
                         },
            ],
            'valor',
            'fecha',
            
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'referencia',
                //'width' => '20px !important',
                'label' => 'Referencia Bancaria',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'value' => function($model, $key, $index, $column) {
                        $service = app\models\HistorialPagos::findOne($model->id);
                        if(empty($service['referencia'])){
                            return "(Ingrese una referencia Bancaria)";
                        }
                        else{
                            return $service['referencia'];
                        }
                },
                'editableOptions' => [
                    'name'=>'referencia', 
                    'placement'=> 'left', 
                    'asPopover' => true,
                    'header' => 'Referencia',
                    'size'=>'md',
                    'options' => ['class'=>'form-control', 'placeholder'=>'Ingrese la Referencia Bancaria...']
                ],        
            ],
                                 
                                 
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'estado',
                //'width' => '20px !important',
                'label' => 'Estado',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                //            'filterInputOptions'=>['placeholder'=>'Escoga una Zona...'],
                'value' => function($model, $key, $index, $column) {
                    $service = app\models\Estado::findOne($model['estado']);
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

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>