<?php

namespace app\modules\api\controllers;
use app\modules\api\models\Ciudad;

class CiudadController extends \yii\web\Controller
{
    public $enableCsrfValidation= false;
    
    public function actionIndex()
    {
//        print_r("Esta es una prueba del api"); exit;
        return $this->render('index');
    }
    

    
     public function actionCreateciudad()
    {
//        print_r("Desde aqui se crean los usuarios"); exit;
//        return $this->render('index');
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ciudad = new Ciudad();
        $ciudad->scenario= Ciudad::SCENARIO_CREATE;
        $ciudad->attributes= \Yii::$app->request->post();
        if($ciudad->validate()){
            $ciudad->save();
          return array('status'=>true, 'data'=>'ciudad creada correctamente');  
        }
        else{
            return array('status'=>false, 'data'=>$ciudad->getErrors() );  
        }

    }
    
         public function actionListarciudad()
    {
//        print_r("Desde aqui se crean los usuarios"); exit;
//        return $this->render('index');
        \Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
        $ciudad = Ciudad::find()->all();

         if(count($ciudad)>0){            
            return array('status'=>true, 'data'=>$ciudad);  
        }
        else{
            return array('status'=>false, 'data'=>'No hay ciudades' );  
        }

    }

}
