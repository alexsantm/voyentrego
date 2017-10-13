<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = "Preguntas Frecuentes"
?>
<h2>Preguntas Frecuentes</h2>
<?php
foreach ($query_preguntas as $p){
    $pregunta = $p['pregunta_frecuente'];
    $preguntas_id =$p['id'];
    $resp = \app\models\Respuestas::find()->where(['preguntas_frecuentes_id'=>$preguntas_id])->asArray()->one();
    $respuesta= $resp['respuesta'];

      echo yii\jui\Accordion::widget([
      'items' => [
          [
              'header' => $pregunta ,
//              'headerOptions' => ['tag' => 'h2'],
              'options' => ['tag' => 'div'],
              'content' => $respuesta,
          ],
      ],
      'options' => ['tag' => 'div', 'animated'=>'bounceslide',],
      'itemOptions' => ['tag' => 'div'],
      'headerOptions' => ['tag' => 'h2'],
      'clientOptions' => ['collapsible' => true, 'active'=>true],
  ]);    
 }   
    ?>
    
<style>   
    .ui-accordion .ui-accordion-icons {
    background: #F9A233;
    color: white;
}

.ui-accordion-header-icon .ui-icon .ui-icon-triangle-1-e{
     color: white;
}
</style>