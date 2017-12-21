<?php

namespace app\controllers;

use Yii;
use app\models\StatusMensajero;
use app\models\StatusMensajeroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StatusMensajeroController implements the CRUD actions for StatusMensajero model.
 */
class StatusMensajeroController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StatusMensajero models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusMensajeroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatusMensajero model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StatusMensajero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StatusMensajero();

        if ($model->load(Yii::$app->request->post())) {
/********************************************************************************************************/
            $post = Yii::$app->request->post();
            $codigo_promo = $post['StatusMensajero']['icono'];            
            
          $image = UploadedFile::getInstance($model, 'icono');
           if (!is_null($image)) {
             $model->icono = $image->name;
             //$ext = end((explode(".", $image->name)));
            $tmp = explode('.', $image->name);
             $ext = end($tmp);
			 			 
              // generate a unique file name to prevent duplicate filenames
              $model->icono = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/markers/estados_mensajeros/';
              $path = Yii::$app->params['uploadPath'] . $model->icono;
               $image->saveAs($path);
            }
            $model->save();
/********************************************************************************************************/
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StatusMensajero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
    
        public function actionUpdate($id) {
        $model=$this->findModel($id);
        $maximo = 1000;
        $path = $model->icono;
          if ($model->load(Yii::$app->request->post())) {   //Envio la informacion actualizada   
                $model->icono = UploadedFile::getInstance($model, 'icono');
                $ext = substr(strrchr($model->icono,'.'),1);
            if((empty($model->icono))){
                $model->icono    = $path;
            }else{
                $model->icono = UploadedFile::getInstance($model, 'icono');
                $newfname = mt_rand(1, $maximo)."_".$model->icono;
                $model->icono->saveAs(Yii::getAlias('@webroot').'/images/markers/estados_mensajeros/'.$model->icono = $newfname);   //Cambiar la carpeta de los archivos rar             
            }
            
            $model->save();
            if($model->save()) {
                ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Tus opciones han sido actualizadas');  ?><?php  
                return $this->redirect(['index']);
            }  
             else{
              print_r("Error de validación"); echo("<br>");
             $errores = $model->getErrors();
             var_dump($model->errors);
             die();
          } 
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StatusMensajero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StatusMensajero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatusMensajero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatusMensajero::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
