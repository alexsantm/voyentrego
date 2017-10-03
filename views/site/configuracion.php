<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$searchModel = new app\models\ValoresSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
$valores = $this->render('/valores/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

$searchModel = new app\models\OpcionesSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
$opciones = $this->render('/opciones/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

$searchModel = new app\models\TipoEnvioSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
$tipo_envio = $this->render('/tipo-envio/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

$searchModel = new app\models\DimensionesSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
$dimensiones = $this->render('/dimensiones/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

/******************************************************************************************************************************************/

echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'encodeLabels'=>false,
    'enableStickyTabs'=>true,
//    'position'=>TabsX::POS_RIGHT,
    'items' => [
        [
            'label' => 'Tabla de Valores(km)',
            'content' => $valores,
            'active' => true,
            'bordered'=>true,
            'height'=>TabsX::SIZE_LARGE,
        ],
        [
            'label' => 'Radio de búsqueda',
            'content' => $opciones,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'opciones'],
            'bordered'=>true,
        ],
        [
            'label' => 'Tipos de Envìo',
            'content' => $tipo_envio,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'tipo_envio'],
            'bordered'=>true,
        ],
        
        [
            'label' => 'Dimensiones',
            'content' => $dimensiones,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'dimensiones'],
            'bordered'=>true,
        ],
    ],
]);