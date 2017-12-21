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
use kartik\mpdf\Pdf;

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
            
            
            //****************************************** Datos Factura **********************************/
          $post = Yii::$app->request->post();  
          $user_id = $model->attributes['user_id'];
          $valor = $post['RecargaTransferencia']['valor'];
          $consulta_perfil = \app\models\Profile::find()->where(['user_id'=>$user_id])->asArray()->all();
          $consulta = \app\models\User::find()->select(['email'])->where(['id'=>$user_id])->asArray()->one();
          $correo = $consulta['email'];
          foreach($consulta_perfil as $c){
            $nombre =      $c['full_name']; 
            $cedula =      $c['cedula']; 
            $direccion =   $c['direccion']; 
            $telefono =    $c['telefono']; 
            $email =       $correo; 
          }
        if(empty($nombre) || empty($cedula) || empty($direccion) || empty($telefono) || empty($email))
    {
                    ?><?php
                    Yii::$app->session->setFlash('danger',
                    '<h4>ERROR EN LOS DATOS DE FACTURACION</h4>'
                    . 'Revise los siguientes campos:<br>'
                    . '<li>Nombre</li>'
                    . '<li>Cédula</li>'
                    . '<li>Dirección</li>'
                    . '<li>Teléfono</li>'
                    . '<li>Email</li>'
                    . 'Complete la información en MI PERFIL y vuelva a intentarlo'); ?><?php  
                    return $this->redirect(Yii::$app->request->referrer); 
    }
            //****************************************** Fin Datos Factura **********************************/
            
            $post = Yii::$app->request->post();
            $codigo_promo = $post['RecargaTransferencia']['codigo_promocion'];            
            
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
//            $codigo_promo = $model->codigo_promocion;

            if(!empty($codigo_promo)){
                $promocion = $model->calculo_promocion($valor, $codigo_promo);
                $model->valor_promo = $promocion;
//                echo("promocion"); print_r($model->valor_promo); die();
                if(!empty($model->valor_promo)){
                                    $model->save();
                                    if ($model->save()) {             
                                         ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Se ha añadido una promoción a su recarga');  ?><?php  
//                                        return $this->redirect(Yii::$app->request->referrer); 
                                        return $this->render('detallefactura', [
                                            'nombre'=>$nombre, 
                                            'cedula'=>$cedula, 
                                            'direccion'=>$direccion,   
                                            'telefono'=>$telefono,   
                                            'email'=>$email,   
                                            'valor'=>$valor,   
                                        ]);
                                    }  
                                    else {
                                        var_dump ($model->getErrors()); die();
                                    }
                }
                else{
                                     $model->save();
                                    if ($model->save()) {             
//                                        return $this->redirect(Yii::$app->request->referrer); 
                                        return $this->render('detallefactura', [
                                            'nombre'=>$nombre, 
                                            'cedula'=>$cedula, 
                                            'direccion'=>$direccion,   
                                            'telefono'=>$telefono,   
                                            'email'=>$email,   
                                            'valor'=>$valor,   
                                        ]);
                                    }  
                                    else {
                                        var_dump ($model->getErrors()); die();
                                    }
                }
            }
            else{
                $model->valor_promo = 0;                
                                    $model->save();
                                    if ($model->save()) {             
                                         ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Recarga realizada con éxito');  ?><?php                                           
//                                        return $this->redirect(Yii::$app->request->referrer); 
                                        return $this->render('detallefactura', [
                                            'nombre'=>$nombre, 
                                            'cedula'=>$cedula, 
                                            'direccion'=>$direccion,   
                                            'telefono'=>$telefono,   
                                            'email'=>$email,   
                                            'valor'=>$valor,   
                                        ]);
                                    }  
                                    else {
                                        var_dump ($model->getErrors()); die();
                                    }
            }
            
            /*****************************************************************/      
