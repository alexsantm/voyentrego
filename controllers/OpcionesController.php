<?php

namespace app\controllers;

use Yii;
use app\models\Opciones;
use app\models\OpcionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\mpdf\Pdf;


/**
 * OpcionesController implements the CRUD actions for Opciones model.
 */
class OpcionesController extends Controller
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
     * Lists all Opciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OpcionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        
         if (Yii::$app->request->post('hasEditable')) {
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['Opciones']);
            $post['Opciones'] = $posted;

            // Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false
                $model->save();
                if (isset($posted['radio'])) {
                    $output = $model->radio;
                }
                if (isset($posted['envios_tomados_por_dia'])) {
                    $output = $model->envios_tomados_por_dia;
                }
                if (isset($posted['tiempo_refresco'])) {
                    $output = $model->tiempo_refresco;
                }
                if (isset($posted['frec_almacenamiento_stand_by'])) {
                    $output = $model->frec_almacenamiento_stand_by;
                }
                if (isset($posted['frec_envio_stand_by'])) {
                    $output = $model->frec_envio_stand_by;
                }
                if (isset($posted['frec_almacenamiento_reparto'])) {
                    $output = $model->frec_almacenamiento_reparto;
                }
                if (isset($posted['frec_envio_reparto'])) {
                    $output = $model->frec_envio_reparto;
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // Return AJAX JSON encoded response and exit
            echo $out;
            return $this->redirect(['index']);
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Opciones model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
    
    public function actionView($id) {
        $model=$this->findModel($id);
        $maximo = 1000;
        $path = $model->foto_promocion;

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            Yii::$app->session->setFlash('kv-detail-success', 'Opciones actualizadas correctamente');
//            return $this->redirect(['view', 'id'=>$model->id]);
//        } 
        
          if ($model->load(Yii::$app->request->post())) {   //Envio la informacion actualizada   
                $model->foto_promocion = UploadedFile::getInstance($model, 'foto_promocion');
                $ext = substr(strrchr($model->foto_promocion,'.'),1);
            if((empty($model->foto_promocion))){
                $model->foto_promocion    = $path;
            }else{
                $model->foto_promocion = UploadedFile::getInstance($model, 'foto_promocion');
                $newfname = mt_rand(1, $maximo)."_".$model->foto_promocion;
                $model->foto_promocion->saveAs(Yii::getAlias('@webroot').'/images/promociones/'.$model->foto_promocion = $newfname);   //Cambiar la carpeta de los archivos rar             
            }
            
            $model->save();
            if($model->save()) {
                ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Tus opciones han sido actualizadas');  ?><?php  
                return $this->redirect(['view', 'id'=>$model->id]);
            }  
             else{
              print_r("Error de validación"); echo("<br>");
             $errores = $model->getErrors();
             var_dump($model->errors);
             die();
          } 
        }
        
        
        
        else {
            return $this->render('view', ['model'=>$model]);
        }
    }

    /**
     * Creates a new Opciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Opciones();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
    
    
     public function actionCreate()
    {
        $model = new Opciones();                
        $model->attributes = \Yii::$app->request->post('Opciones');
        if ($model->load(Yii::$app->request->post())) {            
            $post = Yii::$app->request->post();           
            $image = UploadedFile::getInstance($model, 'doc_referencia');
            if (!is_null($image)) {
                    $model->foto_promocion = $image->name;
                    //$ext = end((explode(".", $image->name)));
                   $tmp = explode('.', $image->name);
                    $ext = end($tmp);

                     // generate a unique file name to prevent duplicate filenames
                     $model->foto_promocion = Yii::$app->security->generateRandomString().".{$ext}";
                     // the path to save file, you can set an uploadPath
                     // in Yii::$app->params (as used in example below)                       
                     Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/promociones/';
                     $path = Yii::$app->params['uploadPath'] . $model->foto_promocion;
                      $image->saveAs($path);
            }
            $model->save();
            if ($model->save()) {             
                                         ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Opciones creadas con exito');  ?><?php  
                                        return $this->redirect(Yii::$app->request->referrer); 
                                    }  
                                    else {
                                        var_dump ($model->getErrors()); die();
                                    }
            /*****************************************************************/
        }    
              return $this->renderAjax('create', [
                  'model' => $model,
              ]);     
    } 

    /**
     * Updates an existing Opciones model.
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
    
            public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $maximo = 1000;
        $path = $model->foto_promocion;
        if ($model->load(Yii::$app->request->post())) {   //Envio la informacion actualizada   
                $model->foto_promocion = UploadedFile::getInstance($model, 'foto_promocion');
                $ext = substr(strrchr($model->foto_promocion,'.'),1);
            if((empty($model->foto_promocion))){
                $model->foto_promocion    = $path;
            }else{
                $model->foto_promocion = UploadedFile::getInstance($model, 'foto_promocion');
                $newfname = mt_rand(1, $maximo)."_".$model->foto_promocion;
                $model->foto_promocion->saveAs(Yii::getAlias('@webroot').'/images/promociones/'.$model->foto_promocion = $newfname);   //Cambiar la carpeta de los archivos rar             
            }
            
            $model->save();
            if($model->save()) {
                ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Tus opciones han sido actualizadas');  ?><?php  
                return $this->redirect(Yii::$app->request->referrer); 
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
     * Deletes an existing Opciones model.
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
     * Finds the Opciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Opciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Opciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
