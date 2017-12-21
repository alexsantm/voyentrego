<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProblemaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de inconvenientes encontrados por mensajeros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="problema-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Añadir nuevo Inconveniente', ['create'], ['class' => 'btn btn-warning']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
          'type' => GridView::TYPE_WARNING,
          'heading' =>'Lista de Problemas encontrados por Mensajeros',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'problema',
//            'buscar_mensajero',
            [
                'attribute' => 'buscar_mensajero',
                'label'=>'¿Se necesita buscar mensajero?',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'value'=>function($model, $key, $index, $column) {
                            if($model->buscar_mensajero == 1){
                                return "SI";
                            }
                            else{
                                return "NO";
                            }
                         },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