//            $model->save();
//            if ($model->save()) {             
//                 ?><?php // Yii::$app->session->setFlash('success', 'BIEN HECHO: Recarga realizada con éxito');  ?><?php  
//                return $this->redirect(Yii::$app->request->referrer); 
//            }  
//            else {
//                var_dump ($model->getErrors()); die();
//            }
        }    
              return $this->renderAjax('create', [
                  'model' => $model,
              ]);     
    } 
    
    
         public function actionCreateplan()
    {
        $model = new RecargaTransferencia();                        
//        $model->scenario = 'recarga_plan';
        $model->fecha = date("Y-m-d H:i");
        $model->estado_id = 2; 
        
        
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }
        $model->attributes = \Yii::$app->request->post('RecargaTransferencia');
        if ($model->load(Yii::$app->request->post())) {
            
            //****************************************** Datos Factura **********************************/
          $post = Yii::$app->request->post();  
          $user_id = $model->attributes['user_id'];
          $valor = $post['RecargaTransferencia']['valor'];
          $consulta_perfil = \app\models\Profile::find()->where(['user_id'=>$user_id])->asArray()->all();
          $consulta = \app\models\User::find()->select(['email'])->where(['id'=>$user_id])->asArray()->one();
          $correo = $consulta['email'];
          foreach($consulta_perfil as $c){
            $nombre =      $c['full_name']; 
            $cedula =      $c['cedula']; 
            $direccion =   $c['direccion']; 
            $telefono =    $c['telefono']; 
            $email =       $correo; 
          }
        if(empty($nombre) || empty($cedula) || empty($direccion) || empty($telefono) || empty($email))
    {
                    ?><?php
                    Yii::$app->session->setFlash('danger',
                    '<h4>ERROR EN LOS DATOS DE FACTURACION</h4>'
                    . 'Revise los siguientes campos:<br>'
                    . '<li>Nombre</li>'
                    . '<li>Cédula</li>'
                    . '<li>Dirección</li>'
                    . '<li>Teléfono</li>'
                    . '<li>Email</li>'
                    . 'Complete la información en MI PERFIL y vuelva a intentarlo'); ?><?php  
                    return $this->redirect(Yii::$app->request->referrer); 
    }
            //****************************************** Fin Datos Factura **********************************/
            
            $post = Yii::$app->request->post();
//            $codigo_promo = $post['RecargaTransferencia']['codigo_promocion'];  
            $codigo_valor_plan = $post['RecargaTransferencia']['plan'];
            $query = \app\models\PlanesRecarga::find(['valor', 'valor_promo'])->where(['id'=>$codigo_valor_plan])->asArray()->one();
            $valor_plan = $query['valor'];
            $valor_promo = $query['valor_promo'];

            /*****************************************************************/
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
            $model->valor = $valor_plan;
            $model->valor_promo = $valor_promo;
            if((!empty($valor_plan)) && (!empty($model->valor))){                
                                    $model->save();
                                    if ($model->save()) {             
                                         ?><?= Yii::$app->session->setFlash('success', 'BIEN HECHO: Tu plan ha sido registrado correctamente');  ?><?php  
//                                        return $this->redirect(Yii::$app->request->referrer); 
                                        return $this->render('detallefactura', [
                                            'nombre'=>$nombre, 
                                            'cedula'=>$cedula, 
                                            'direccion'=>$direccion,   
                                            'telefono'=>$telefono,   
                                            'email'=>$email,   
                                            'valor'=>$valor,   
                                        ]);
                                    }  
                                    else {
                                        var_dump ($model->getErrors()); die();
                                    }
              
            }
            else{
                ?><?= Yii::$app->session->setFlash('danger', 'ERROR: Uno o mas valores se encuentran vacios');  ?><?php                                           
                return $this->redirect(Yii::$app->request->referrer); 
            }
        }    
              return $this->renderAjax('createplan', [
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
 /***************************************************************************************************************************/   
      public function actionDetalleFactura()
    {
        return $this->redirect(['detallefactura']);
    }
    
            public function actionFactura() {
    $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $this->renderPartial('factura'),
            'options' => [
                'title' => 'Factura',
                'subject' => 'Factura Generada por VoyEntrego'
            ],
            'methods' => [
                'SetHeader' => ['Generada por VoyEntrego||Fecha: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

}
