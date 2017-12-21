<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HistorialPagosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historial Pagos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 

        $searchModel = new \app\models\HistorialPagosSearch();

        $dataProvider = $searchModel->searchsemanal(Yii::$app->request->queryParams);        
        $semanal = $this->render('/historial-pagos/indexsemanal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
                  
        $dataProvider = $searchModel->searchquincenal(Yii::$app->request->queryParams);        
        $quincenal = $this->render('/historial-pagos/indexquincenal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        $dataProvider = $searchModel->searchmensual(Yii::$app->request->queryParams);        
        $mensual = $this->render('/historial-pagos/indexmensual', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

?>

<?php
echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_CENTER,
    'encodeLabels'=>false,
    'enableStickyTabs'=>true,
//    'position'=>TabsX::POS_RIGHT,
    'items' => [
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i> PAGOS SEMANALES',
            'content' => $semanal,
            'active' => true,
            'bordered'=>true,
            'options' => ['id' => 'semanal'],
            'height'=>TabsX::SIZE_LARGE,
            'headerOptions' => ['style'=>'font-weight:bold; font-size:18px;'],
        ],
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i> PAGOS QUINCENALES',
            'content' => $quincenal,
            'bordered'=>true,
            'options' => ['id' => 'quincenal'],
            'height'=>TabsX::SIZE_LARGE,
            'headerOptions' => ['style'=>'font-weight:bold; font-size:18px;'],
        ],
        [
            'label' => '<i class="glyphicon glyphicon-usd"></i> PAGOS MENSUALES',
            'content' => $mensual,
            'headerOptions' => ['style'=>'font-weight:bold; font-size:18px;'],
            'options' => ['id' => 'mensual'],
            'height'=>TabsX::SIZE_LARGE,
            'bordered'=>true,
        ],        
    ],
]);
?>