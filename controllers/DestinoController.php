<?php

namespace app\controllers;

use Yii;
use app\models\Destino;
use app\models\DestinoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinoController implements the CRUD actions for Destino model.
 */
class DestinoController extends Controller
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
     * Lists all Destino models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DestinoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Destino model.
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
     * Creates a new Destino model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Destino();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            //return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(Yii::$app->request->referrer);
//        } else {
//            return $this->renderAjax('create', [
//                'model' => $model,
//            ]);
//        }
//    }
        public function actionCreate()
    {
        $model = new Destino();
        $connection = \Yii::$app->db;
        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {            
            try{
            $transaction = $connection->beginTransaction();                  
                $model->save();               
            $transaction->commit();           
            }catch(\Exception $e)
            {
                $error=$e->getMessage();
                $transaction::rollback();
                 throw $e;                
            }
            //return $this->redirect(['view', 'id' => $model->id]);
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado un nuevo Destino satisfactoriamente');  ?><?php  
            return $this->redirect(Yii::$app->request->referrer);
//            return $this->redirect(['index']);                  
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
        public function actionCreaterec()
    {
//            print_r("createrec"); die();
        $model = new Destino();
        $connection = \Yii::$app->db;
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {    
            $post=Yii::$app->request->post(); 
            $fechas = Yii::$app->request->get('fechas');
            $array_id = Yii::$app->request->get('array_id');
//            print_r($post); echo('<br>');
//            print_r($fechas); echo('<br>');
//            die();
            try{
            $transaction = $connection->beginTransaction();                
                $ciudad_id = $post ['Destino']['ciudad_id'];
                $direccion_destino = $post['Destino']['direccion_destino'];
                $destinatario = $post['Destino']['destinatario'];
                $celular = $post['Destino']['celular'];
                $tipo_envio_id = $post['Destino']['tipo_envio_id'];
                $dimensiones_id = $post['Destino']['dimensiones_id'];
                $retorno_destino_id = $post['Destino']['retorno_destino_id'];
                $retorno_inicio = $post['Destino']['retorno_inicio'];
                $observacion = $post['Destino']['observacion'];
                $latitud = $post['Destino']['latitud'];	
                $longitud = $post['Destino']['longitud'];
                $kilometros = $post['Destino']['kilometros'];
                $valor = $post['Destino']['valor'];
                
                $cont = 0;
                 while($cont < count($array_id)){
                     $destino = new Destino;
                     $destino->ciudad_id = $ciudad_id;
                     $destino->direccion_destino = $direccion_destino;
                     $destino->destinatario = $destinatario;
                     $destino->celular = $celular;
                     $destino->tipo_envio_id = $tipo_envio_id;
                     $destino->dimensiones_id = $dimensiones_id;
                     $destino->retorno_destino_id = $retorno_destino_id;
                     $destino->retorno_inicio = $retorno_inicio;
                     $destino->observacion = $observacion;
                        $destino->latitud= $latitud;
                        $destino->longitud= $longitud;     
                     $destino->estado_envio_id = 1;                     
                     $destino->envio_id = $array_id[$cont];                     
                     $destino->fecha_registro = $fechas[$cont];
                     $destino->save();                     
//                     $array_envio[]=$envio;
                     $array_dest_id[]=$destino->id;
                    $cont = $cont+1;
                }  
            $transaction->commit();
            }catch(\Exception $e)
            {
                $error=$e->getMessage();
                print_r($error);die();
                $transaction::rollback();
                throw $e;
            }
            //return $this->redirect(['view', 'id' => $model->id]);
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado un nuevo Destino satisfactoriamente');  ?><?php  
            return $this->redirect(Yii::$app->request->referrer);
            
//            return $this->redirect(['index']);      
             
        } else {
            return $this->renderAjax('createrec', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Destino model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);        

        if ($model->load(Yii::$app->request->post())) {            
            $post = Yii::$app->request->post();
            $destino_opc = $post['Destino']['destino_opc'];
            if($destino_opc ==1){
                $model->retorno_inicio = NULL;
                $model->retorno_destino_id = NULL;
            }            
            $model->save();            
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Destino Actualizado Correctamente');  ?><?php  
//             return $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['/envio/view', 'id' => $model->envio_id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdaterec($id)
    {
            $array_id = Yii::$app->request->get('array_id');
            $array_envio = Yii::$app->request->get('array_envio');
//            print_r($array_id); die();
            
        $model = $this->findModel($id);     
        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {  
             $post = Yii::$app->request->post();
            $destino_opc = $post['Destino']['destino_opc'];
            if($destino_opc ==1){
                $model->retorno_inicio = NULL;
                $model->retorno_destino_id = NULL;
            }
            try{
                $post=Yii::$app->request->post();
//                print_r($post); die();
                $transaction = $connection->beginTransaction(); 
                    $ciudad_id = $post ['Destino']['ciudad_id'];
                    $direccion_destino = $post['Destino']['direccion_destino'];
                    $destinatario = $post['Destino']['destinatario'];
                    $celular = $post['Destino']['celular'];
                    $tipo_envio_id = $post['Destino']['tipo_envio_id'];
                    $dimensiones_id = $post['Destino']['dimensiones_id'];
                    $retorno_destino_id = $post['Destino']['retorno_destino_id'];
                    $retorno_inicio = $post['Destino']['retorno_inicio'];
                    $observacion = $post['Destino']['observacion'];
                    $latitud = $post['Destino']['latitud'];	
                    $longitud = $post['Destino']['longitud'];
                    $kilometros = $post['Destino']['kilometros'];
                    $valor = $post['Destino']['valor'];
            foreach($array_id as $id){
                     $query = Destino::find()->where(['envio_id' => $id])->one();
                     $fecha_registro = $query['fecha_registro'];
                 Destino::updateAll([
                     'ciudad_id' => $ciudad_id,
                     'direccion_destino' => $direccion_destino,
                     'destinatario' => $destinatario,
                     'celular' => $celular,
                     'tipo_envio_id' => $tipo_envio_id,
                     'dimensiones_id' => $dimensiones_id,
                     'retorno_destino_id' => $retorno_destino_id,
                     'retorno_inicio' => $retorno_inicio,
                     'observacion' => $observacion,
                     'latitud' => $latitud,
                     'longitud' => $longitud,
                     'kilometros' => $kilometros,
                     'valor' => $valor,
                     'fecha_registro' => $fecha_registro,
                     ], 'envio_id = '. "'".$id."'" );   
            }  
                 
            $transaction->commit();
            }catch(\Exception $e)
            {
//                $transaction::rollback();
//                 throw $e;                 
                $error=$e->getMessage();
                print_r($error);die();
                $transaction::rollback();
                throw $e;
            }
            
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Datos de Envío Origen actualizados correctamente');  ?><?php  
            return $this->redirect(Yii::$app->request->referrer);
            //return $this->redirect(['viewrec', 'id' => $model->id]);
                         
        } else {
            return $this->renderAjax('updaterec', [
                'model' => $model,
            ]);
        }
    }
    
//    public function actionUpdate($id)
//    {
//       $model = $this->findModel($id);       
//        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
//        $model->estado_envio_id = 1;
//        if ($model->load(Yii::$app->request->post())) {                       
//            try{
//            $transaction = $connection->beginTransaction();        
//             print_r($model);die();
//                $model->save(); 
//                if(!$model->save()){
//                    print_r($model->errors); die();
//                }                
//            $transaction->commit();           
//            }catch(\Exception $e)
//            {
//                $error=$e->getMessage();
//                $transaction::rollback();
//                 throw $e;                
//            }
//            //return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(Yii::$app->request->referrer);
////            return $this->redirect(['index']);                  
//        } else {
//            return $this->renderAjax('update', [
//                'model' => $model,
//            ]);
//        }
//    }
    
    

    /**
     * Deletes an existing Destino model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        print_r("dekete"); die();
        $this->findModel($id)->delete();
        if(!empty(Yii::$app->request->get('array_id') && !empty(Yii::$app->request->get('direccion_destino')))){        
                $array_id = Yii::$app->request->get('array_id');
                $direccion_destino = Yii::$app->request->get('direccion_destino');
                foreach($array_id as $id){
                        \app\models\Destino::deleteAll(['envio_id' => $id, 'direccion_destino' => $direccion_destino]);
                }        
                ?><?php Yii::$app->session->setFlash('success', '<h3>Registros Eliminados Correctamente</h3>'); ?><?php  
                return $this->redirect(Yii::$app->request->referrer);
        }
        else{
            ?><?php Yii::$app->session->setFlash('success', '<h3>Registro Eliminado Correctamente</h3>'); ?><?php  
            return $this->redirect(Yii::$app->request->referrer); 
        }
//        return $this->redirect(['index']);
    }
    
        public function actionDeletesingle($id)
    {
        $this->findModel($id)->delete();
        ?><?php Yii::$app->session->setFlash('success', '<h3>Registro Eliminado Correctamente</h3>'); ?><?php  
        return $this->redirect(Yii::$app->request->referrer); 
    }

    /**
     * Finds the Destino model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Destino the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destino::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
