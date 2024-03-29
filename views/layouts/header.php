<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?php 
    $rol = Yii::$app->user->identity['role_id']; 
    $id_usuario = Yii::$app->user->identity['id'];

    if(!empty($rol))   {
        $profile = Yii::$app->user->identity->profile;
        $user = Yii::$app->user->identity;
            
    ?><?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg hvr-bounce-in">' . Html::img(Yii::$app->request->baseUrl.'/images/logos/mainLogo.png', ['width'=>'200','height'=>'43']) . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
        
    <nav class="navbar navbar-static-top" role="navigation">

    <!--Diferenciacion de colores respecto a rol-->
        <?php
//        if(empty($user->profile->full_name)){
//            ?>
    <!--<center><span id="bienvenido" class="alert alert-danger" style="font-size: 30px;margin-left: 20px;"> Ingrese sus datos personales</span></center>--><?php
//        }else 
        if(($rol==2) && (!empty($user->profile->full_name))){  //Usuario          
            ?><span id="bienvenido" class="texto_tomate" style="font-size: 30px;margin-left: 20px;"> Bienvenid@ Usuario <?= $user->profile->full_name ?></span><?php
        }else if(($rol==3) && (!empty($user->profile->full_name))){  //Mensajero
            ?>
            <style>
                .skin-blue .main-header .navbar {
                    background-color: #264E61 !important;
                }            
            </style>
            
            <span id="bienvenido" class="fondo_azul" style="font-size: 30px;margin-left: 20px;">Mensajero: <?= $user->profile->full_name ?></span><?php
        }else if(($rol==4) && (!empty($user->profile->full_name))){  //Administrador
            ?><span id="bienvenido" class="texto_tomate" style="font-size: 30px;margin-left: 20px;">Empresa: <?= $user->profile->full_name ?></span><?php
        }
        else if(($rol==1) && (!empty($user->profile->full_name))){  //SuperAdministrador
            ?><span id="bienvenido" class="texto_tomate" style="font-size: 30px;margin-left: 20px;">Super Administrador: <?= $user->profile->full_name ?></span><?php
        }
        else if(($rol==5) && (!empty($user->profile->full_name))){  //Administrador de Flota
            ?><span id="bienvenido" class="texto_tomate" style="font-size: 30px;margin-left: 20px;">Admin Flota: <?= $user->profile->full_name ?></span><?php
        }
        ?>                
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

         <?php
         $rol = Yii::$app->user->identity['role_id']; 
         if(($rol==2) || ($rol==4)){ //Usuario y Empresa
             $user_id = Yii::$app->user->identity['id'];
             $model= new app\models\User;
             $envios_inicializados_hoy_usuario= $model->envios_inicializados_hoy_usuario($user_id);
             $envios_pendientes_hoy_usuario= $model->envios_pendientes_hoy_usuario($user_id);
             $envios_finalizados_hoy_usuario= $model->envios_finalizados_hoy_usuario($user_id);                          
             $total_notificaciones =  $envios_inicializados_hoy_usuario + $envios_pendientes_hoy_usuario + $envios_finalizados_hoy_usuario;
             ?>
              <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <!--<span class="label label-warning">10</span>-->
                        <span class="label label-warning"><?= $total_notificaciones ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Notificaciones:</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <!--<i class="fa fa-users text-aqua"></i> 5 new members joined today-->
                                        <i class="fa fa-telegram text-red"></i> <?= $envios_inicializados_hoy_usuario ?> Envios iniciados para hoy
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
<!--                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may
                                        not fit into the page and may cause design problems-->
                                        <i class="fa fa-warning text-yellow"></i> <?= $envios_pendientes_hoy_usuario ?> Envíos en proceso para hoy
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-check-square text-green"></i> <?= $envios_finalizados_hoy_usuario ?> Envíos finalizados hoy
                                    </a>
                                </li>

<!--                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>-->
                            </ul>
                        </li>
                        <!--<li class="footer"><a href="#">View all</a></li>-->
                    </ul>
                </li>
                
             <?php   
         }
         else if($rol==3){ //Mensajero
             $user_id = Yii::$app->user->identity['id'];
             $model= new app\models\User;
                $calificacion_mensual_mensajero= $model->calificacion_mensual_mensajero($user_id);
                $calificacion_mes_anterior_mensajero= $model->calificacion_mes_anterior_mensajero($user_id);
                $envios_asignados_hoy_mensajero= $model->envios_asignados_hoy_mensajero($user_id);
                $envios_asignados_mes_mensajero= $model->envios_asignados_mes_mensajero($user_id);
                $envios_exitosos_mes_mensajero= $model->envios_exitosos_mes_mensajero($user_id);
                $favoritismo= $model->favoritismo($user_id);
//                print_r($calificacion_mensual_mensajero); die();
                
                $porc_calificacion_mensual_mensajero = $calificacion_mensual_mensajero *10;
                $porc_calificacion_mes_anterior_mensajero = $calificacion_mes_anterior_mensajero *10;
                
                $cal_mensual= ($calificacion_mensual_mensajero * 2)*10;
                $cal_anterior_mes= ($calificacion_mes_anterior_mensajero * 2)*10;
                $porc_envios_asignados_hoy_mensajero = $calificacion_mensual_mensajero *10;
                $porc_envios_asignados_mes_mensajero = $calificacion_mensual_mensajero *10;
                $porc_envios_asignados_mes_mensajero = $calificacion_mensual_mensajero *10;
                
             
             ?>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">2</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Calificacion</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Calificación Mensual
                                            <small class="pull-right"><?= round($calificacion_mensual_mensajero, 2); ?> / 5</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: <?= $cal_mensual ?>%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only"><?= $cal_mensual ?>% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Calificación del Mes Anterior
                                            <small class="pull-right"><?= round($calificacion_mes_anterior_mensajero, 2); ?> / 5</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: <?= $cal_anterior_mes ?>%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only"><?= $cal_anterior_mes ?>% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
<!--                                <li> Task item 
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>-->
                                <!-- end task item -->
<!--                                <li> Task item 
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                 role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>-->
                                <!-- end task item -->
                            </ul>
                        </li>
<!--                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>-->
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                
             <?php
         }
                ?>
                

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle usuarioa" data-toggle="dropdown">
<!--                        <img src="<? $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>-->
                        <?php //echo Html::img('@web/fotos/'.$user->foto, ['class' => 'user-image']); ?>
                        <?php if(!empty($profile->foto)){
                                     echo Html::img('@web/images/fotos/'.$profile->foto, ['class' => 'user-image hvr-wobble-vertical', 'style'=>'width:40px; height:40px;']);
                                }
                                else{
                                    echo Html::img('@web/images/fotos/default.jpg', ['class' => 'user-image hvr-wobble-vertical']);
                                }
                        ?>
                        <!--<span class="hidden-xs"><?php // echo isset($user->username);?></span>-->                        
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" >
                            <!--<center><div class="col-lg-12">-->
                                <?php if(!empty($profile->foto)){
                                        echo Html::img('@web/images/fotos/'.$profile->foto, ['class' => 'user-image', 'style'=>'width:110px; height:110px;']);
                                    }
                                    else{
                                        echo Html::img('@web/images/fotos/default.jpg', ['class' => 'user-image']);
                                    }
                                ?>
<!--                            </div></center>    
                            <center><div class="col-lg-12">-->
                                <p>
                                   <?php 
                                   if(!empty($profile->full_name)){                                   
                                   echo $profile->full_name;?>
                                    <small>Miembro desde: <?php setlocale(LC_ALL,"es_ES"); echo date("M j, Y", strtotime($user->created_at));  ?></small>
                                   <?php                                    
                                   } 
                                   else{ 
                                    echo "Usuario";?>
                                    <small>Miembro desde: <?php setlocale(LC_ALL,"es_ES"); echo date("M j, Y", strtotime($user->created_at));  ?></small>
                                    <?php } ?>
                                </p>
                            <!--</div></center>-->
                        </li>
                        <!-- Menu Body -->
<!--                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <!--<div class="row">-->
                            <li class="user-footer">
                                <div class="col-lg-12 col-offset-md-12 col-offset-sm-12 col-offset-xs-12">                               
                                    <?php // Html::a('Mi perfil', ['/user/profile'], ['class'=>'col-md-12 btn btn-default btn-flat'])?>
                                    <?= Html::a('Mi perfil', ['/user/profile'], ['class'=>'hvr-pulse hvr-reveal col-md-12 btn btn-default btn-flat'])?>
                                </div>
                                
                                <div class="col-lg-12 col-offset-md-12 col-offset-sm-12 col-offset-xs-12">                               
                                    <?= Html::a('Cambio contraseña', ['/user/account'], ['class'=>'hvr-pulse hvr-reveal col-md-12  btn btn-default btn-flat'])?>
                                </div>
                                <div class="col-lg-12 col-offset-md-12 col-offset-sm-12 col-offset-xs-12">                               
                                    <?php
                                    
                                    if(($rol ==1) ||($rol ==2) ||($rol ==4)){
                                        echo Html::a( 'Recargas',
//                                        ['/recarga/view','id'=>$id_usuario],['class'=>'hvr-pulse hvr-reveal col-md-12  btn btn-default btn-flat']); 
                                        ['/recarga/detalles'],['class'=>'hvr-pulse hvr-reveal col-md-12  btn btn-default btn-flat']); 
                                    }
                                    else if(($rol ==3) ||($rol ==5)){
                                        echo Html::a( 'Datos Transferencia',
                                        ['//datos-bancarios-mensajero/view','id'=>$id_usuario],['class'=>'hvr-pulse hvr-reveal col-md-12  btn btn-default btn-flat']); 
                                    }
                                ?>            
                                    
                                </div>                                
                                <div class="col-lg-12 col-offset-md-12 col-sm-12 col-xs-12">
                                    <?= Html::a( 'Salir',
                                        ['//user/logout'],['data-method' => 'post','class'=>'hvr-pulse hvr-reveal col-md-12  btn btn-default btn-flat']    
                                        ); ?>
                                </div>
                            </li>
                        <!--</div>-->
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
<!--                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>
<?php
}
else{
?>

<h2>NO se ha logueado</h2>
<?php
}
?>



  <style>
@media (max-width: 553px) {
    #bienvenido {
      display: none;
    }
}



.hvr-reveal:before {
    border-color: #F7931E !important;
}
  
  </style>