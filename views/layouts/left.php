<?php
use yii\helpers\Html;

$user = Yii::$app->user->identity;
$profile = Yii::$app->user->identity->profile;


use kartik\sidenav\SideNav;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
<!--        <div class="user-panel">
            <div class="pull-left image">-->
                <!--<img src="<? $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>-->
                 <?php 
//                 if(!empty($profile->foto)){
//                                    echo Html::img('@web/fotos/'.$profile->foto, ['class' => 'user-image']); 
//                                }
//                                else{
//                                    echo Html::img('@web/fotos/default.jpg', ['class' => 'user-image']);
//                                }
                ?>
<!--            </div>
            <div class="pull-left info">
                <p><?php // echo $profile->full_name;?></p>
            </div>
        </div>-->

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

<?php
echo SideNav::widget([
	'type' => SideNav::TYPE_WARNING,
//	'heading' => 'Menú Principal',
	'items' => [
		[
			'url' => '#',
			'label' => 'Nuevo Envío',
			'icon' => 'home'
		],
                [
			'url' => '#',
			'label' => 'Rastrear',
			'icon' => 'home'
		],
                [
			'url' => '#',
			'label' => 'Registro',
			'icon' => 'home'
		],
                 [
			'url' => '#',
			'label' => 'Estadísticas',
			'icon' => 'home'
		],
//                 [
//			'url' => '#',
//			'label' => 'Home tres',
//			'icon' => 'Registro'
//		],
		[
			'label' => 'Help',
			'icon' => 'question-sign',
			'items' => [
				['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
				['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
			],
		],
	],
]);

?>
        <?php
//        echo dmstr\widgets\Menu::widget(
//            [
//                'options' => ['class' => 'sidebar-menu'],
//                'items' => [
//                    ['label' => 'Menu Principal', 'options' => ['class' => 'header']],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['#']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['#']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => 'Same tools',
//                        'icon' => 'share',
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
//                ],
//            ]
//        ) 
        ?>

    </section>

</aside>
