<?php

namespace app\controllers;

use Yii;
use app\models\Envio;
use app\models\EnvioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * EnvioController implements the CRUD actions for Envio model.
 */
class EnvioController extends Controller
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
     * Lists all Envio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EnvioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Envio model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }
    
        public function actionView($id)
    {
        $origen = \app\models\Envio::findOne($id); 
        $destinos = \app\models\Destino::find()->where(['envio_id'=>$id])->asArray()->all();     
//        print_r($destinos);
        
        $searchModel = new \app\models\DestinoSearch();
        $searchModel->envio_id = $id;
        $dataProvider = $searchModel->searchdestinos(Yii::$app->request->queryParams);
        
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'origen'=>$origen,
            'destinos'=>$destinos,
            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
         public function actionViewrec($id)
    {
        $origen = \app\models\Envio::findOne($id); 
        $destinos = \app\models\Destino::find()->where(['envio_id'=>$id])->asArray()->all();     
//        print_r($destinos);
        
        $searchModel = new \app\models\DestinoSearch();
        $searchModel->envio_id = $id;
        $dataProvider = $searchModel->searchdestinos(Yii::$app->request->queryParams);
        
        
        return $this->render('viewrec', [
            'model' => $this->findModel($id),
            'origen'=>$origen,
            'destinos'=>$destinos,
            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Envio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Envio();
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
        $model = new Envio();
        $connection = \Yii::$app->db;
        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {            
            try{
            $transaction = $connection->beginTransaction(); 
                $post=Yii::$app->request->post();                    
                $latitud = $post['Envio']['latitude'];	
                $longitud = $post['Envio']['longitude'];
                $model->latitud= $latitud;
                $model->longitud= $longitud;                    
                $model->save();                 
            $transaction->commit();           
            }catch(\Exception $e)
            {
                $transaction::rollback();
                 throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(['index']);      
             
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateprog()
    {
        $model = new Envio();
        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {
            
            try{
            $transaction = $connection->beginTransaction(); 
                $post=Yii::$app->request->post();                    
                $latitud = $post['Envio']['latitude'];	
                $longitud = $post['Envio']['longitude'];
                $model->latitud= $latitud;
                $model->longitud= $longitud;                    
                $model->save();                 
            $transaction->commit();           
            }catch(\Exception $e)
            {
                $transaction::rollback();
                 throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(['index']);      
             
        } else {
            return $this->render('createprog', [
                'model' => $model,
            ]);
        }
    }
       public function actionCreaterec()
    {
        $model = new Envio();
        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {
        /*****************************************************************/
            $post=Yii::$app->request->post();           
            $fecha_desde =$post['fecha_desde'];
            $fecha_hasta =$post['fecha_hasta'];
            $dias = $post['dias'];
            
            $fechaInicio=strtotime($fecha_desde);
            $fechaFin=strtotime($fecha_hasta);

            $days = array('1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday');
            foreach($dias as $dia){                
                for($i = strtotime($days[$dia], $fechaInicio); $i <= $fechaFin; $i = strtotime('+1 week', $i)){
                    $fechas[] = date('Y-m-d', $i);                    
                }                
            }
        /*****************************************************************/                
            try{
            $transaction = $connection->beginTransaction(); 
                $ciudad_id = $post ['Envio']['ciudad_id'];
                $user_id = $post['Envio']['user_id'];
                $remitente = $post['Envio']['remitente'];
                $direccion_origen = $post['Envio']['direccion_origen'];
                $latitud = $post['Envio']['latitude'];	
                $longitud = $post['Envio']['longitude'];
                $celular = $post['Envio']['celular'];
                $observacion = $post['Envio']['observacion'];
                $tipo_envio_id = $post['Envio']['tipo_envio_id'];
                $dimensiones_id = $post['Envio']['dimensiones_id'];

                $cont = 0;
                 while($cont < count($fechas)){
                     $envio = new Envio;
                     $envio->ciudad_id = $ciudad_id;
                     $envio->user_id = $user_id;
                     $envio->remitente = $remitente;
                     $envio->direccion_origen = $direccion_origen;
                        $envio->latitud= $latitud;
                        $envio->longitud= $longitud;     
                     $envio->celular = $celular;
                     $envio->observacion = $observacion;
                     $envio->estado_envio_id = 1;
                     $envio->tipo_envio_id = $tipo_envio_id;
                     $envio->dimensiones_id = $dimensiones_id;
                     $envio->fecha_registro = $fechas[$cont];
                     $envio->save();                     
                     $array_envio[]=$envio;
                     $array_id[]=$envio->id;
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

//            Extraigo el primer elemento del array $envio para sacar la id y renderizar
            $id_primer_elemento = $array_envio[0] ['id'];
            return $this->redirect(['viewrec', 'id' => $id_primer_elemento, 'fechas'=>$fechas, 'array_id'=>$array_id ]); 
            
        } else {
            return $this->render('createrec', [
                'model' => $model,
            ]);
        }
    }
    
    
    public function actionDetalles()
    {
        $dist_origen_primer_punto = Yii::$app->request->get('dist_origen_primer_punto');
        $dist_resto_puntos=Yii::$app->request->get('dist_resto_puntos');
        $valor_distancia_retornos =Yii::$app->request->get('valor_distancia_retornos');
        $valor_distancia_retorno_inicio =Yii::$app->request->get('valor_distancia_retorno_inicio');
        $total  =Yii::$app->request->get('total');
        $valor_km =      Yii::$app->request->get('valor_km'); 
        $latitud_origen =      Yii::$app->request->get('latitud_origen'); 
        $longitud_origen =      Yii::$app->request->get('longitud_origen'); 
        
        //Traigo los ultimos registros por cada mensajero (si hay varios registros traera el mas actual)
        $mensajeros = (new \yii\db\Query())
        ->select(['t1.id', 't1.user_id', 't1.longitud', 't1.latitud', 't1.fecha'])
        ->from('tracking t1')
        ->where('t1.fecha = (SELECT MAX(t2.fecha)FROM tracking t2 WHERE t2.user_id = t1.user_id)')
        ->all();
        
        $r = \app\models\Opciones::find()->select('radio')->asArray()->one();
        $radio = $r['radio'];
        return $this->render('detalles', [
            'dist_origen_primer_punto'=>$dist_origen_primer_punto,
            'dist_resto_puntos'=>$dist_resto_puntos,
            'valor_distancia_retornos'=>$valor_distancia_retornos,
            'valor_distancia_retorno_inicio'=>$valor_distancia_retorno_inicio,
            'total'=>$total,
            'valor_km'=>$valor_km,   
            'latitud_origen'=>$latitud_origen,
            'longitud_origen'=>$longitud_origen,
            'mensajeros' => $mensajeros,
            'radio' => $radio,
        ]);
    }
   

    /**
     * Updates an existing Envio model.
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
    
//        public function actionUpdate($id)
//    {
//       $model = $this->findModel($id);       
//        $connection = \Yii::$app->db;
//        $model->fecha_registro = date("Y-m-d H:i");
//        $model->estado_envio_id = 1;
//        if ($model->load(Yii::$app->request->post())) {    
//           
//            try{
//            $transaction = $connection->beginTransaction();        
////             print_r($model);die();
//                $model->save(); 
////                if(!$model->save()){
////                    print_r($model->errors); die();
////                }                
//            $transaction->commit();           
//            }catch(\Exception $e)
//            {
//                $error=$e->getMessage();
//                print_r($error); die();
//                $transaction::rollback();
//                 throw $e;                
//            }
//            //return $this->redirect(['view', 'id' => $model->id]);
////            return $this->redirect(Yii::$app->request->referrer);
//            return $this->redirect(['index']);                  
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
         public function actionUpdate($id)
    {
        $model = $this->findModel($id);     
        $connection = \Yii::$app->db;
        $model->fecha_registro = date("Y-m-d H:i");
        $model->estado_envio_id = 1;
        if ($model->load(Yii::$app->request->post())) {            
            try{
            $transaction = $connection->beginTransaction(); 
                $post=Yii::$app->request->post();                    
                $latitud = $post['Envio']['latitude'];	
                $longitud = $post['Envio']['longitude'];
                $model->latitud= $latitud;
                $model->longitud= $longitud;                    
                $model->save();                 
            $transaction->commit();           
            }catch(\Exception $e)
            {
                $transaction::rollback();
                 throw $e;
            }
            return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(['index']);      
             
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Envio model.
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
     * Finds the Envio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Envio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Envio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
