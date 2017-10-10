<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecargaTransferencia */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recarga Transferencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recarga-transferencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'user_id',
             [
                'attribute' => 'user_id',
                'label' => 'Usuario',
                'value' => call_user_func(function ($model) {
                         $service = app\models\Profile::find()->select('full_name')->where(['user_id'=>$model->user_id])->asArray()->one();
                            $full_name = $service['full_name'];
                            return $full_name ? $full_name : '-';
               }, $model),                        
             ],
            'fecha',
//            'doc_referencia',
//              [
//                'attribute' => 'doc_referencia',
//                'label' => 'Documento',
//                'value' => ((!empty($model->doc_referencia)) ? Html::a(Html::img(Yii::$app->homeUrl. 'images/transferencias/'.$model->doc_referencia, ['alt'=>'Imagen', 'id' => 'myImg', 'data-pjax' => '0', 'height'=>'100px', 'width'=>'100px',]), ''):  "No existen imágenes adjuntas"),                       
//             ],          
            'valor',
//            'estado_id',
            [
                'attribute' => 'estado_id',
                'label' => 'Estado',
                'value' => call_user_func(function ($model) {
                         $service = app\models\Estado::findOne($model->estado_id);                                                      
                         return $service ? $service->estado : '-';
               }, $model),                        
            ],
        ],
    ]) ?>
    
     <?php
//       if ($model->doc_referencia!='') {
//         echo '<br /><p><center><img  rel="facybox" src="'.Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia.'"></center></p>';
//       }    
    ?>
    <!--<a class="fancybox" rel="group" href="big_image_1.jpg"><img src="small_image_1.jpg" alt="" /></a>-->

</div>

<center>
<?php
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '800px',
        'maxHeight' => '800px',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => true,
        'width' => '800px',
        'height' => '800px',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => true,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 30, 'height' => 30],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
//echo Html::a($model->doc_referencia, \yii\helpers\Url::base().'/images/transferencias/'.$model->doc_referencia, ['height'=>'10px', 'width'=>'10px', 'rel' => 'fancybox']);     
echo Html::a(Html::img(Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia), Yii::$app->homeUrl. '/images/transferencias/'.$model->doc_referencia, ['height'=>'10px', 'width'=>'10px', 'rel' => 'fancybox']);
?>
</center>


   