<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <?php
//******************************************************************************************************************************   
//    Esta plantilla esta modificada para que los formulario de login, register y sign-in puedan mostrarse sin header ni navbar
//    La plantilla original esta en main_old.php
//******************************************************************************************************************************
        use yii\helpers\Html;

        /* @var $this \yii\web\View */
        /* @var $content string */


        if (Yii::$app->controller->action->id === 'login') { 
            echo $this->render(
                'main-login',
                ['content' => $content]
            );
        }    
   else if (Yii::$app->controller->action->id === 'sign-in') { 
                echo $this->render(
                    'main-login',
                    ['content' => $content]
                );
            }
  else if (Yii::$app->controller->action->id === 'register') { 
                echo $this->render(
                    'main-login',
                    ['content' => $content]
                );
            }            
    else if (Yii::$app->controller->action->id === 'forgot') { 
                echo $this->render(
                    'main-login',
                    ['content' => $content]
                );
            }          
    else if (Yii::$app->controller->action->id === 'resend') { 
                echo $this->render(
                    'main-login',
                    ['content' => $content]
                );
            }         
   else {

            if (class_exists('backend\assets\AppAsset')) {
                backend\assets\AppAsset::register($this);
            } else {
                app\assets\AppAsset::register($this);
            }

            dmstr\web\AdminLteAsset::register($this);

            $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
            ?>
            <?php $this->beginPage() ?>
            <!DOCTYPE html>
            <html lang="<?= Yii::$app->language ?>">
            <head>
                <meta charset="<?= Yii::$app->charset ?>"/>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <?= Html::csrfMetaTags() ?>
                <title><?= Html::encode($this->title) ?></title>
                <?php $this->head() ?>
            </head>
            <body class="hold-transition skin-blue sidebar-mini">
            <?php $this->beginBody() ?>
            <div class="wrapper">

                <?= $this->render(
                    'header.php',
                    ['directoryAsset' => $directoryAsset]
                ) ?>

                <?= $this->render(
                    'left.php',
                    ['directoryAsset' => $directoryAsset]
                )
                ?>

                <?= $this->render(
                    'content.php',
                    ['content' => $content, 'directoryAsset' => $directoryAsset]
                ) ?>

            </div>

            <?php $this->endBody() ?>
            </body>
            </html>
            <?php $this->endPage() ?>
        <?php } ?>
