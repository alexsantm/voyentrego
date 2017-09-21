<?php

namespace app\modules\api\controllers;
use app\modules\api\models\User;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        print_r("Esta es una prueba del api"); exit;
        return $this->render('index');
    }
    
     public function actionCreateuser()
    {
//        print_r("Desde aqui se crean los usuarios"); exit;
//        return $this->render('index');
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $usuarios = new User();
        $usuarios->scenario= User::SCENARIO_CREATE;
        $usuarios->attributes= \Yii::$app->request->post();
        if($usuarios->validate()){
          return array('status'=>true);  
        }
        else{
            return array('status'=>false, 'data'=>$usuarios->getErrors() );  
        }

    }

}
