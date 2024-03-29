<?php
use yii\helpers\Html;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
//use yii\bootstrap\NavBar;
//use yii\bootstrap\Nav;

$user = Yii::$app->user->identity;
$rol = Yii::$app->user->identity['role_id']; 
//$profile = Yii::$app->user->identity->profile;
?>

<aside class="main-sidebar">

    <section class="sidebar">
        <?php
        
if(!empty($user->profile->full_name)) //for now i use this to be rendered only if the name of the user is admin, but i want to change it to be available for everyone who are admin.
{         
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Login', 'url' => ['user/login'],'visible' => Yii::$app->user->isGuest,'options' => ['class' => 'header']],
//                    ['label' => 'Nuevo Envío', 'icon' => 'location-arrow', 'url' => ['envio/create'], 'visible' => Yii::$app->user->can("admin")],
                    [
                        'label' => 'Nuevo Envìo',
                        'icon' => 'telegram',
                        'url' => '#',
                        'visible' => $rol ==2,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Envìo Normal', 'icon' => 'file-code-o', 'url' => ['//envio/create'],'options' => ['class' => 'hvr-bounce-to-right'],],
                            ['label' => 'Envìo Programado', 'icon' => 'calendar', 'url' => ['//envio/createprog'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Envìo Recurrente', 'icon' => 'table', 'url' => ['//envio/createrec'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                    ['label' => 'Historial Envios', 'icon' => 'archive', 'url' => ['//envio/index'], 'options' => ['class' => 'hvr-bounce-to-right'],'visible' => $rol ==2,],
//                    ['label' => 'Estadísticas', 'icon' => 'bar-chart', 'url' => ['#'], 'visible' => Yii::$app->user->can("admin")],
                    

                    
                    ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==2,  
                      'url' => ['site/soporte'],
                      'options' => ['class' => 'hvr-bounce-to-right']  
//                      'options' => ['class' => 'hvr-sweep-to-right'],  
                    ],
                    /************************************************EMPRESA*************************************************************/
                    
                    [
                        'label' => 'Nuevo Envìo',
                        'icon' => 'telegram',
                        'url' => '#',
                        'visible' => $rol ==4,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Envìo Normal', 'icon' => 'file-code-o', 'url' => ['//envio/create'],'options' => ['class' => 'hvr-bounce-to-right'],],
                            ['label' => 'Envìo Programado', 'icon' => 'calendar', 'url' => ['//envio/createprog'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Envìo Recurrente', 'icon' => 'table', 'url' => ['//envio/createrec'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                   
                    [
                        'label' => 'Usuarios',
                        'icon' => 'users',
                        'url' => '#',
                        'visible' => $rol ==4,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Usuarios', 'icon' => 'user', 'url' => ['//user/admin/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Grupos', 'icon' => 'users', 'url' => ['//grupo-usuarios/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Asignación de Grupos', 'icon' => 'user-plus', 'url' => ['//user-grupo/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                    
//                    [
//                        'label' => 'Flota',
//                        'icon' => 'car',
//                        'url' => ['//datos-vehiculo/index'],
//                        'options' => ['class' => 'hvr-bounce-to-right'],
//                        'visible' => $rol ==4,
//                    ],
                    
                     ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==4,  
                      'options' => ['class' => 'hvr-bounce-to-right'],   
                      'url' => ['//site/soporte'],
                    ],
                    /************************************************MENSAJERO*************************************************************/
//                    [
//                        'label' => 'Pendientes',
//                        'icon' => 'exclamation',
//                        'url' => ['//envio/indexpendiente'],
//                        'visible' => $rol ==3,
//                    ],
                    
                    [
                        'label' => 'Historial',
                        'icon' => 'calendar-check-o',
                        'url' => ['//envio/indexmensajero'],
                        'visible' => $rol ==3,
                        'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                    [
                        'label' => 'Calificaciones',
                        'icon' => 'tachometer',
                        'url' => ['//envio/indexcalificacion'],
                        'visible' => $rol ==3,
                        'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                    [
                        'label' => 'Flota',
                        'icon' => 'car',
                        'url' => ['//datos-vehiculo/index'],
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'visible' => $rol ==3,
                    ],
                    
                    [
                        'label' => 'Pagos',
                        'icon' => 'money',
//                        'url' => ['//user/perfil#transferencia'],
                        'url' => ['//datos-bancarios-mensajero/view'],
                        'visible' => $rol ==3,
                        'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                    ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==3,  
                      'url' => ['//site/soporte'],
                      'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                    /************************************************ADMIN FLOTA*************************************************************/

                    [
                        'label' => 'Flota',
                        'icon' => 'car',
                        'url' => ['//datos-vehiculo/indexadminflota'],
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'visible' => $rol ==5,
                    ],
                    ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==5,  
                      'url' => ['//site/soporte'],
                      'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                    
                    
                    /************************************************SUPER ADMIN*************************************************************/
                    
                    [
                        'label' => 'Menú Administrador',
                        'icon' => 'bars',
                        'url' => '#',
                        'visible' => $rol ==1,
                        'options' => ['class' => 'hvr-bounce-to-right'],
//                        'visible' => Yii::$app->user->can("admin"),
                        'items' => [                            
                            ['label' => 'Tabla de Valores', 'icon' => 'file-text-o', 'url' => ['valores/index'],'options' => ['class' => 'hvr-bounce-to-right']],                            
                            ['label' => 'Calificación Mensajeros', 'icon' => 'star-half-o', 'url' => ['//calificacion/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Preguntas Frecuentes', 'icon' => 'question-circle', 'url' => ['//preguntas-frecuentes/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Información Mobilvendor', 'icon' => 'info', 'url' => ['//contactanos-pagina/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Admin Reporte Problemas', 'icon' => 'dashboard', 'url' => ['//problema/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Estado Mensajeros', 'icon' => 'dashboard', 'url' => ['//status-mensajero/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Opciones', 'icon' => 'dashboard', 'url' => ['//opciones/index'],'options' => ['class' => 'hvr-bounce-to-right']],
//                            ['label' => 'Pagos Mensajero', 'icon' => 'money', 'url' => ['//configuracion-pagos/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                    
                    [
                        'label' => 'Promociones',
                        'icon' => 'id-badge',
                        'url' => '#',
                        'visible' => $rol ==1,
                        'options' => ['class' => 'hvr-bounce-to-right'],
//                        'visible' => Yii::$app->user->can("admin"),
                        'items' => [
                            ['label' => 'Promociones', 'icon' => 'google-wallet', 'url' => ['//promocion/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Administrador Recargas', 'icon' => 'credit-card', 'url' => ['//recarga-transferencia/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Planes de Recarga', 'icon' => 'money', 'url' => ['//planes-recarga/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],

                    [
                        'label' => 'Pagos a Mensajeros',
                        'icon' => 'money',
                        'url' => '#',
                        'visible' => $rol ==1,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Configuración de Pagos', 'icon' => 'dashboard', 'url' => ['//configuracion-pagos/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Pagos Mensuales', 'icon' => 'money', 'url' => ['//historial-pagos/indexsemanal'],'options' => ['class' => 'hvr-bounce-to-right'],],
                            ['label' => 'Pagos Semanales', 'icon' => 'money', 'url' => ['//historial-pagos/indexquincenal'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Pagos Mensuales', 'icon' => 'money', 'url' => ['//historial-pagos/indexmensual'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                    
                    [
                        'label' => 'Tracking',
                        'icon' => 'location-arrow',
                        'url' => '#',
                        'visible' => $rol ==1,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Tracking Mensajero', 'icon' => 'file-code-o', 'url' => ['tracking/create'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Ubicacion Mensajeros', 'icon' => 'dashboard', 'url' => ['tracking/ubicacion'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Buscar Mensajero', 'icon' => 'dashboard', 'url' => ['tracking/busquedamensajero'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
                    
                    [
                        'label' => 'Roles y Usuarios',
                        'icon' => 'users',
                        'url' => '#',
                        'visible' => $rol ==1,
                        'options' => ['class' => 'hvr-bounce-to-right'],
                        'items' => [
                            ['label' => 'Usuarios', 'icon' => 'group', 'url' => ['/user/admin/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            //['label' => 'Roles', 'icon' => 'user', 'url' => ['//role/index'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Autorizar Mensajeros', 'icon' => 'user', 'url' => ['/user/admin/indexmensajeros'],'options' => ['class' => 'hvr-bounce-to-right']],
                            ['label' => 'Asignación a Flota', 'icon' => 'automobile', 'url' => ['//datos-vehiculo/indexsuperadmin'],'options' => ['class' => 'hvr-bounce-to-right']],
                        ],
                    ],
//                    [
//                        'label' => 'Rutas y Asignaciones',
//                        'icon' => 'users',
//                        'url' => '#',
//                        'visible' => $rol ==1,
//                        'options' => ['class' => 'hvr-bounce-to-right'],
//                        'items' => [
////                            ['label' => 'Rutas', 'icon' => 'user', 'url' => ['//ruta/index'],],
//                            ['label' => 'Asignaciones', 'icon' => 'user', 'url' => ['//asignacion/index'],'options' => ['class' => 'hvr-bounce-to-right']],
//                        ],
//                    ],
                     ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==1,  
                      'url' => ['site/soporte'],
                      'options' => ['class' => 'hvr-bounce-to-right']
                    ],
                    
                ],
            ]
        );         
}
else{
     echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => 'Completar Perfil',
                        'icon' => 'user-secret',
                        'url' => ['/user/profile'],                        
                    ],
                ],
            ]
        );
}
?>
<?php
//echo SideNav::widget([
//	'type' => SideNav::TYPE_WARNING,
////	'heading' => 'Menú Principal',
//	'items' => [
//		[
//			'url' => '#',
//			'label' => 'Nuevo Envío',
//			'icon' => 'home'
//		],
//                [
//			'url' => '#',
//			'label' => 'Rastrear',
//			'icon' => 'home'
//		],
//                [
//			'url' => '#',
//			'label' => 'Registro',
//			'icon' => 'home'
//		],
//                 [
//			'url' => '#',
//			'label' => 'Estadísticas',
//			'icon' => 'home'
//		],
////                 [
////			'url' => '#',
////			'label' => 'Home tres',
////			'icon' => 'Registro'
////		],
//		[
//			'label' => 'Help',
//			'icon' => 'question-sign',
//			'items' => [
//				['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
//				['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
//			],
//		],
//            
//                [
//			'label' => 'Super Administrador',
//			'icon' => 'question-sign',
//			'items' => [
//				['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
//				['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
//			],
//		],
//	],
//]);


//    $envio = Html::img(Yii::$app->request->baseUrl.'/images/iconos/menu_lateral/nuevoE.png', ['width'=>'30','height'=>'20']);
//    $menuItems[] =  ['label' => 'DFenX - Yii2 User - '. Yii::t('app','User Admin Panel'),  'icon' => 'cog', 'url'=>Url::to(['/user/admin/index'])];
//    $menuItems[] =  ['label' => 'Nuevo Envío ', 'id'=>'item_menu', 'icon' => $envio, 'url'=>Url::to(['/user/admin/index'])];
//        $menuItems[] =  ['label' => Yii::t('app','Authentication manager'),  'icon' => 'th-list', 'items' =>  [    
//                            ['label' => 'Settings', 'icon' => 'th-list', 'items' => [
//                                ['label' => '/user/settings',  'icon' => 'th-list', 'url'=>Url::to(['/user/settings'])],
//                                ['label' => '/user/settings/profile', 'url'=>Url::to(['/user/settings/profile'])],
//                                ['label' => '/user/settings/account',  'url'=>Url::to(['user/settings/account'])],
//                                ['label' => '/user/settings/networks', 'url'=>Url::to(['/user/settings/networks'])],
//                            ]],
//                            ['label' => 'Registration', 'icon' => 'th-list', 'items' => [                                
//                                ['label' => '/user/registration/register',  'url'=>Url::to(['/user/registration/register'])],
//                                ['label' => '/user/registration/resend',  'url'=>Url::to(['/user/registration/resend'])],
//                            ]],
//                            ['label' => 'Security', 'icon' => 'th-list', 'items' => [                                
//                                ['label' => '/user/security/login', 'url'=>Url::to(['/user/security/login'])],
//                                ['label' => '/user/security/logout',  'url'=>Url::to(['/user/security/logout'])],
//                            ]],
//                            ['label' => 'Recovery', 'icon' => 'th-list', 'items'  => [                               
//                                ['label' => '/user/recovery/request',  'url'=>Url::to(['/user/recovery/request'])],
//                                ['label' => '/user/recovery/reset',  'url'=>Url::to(['/user/recovery/reset'])],
//                             ]],
//                        ]];
//        $type = SideNav::TYPE_WARNING;
//        $heading = '<i class="glyphicon glyphicon-user"></i> ' . Yii::t('app','USER Admin - UTILITIES');
//
//        echo SideNav::widget([
//            'type' => $type,
//            'encodeLabels' => false,
//            'heading' => $heading,
//            'items' =>$menuItems,
//        ]);
?>
    </section>

</aside>

<style>
    
    /*Formato de efecto en menu*/
    .menu{
        width: 100% !important;
    }
    
    body > div.wrapper > aside.main-sidebar > section > ul > li.hvr-bounce-to-right{
        width: 100% !important;
    }
    
    .hvr-bounce-to-right:before {
        background: #DCDFE3 !important;
    }
    .hvr-bounce-to-right{
        display:block !important;
    }
    
    
/*Borde izquierdo de los submenus:*/    
.sidebar-menu li {
     box-shadow: 5px 0px #EEA236 inset !important;
}


/*Cuando esta activo el boton*/
skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
    background-color: #F6A236 !important;
    color: white !important;
    border: solid 2px #F08022;
}   
    
    .sidebar-menu {
        height: 100%;
/*        min-height: 1000px;
        line-height: 40px;*/
        background-color: #FFF;
        list-style-type: none;
        font-family: Exo, sans-serif;
        text-transform: uppercase;
        font-weight: 300;
                /*box-shadow: 3px 3px 3px rgba(0,0,0,0.25);*/
        /*outline: 1px solid white;*/
    }
    
  
    img.logo {
        margin: 8px 0;
    }

    img.icon {
        margin-top: 14px;
    }

    .sidebar-menu a {
        /*background: url(../images/icons.png) no-repeat left top;*/
        color: #666;
        text-decoration: none;
        /*margin-left: 20px;*/
        display: block; /*amplía cobertura hover*/
        width: 100%;
        text-align: center;
        /*margin: 14px 0;*/
    }

    .sidebar-menu li  {
        /*outline: 1px solid white;*/
        border-bottom: 1px solid rgba(157,157,157,0.9);
        box-shadow: 5px 0px rgba(157,157,157,0.5) inset;
        transition: box-shadow 0.4s; /*tiempo de movimiento*/
        -webkit-transition: box-shadow 0.4s;
        -o-transition: box-shadow 0.4s;
    }

    .sidebar-menu li:hover {
        /*background: #ECF0F5;*/
        background: transparent;
        /*border: solid 1px red;*/
        box-shadow: 250px 0px rgba(157,157,157,0.2) inset; /*inset: para que se aplique la sombra desde adentro*/
    }

    .sidebar-menu li:active {
        color: #FF5515;
    }
    
    .skin-blue .sidebar a:hover {
     background-color: transparent !important; 
    }
    
    
    
    .skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
        border-left-color: #F7931E !important;
    }
</style>