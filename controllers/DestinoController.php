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
//                if(!$model->save()){
//                    print_r($model->errors); die();
//                }                
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
            
        $model = new Destino();
        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {    
            $post=Yii::$app->request->post(); 
//                print_r(Yii::$app->request->get('fechas')); die();
                $fechas = Yii::$app->request->get('fechas');
                $array_id = Yii::$app->request->get('array_id');
             try{
            $transaction = $connection->beginTransaction(); 
//            print_r($post); die();
                $ciudad_id = $post ['Destino']['ciudad_id'];
                $direccion_destino = $post['Destino']['direccion_destino'];
                $destinatario = $post['Destino']['destinatario'];
                $celular = $post['Destino']['celular'];
                $tipo_envio_id = $post['Destino']['tipo_envio_id'];
                $dimensiones_id = $post['Destino']['dimensiones_id'];
                $retorno_destino_id = $post['Destino']['retorno_destino_id'];
                $retorno_inicio = $post['Destino']['retorno_inicio'];
                $observacion = $post['Destino']['observacion'];
                //$envio_id
                $latitud = $post['Destino']['latitud'];	
                $longitud = $post['Destino']['longitud'];
                
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
//                     $array_id[]=$envio->id;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Destino Actualizado Correctamente');  ?><?php  
//             return $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['/envio/view', 'id' => $model->envio_id]);
        } else {
            return $this->render('update', [
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
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
//        return $this->redirect(['index']);
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
