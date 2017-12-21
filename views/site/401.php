<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$name = "Usuario No autorizado";
$message = "Usuario No autorizado";
$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>


            <p>
                Usted no ha sido autorizado para ingresar a esta sección..
                Si considera que existe un error, por favor contáctese con el Administrador el Sitio.<br>
                Caso contrario, puede <a href='<?= Yii::$app->homeUrl ?>'>regresar al Inicio</a> 
            </p>

<!--            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>-->
        </div>
    </div>

</section>
