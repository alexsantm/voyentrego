<div class="seccion_tomate_pasos"><center><span class="numero_pasos">1</span></center></div>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Envio */

        

$this->title = 'Nuevo Envio Programado';
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formprog', [
        'model' => $model,
    ]) ?>

</div>
