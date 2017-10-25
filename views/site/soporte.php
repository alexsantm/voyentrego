<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo("<center><h2>Soporte Voyentrego</h2></center>");

 $query_preguntas = \app\models\PreguntasFrecuentes::find()->asArray()->all();
        $query_respuestas = \app\models\Respuestas::find()->asArray()->all();
        $preguntas = $this->render('/preguntas-frecuentes/preguntas', [
            'query_preguntas' => $query_preguntas,
            'query_respuestas' => $query_respuestas,
        ]);
        
        $model = new app\models\Contactanos;
        $contactanos = $this->render('/contactanos/create', [
            'model' => $model,
//            'query_respuestas' => $query_respuestas,
        ]);


 $query_direccion = \app\models\ContactanosPagina::find()->asArray()->one();
  $direccion =$query_direccion['texto'];

//$direccion = $this->render('/site/contactanos', [
//        ]);


//$searchModel = new app\models\ValoresSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
//$valores = $this->render('/valores/index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//
//$searchModel = new app\models\OpcionesSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
//$opciones = $this->render('/opciones/index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//
//$searchModel = new app\models\TipoEnvioSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
//$tipo_envio = $this->render('/tipo-envio/index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//
//$searchModel = new app\models\DimensionesSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);    
//$dimensiones = $this->render('/dimensiones/index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);

/******************************************************************************************************************************************/

echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'encodeLabels'=>false,
    'enableStickyTabs'=>true,
    'position'=>TabsX::POS_LEFT,
    'items' => [

        [
            'label' => 'PREGUNTAS FRECUENTES',
            'content' => $preguntas,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'active' => true,
            'options' => ['id' => 'preguntas'],
            'bordered'=>true,
        ],
        [
            'label' => 'COMENTARIOS, SUGERENCIAS O QUEJAS',
            'content' => $contactanos,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'comentarios'],
            'bordered'=>true,
        ],
        
        [
            'label' => 'CONTACTENOS',
            'content' => $direccion,
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'contactanos'],
            'bordered'=>true,
        ],
    ],
]);
?>

<style>
    .nav-tabs > li > a {
    text-align: center;
}    
</style>    