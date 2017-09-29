<div class="seccion_tomate_pasos"><center><span class="numero_pasos">1</span></center></div>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Envio */

        

$this->title = 'Nuevo Envio';
$this->params['breadcrumbs'][] = ['label' => 'Envios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="envio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $(".seccion_tomate_pasos").fadeIn(1500);
    },3000);
});
</script>-->