<?php

namespace app\controllers;

use Yii;
use app\models\RecargaTransferencia;
use app\models\RecargaTransferenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;

//use yii\web\Response; // Add This line
//use yii\widgets\ActiveForm; //Add This Line

/**
 * RecargaTransferenciaController implements the CRUD actions for RecargaTransferencia model.
 */
class RecargaTransferenciaController extends Controller
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
     * Lists all RecargaTransferencia models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new RecargaTransferenciaSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    
     public function actionIndex()
    {
        $searchModel = new RecargaTransferenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
//            print_r(Yii::$app->request->post()); die(); 
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['RecargaTransferencia']);
            $post['RecargaTransferencia'] = $posted;

            // Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false                 
                $model->save();
//                  if($model->save()){
//                    print_r("si guardo");
//                    die();
//                }
//                else{
//                    print_r($model->errors); die();
//                }
                
                if (isset($posted['valor'])) {
                    $output = $model->valor;
                }
                if (isset($posted['estado_id'])) {
                    $output = $model->estado_id;
                    $consulta = \app\models\Recarga::find()->where(['user_id' => $model->user_id])->one();
                    if(empty($consulta)){
                            $fecha = date("Y-m-d H:i");
                            $connection = Yii::$app->getDb();
                            $command = $connection->createCommand('                                   
                            INSERT INTO recarga (valor_recarga, user_id, fecha)
                                values ("'.$model->valor.'",'.$model->user_id.', "'.$fecha.'")
                            ');                   
                            $resultado = $command->execute();
                    }
                    else{
//                        $valor = $consulta['valor_recarga'];
//                        $valor = $valor + $model->valor;
//                        \app\models\Recarga::updateAll(['valor_recarga' => $valor], 'user_id = '. "'".$model->user_id."'" );
                        
                        $valor_promo = $model->valor_promo;
                        $valor_recarga = $model->valor;
                        $valor_total_recarga_transf = $valor_recarga + $valor_promo;
                        
                        $valor_recarga = $consulta['valor_recarga'];
                        //$valor = $valor + $model->valor;
                        $valor_recarga = $valor_recarga + $valor_total_recarga_transf;
                        \app\models\Recarga::updateAll(['valor_recarga' => $valor_recarga], 'user_id = '. "'".$model->user_id."'" );                        
                    }                    
//                    $output = $model->estado_id;
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
                //$out = Json::encode(['output' => $output, 'message' => 'Actualizado']);
            }
            // Return AJAX JSON encoded response and exit
            echo $out;
            return $this->redirect(['index']);
//            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single RecargaTransferencia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RecargaTransferencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new RecargaTransferencia();
//                
//        $model->fecha = date("Y-m-d H:i");
//        $model->estado_id = 2;
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->renderAjax('create', [
//                'model' => $model
//            ]);
//        }
//    }
    
    
     public function actionCreate()
    {
        $model = new RecargaTransferencia();                
        $model->fecha = date("Y-m-d H:i");
        $model->estado_id = 2;
        
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }


        $model->attributes = \Yii::$app->request->post('RecargaTransferencia');
        if ($model->load(Yii::$app->request->post())) {
//            print_r("envio datos"); die();
          $image = UploadedFile::getInstance($model, 'doc_referencia');
           if (!is_null($image)) {
             $model->doc_referencia = $image->name;
             //$ext = end((explode(".", $image->name)));
            $tmp = explode('.', $image->name);
             $ext = end($tmp);
			 			 
              // generate a unique file name to prevent duplicate filenames
              $model->doc_referencia = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/transferencias/';
              $path = Yii::$app->params['uploadPath'] . $model->doc_referencia;
               $image->saveAs($path);
            }
            /*****************************************************************/
            $valor=$model->valor;
            $codigo_promo = $model->codigo_promocion;
            $promocion = $model->calculo_promocion($valor, $codigo_promo);
            $model->valor_promo = $promocion;
            
            /*****************************************************************/      
            $model->save();
            if ($model->save()) {             
//                print_r("guardo"); die();
//                return $this->redirect(['view', 'id' => $model->id]);   
                 ?><?=Yii::$app->session->setFlash('success', 'BIEN HECHO: Recarga realizada con éxito');  ?><?php  
                return $this->redirect(Yii::$app->request->referrer); 
            }  
            else {
                var_dump ($model->getErrors()); die();
            }
        }
    
              return $this->renderAjax('create', [
                  'model' => $model,
              ]);     
    } 


    /**
     * Updates an existing RecargaTransferencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RecargaTransferencia model.
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
     * Finds the RecargaTransferencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecargaTransferencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecargaTransferencia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
//      public function actionCreate()
//    {
//        
//        $model = new VentasDistribuidores();
//        $model->fecha = date("Y-m-d H:i"); 
////        $model->file = UploadedFile::getInstance($model, 'file');
//        
//         if ($model->load(Yii::$app->request->post())) {
//        $model->file = UploadedFile::getInstance($model, 'file');
////        $ext = substr(strrchr($model->file, '.'), 1);     //duplica la extension
//                if ($model->validate()) {
////                     if ($ext != null) {
////                        $newfname = $model->file . '.' . $ext;
//                         $newfname = $model->file;
//                        $model->file->saveAs(Yii::getAlias('@webroot') . '/archivosventas/' . $model->file = $newfname);  
//                         $model->save();
//                        return $this->redirect(['view', 'id' => $model->id]);
////                    }
////                        $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);                       
//                }
//        }
//            else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
}
