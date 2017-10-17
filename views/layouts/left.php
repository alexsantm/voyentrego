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
                        'icon' => 'location-arrow',
                        'url' => '#',
                        'visible' => $rol ==2,
                        'items' => [
                            ['label' => 'Envìo Normal', 'icon' => 'file-code-o', 'url' => ['envio/create'],],
                            ['label' => 'Envìo Programado', 'icon' => 'dashboard', 'url' => ['envio/createprog'],],
                            ['label' => 'Envìo Recurrente', 'icon' => 'dashboard', 'url' => ['envio/createrec'],],
                        ],
                    ],
                    
                    [
                        'label' => 'Tracking',
                        'icon' => 'location-arrow',
                        'url' => '#',
                        'visible' => $rol ==2,
                        'items' => [
                            ['label' => 'Tracking Mensajero', 'icon' => 'file-code-o', 'url' => ['tracking/create'],],
                            ['label' => 'Ubicacion Mensajeros', 'icon' => 'dashboard', 'url' => ['tracking/ubicacion'],],
                        ],
                    ],
//                    ['label' => 'Rastreo', 'icon' => 'cogs', 'url' => ['#'], 'visible' => Yii::$app->user->can("admin")],
//                    ['label' => 'Estadísticas', 'icon' => 'bar-chart', 'url' => ['#'], 'visible' => Yii::$app->user->can("admin")],
                    

                    
                    ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==2,  
                      'url' => ['site/soporte'],
                    ],
                    
//                    [
//                        'label' => 'Ayuda',
//                        'icon' => 'question-circle',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                    /************************************************ADMINISTRADOR*************************************************************/
                    
                    [
                        'label' => 'Nuevo Envìo',
                        'icon' => 'location-arrow',
                        'url' => '#',
                        'visible' => $rol ==4,
                        'items' => [
                            ['label' => 'Envìo Normal', 'icon' => 'file-code-o', 'url' => ['envio/create'],],
                            ['label' => 'Envìo Programado', 'icon' => 'dashboard', 'url' => ['envio/createprog'],],
                            ['label' => 'Envìo Recurrente', 'icon' => 'dashboard', 'url' => ['envio/createrec'],],
                        ],
                    ],
                    
                                        [
                        'label' => 'Configuración',
                        'icon' => 'question-circle',
                        'visible' => $rol ==4,
                        'url' => '#',
                        'items' => [
                            ['label' => 'Opciones', 'icon' => 'dashboard', 'url' => ['site/configuracion'],],
                            
                            //['label' => 'Tabla de Valores', 'icon' => 'dashboard', 'url' => ['valores/index'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],
                    
                    
                    [
                        'label' => 'Menú Administrador',
                        'icon' => 'bars',
                        'url' => '#',
                        'visible' => $rol ==4,
//                        'visible' => Yii::$app->user->can("admin"),
                        'items' => [
                            ['label' => 'Administrador Recargas', 'icon' => 'credit-card', 'url' => ['//recarga-transferencia/index'],],
                            ['label' => 'Tabla de Valores', 'icon' => 'file-text-o', 'url' => ['valores/index'],],
                            ['label' => 'Promociones', 'icon' => 'google-wallet', 'url' => ['//promocion/index'],],
                            ['label' => 'Calificación Mensajeros', 'icon' => 'google-wallet', 'url' => ['//calificacion/index'],],
//                            ['label' => 'Preguntas Frecuentes', 'icon' => 'dashboard', 'url' => ['//preguntas-frecuentes/index'],],
//                            ['label' => 'Preguntas', 'icon' => 'dashboard', 'url' => ['//preguntas-frecuentes/preguntas'],],
//                            ['label' => 'Opcon 2', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['#']],
                        ],
                    ],
                    
//                    [
//                        'label' => 'User Administrador',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'visible' => $rol ==4,
//                        'items' => [
//                            ['label' => 'Crear Usuarios', 'icon' => 'file-code-o', 'url' => ['/user/admin/index'],],
//                            ['label' => 'Crear Grupos de Usuarios', 'icon' => 'dashboard', 'url' => ['//grupo-usuarios/index'],],
//                            ['label' => 'Asignación de Grupos', 'icon' => 'dashboard', 'url' => ['//user-grupo/index'],],
//                            ['label' => 'Administración de Flota', 'icon' => 'dashboard', 'url' => ['//datos-vehiculo/index'],],
////                            ['label' => 'Preguntas', 'icon' => 'dashboard', 'url' => ['//preguntas-frecuentes/preguntas'],],
////                            ['label' => 'Opcon 2', 'icon' => 'dashboard', 'url' => ['/debug'],],
////                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['#']],
//                        ],
//                    ],
                    
                    [
                        'label' => 'Usuarios',
                        'icon' => 'users',
                        'url' => '#',
                        'visible' => $rol ==4,
                        'items' => [
                            ['label' => 'Usuarios', 'icon' => 'user', 'url' => ['/user/admin/index'],],
                            ['label' => 'Grupos', 'icon' => 'users', 'url' => ['//grupo-usuarios/index'],],
                            ['label' => 'Asignación de Grupos', 'icon' => 'user-plus', 'url' => ['//user-grupo/index'],],
                        ],
                    ],
                    
                    [
                        'label' => 'Flota',
                        'icon' => 'car',
                        'url' => ['//datos-vehiculo/index'],
                        'visible' => $rol ==4,
                    ],
                    
                     ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==4,  
                      'url' => ['site/soporte'],
                    ],
                    /************************************************MENSAJERO*************************************************************/
                    [
                        'label' => 'Pendientes',
                        'icon' => 'exclamation',
                        'url' => ['//envio/indexpendiente'],
                        'visible' => $rol ==3,
                    ],
                    
                    [
                        'label' => 'Historial',
                        'icon' => 'calendar-check-o',
                        'url' => ['//envio/indexmensajero'],
                        'visible' => $rol ==3,
                    ],
                    
                    [
                        'label' => 'Pagos',
                        'icon' => 'money',
                        'url' => ['user/perfil#transferencia'],
                        'visible' => $rol ==3,
                    ],
                      ['label' => 'Soporte', 
                      'icon' => 'life-ring', 
                      'visible' => $rol ==3,  
                      'url' => ['site/soporte'],
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
                        'url' => ['/user/perfil'],                        
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
     background: transparent !important;
    }
    
    .skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
        border-left-color: #F7931E !important;
    }
</style>