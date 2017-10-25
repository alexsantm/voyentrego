<?php

namespace app\controllers;

use Yii;
use app\models\Envio;
use app\models\EnvioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

use yii\web\UploadedFile;
use yii\helpers\Json;
use kartik\alert\Alert;

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
    
    
//    public function actionIndex()
//    {
//        $user_id = Yii::$app->user->identity['id'];
//        $searchModel = new EnvioSearch();
//        $searchModel->user_id = $user_id;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    
    
    public function actionIndex()
    {
//        $searchModel = new RecargaTransferenciaSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new EnvioSearch();
        $searchModel->user_id = $user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       
        
        if (Yii::$app->request->post('hasEditable')) {
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['Envio']);
            $post['Envio'] = $posted;

            if ($model->load($post)) {
       
                $query = \app\models\Envio::find()->where(['id'=>$_id])->asArray()->one();
                $mensajero_id = $query['mensajero_id'];
                $model->save();
                if (isset($posted['favorito'])) {
                    $output = $model->favorito;
                    if($posted['favorito'] == 'SI'){
                            $connection = Yii::$app->getDb();
                            $command = $connection->createCommand('                                   
                            INSERT INTO favoritos (user_id, mensajero_id)
                                values ("'.$user_id.'",'.$mensajero_id.')
                            ');                   
                            $resultado = $command->execute();
                    }else{
                        $query = \app\models\Favoritos::find()->where(['user_id'=>$user_id,'mensajero_id'=>$mensajero_id ])->asArray()->count();
                        if($query >0){
                            \app\models\Favoritos::deleteAll(['user_id' => $user_id, 'mensajero_id' => $mensajero_id]);
                        }
                    }                  
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
    
    
        public function actionIndexexitoso()
    {
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new EnvioSearch();
        $searchModel->user_id = $user_id;
        $searchModel->estado_envio_id = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexexitoso', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionIndexpendiente()
    {
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new EnvioSearch();
        $searchModel->mensajero_id = $user_id;
        $searchModel->estado_envio_id != 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexpendiente', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        public function actionIndexmensajero()
    {
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new EnvioSearch();
        $searchModel->mensajero_id = $user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexmensajero', [
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
    
//            public function actionViewprog($id)
//    {
//        $origen = \app\models\Envio::findOne($id); 
//        $destinos = \app\models\Destino::find()->where(['envio_id'=>$id])->asArray()->all();     
////        print_r($destinos);
//        
//        $searchModel = new \app\models\DestinoSearch();
//        $searchModel->envio_id = $id;
//        $dataProvider = $searchModel->searchdestinos(Yii::$app->request->queryParams);
//        
//        return $this->render('viewprog', [
//            'model' => $this->findModel($id),
//            'origen'=>$origen,
//            'destinos'=>$destinos,
//            
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    
        public function actionVistaenvio($id)
    {
         return $this->renderAjax('vistaenvio', [
            'model' => $this->findModel($id),
        ]);
    }
    
         public function actionViewrec($id)
    {
        $origen = \app\models\Envio::findOne($id); 
        $destinos = \app\models\Destino::find()->where(['envio_id'=>$id])->asArray()->all();            
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
            if($model->save()){
                ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado el Origen del Envio correctamente');  ?><?php  
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                $error=$model->errors;
                print_r($error); die();
                ?><?= Yii::$app->session->setFlash('danger', '<h4>ERROR</h4>'. $error); ?><?php  
                return $this->redirect(Yii::$app->request->referrer); 
            }
//            return $this->redirect(['view', 'id' => $model->id]);
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
            
            if($model->save()){
                ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado el Origen del Envio correctamente');  ?><?php  
                return $this->redirect(['view', 'id' => $model->id, 'prog'=>'SI']);
            }
            else{
                $error= $model->errors;                
                foreach($error as $e){
                    $string = implode(';', $e);
                    ?><?php Yii::$app->session->setFlash('danger', '<h4>ERROR</h4>'. $string); ?><?php  
                    return $this->redirect(Yii::$app->request->referrer); 
                }
            }
            
            ?><?php // Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado el Origen del Envio programado correctamente');  ?><?php  
//            return $this->redirect(['view', 'id' => $model->id, 'prog'=>'SI']);

             
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
            $fecha_actual = date("Y-m-d");
            $dias = $post['dias'];
            
            $fechaInicio=strtotime($fecha_desde);
            $fechaFin=strtotime($fecha_hasta);
//            $fecha_actual = strtotime(date("Y-m-d"));
            
//            print_r($post); echo('<br>');
//            echo("Fecha desde: "); print_r($fecha_desde); echo('<br>');
//            echo("Fecha hasta: "); print_r($fecha_hasta); echo('<br>');
//            echo("Fecha actual: "); print_r($fecha_actual); echo('<br>');
                        
            if( ($fechaInicio <= $fechaFin) && ($fecha_desde >= $fecha_actual)){

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
                
                
//                echo('ciudad id: ');print_r($ciudad_id); echo("<br>");
//                echo('user id: ');print_r($user_id); echo("<br>");
//                echo('remitente: ');print_r($remitente); echo("<br>");
//                echo('direccion origen: ');print_r($direccion_origen); echo("<br>");
//                echo('latitud: ');print_r($latitud); echo("<br>");
//                echo('longitud: ');print_r($longitud); echo("<br>");
//                echo('celular: ');print_r($celular); echo("<br>");
//                echo('observacion: ');print_r($observacion); echo("<br>");
//                echo('tipo_envio: ');print_r($tipo_envio_id); echo("<br>");
//               echo("<br>");print_r($dimensiones_id); echo("<br>");
//                die();
                
                $cont = 0;
//                print_r(count($fechas)); die();
                 while($cont < count($fechas)){
                    echo("Contador: ");print_r($cont);echo("<br>");
                     
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
//                     print_r($envio->fecha_registro); echo("<br>");
                     $envio->save();    
                     
                    $array_envio[]=$envio;
                    $array_id[]=$envio->id;
                    $cont = $cont+1;
                    
//                echo('-----------------------');    echo("<br>");
//                 echo('ciudad id: ');print_r($envio->ciudad_id); echo("<br>");
//                echo('user id: ');print_r($envio->user_id); echo("<br>");
//                echo('remitente: ');print_r($envio->remitente); echo("<br>");
//                echo('direccion origen: ');print_r($envio->direccion_origen); echo("<br>");
//                echo('latitud: ');print_r($envio->latitud); echo("<br>");
//                echo('longitud: ');print_r($envio->longitud); echo("<br>");
//                echo('celular: ');print_r($envio->celular); echo("<br>");
//                echo('observacion: ');print_r($envio->observacion); echo("<br>");
//                echo('tipo_envio: ');print_r($envio->estado_envio_id); echo("<br>");
//                echo('dimensioanes: ');print_r( $envio->dimensiones_id); echo("<br>");
                echo('fecha registro: ');print_r( $envio->fecha_registro); echo("<br>");
                echo("Contador incrementado: ");print_r($cont); echo("<br>");
                    
                    
                }  
//                print_r("fin"); 
//                die();
                
            $transaction->commit();
            }catch(\Exception $e)
            {
                $error=$e->getMessage();
                print_r($error);die();
                $transaction::rollback();
                throw $e;
            }

                // Extraigo el primer elemento del array $envio para sacar la id y renderizar
                $id_primer_elemento = $array_envio[0] ['id'];
//                print_r($id_primer_elemento); die();
                ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Se ha creado el Origen del Envio recurrente correctamente');  ?><?php  
                return $this->redirect(['viewrec', 'id' => $id_primer_elemento, 'fechas'=>$fechas, 'array_id'=>$array_id ]); 
//                return $this->redirect(['index']); 
                        
            }else{
                    ?><?php Yii::$app->session->setFlash('danger',
                            '<h4>ERROR EN LAS FECHAS</h4>'
                            . 'Revise los siguientes inconvenientes:<br>'
                            . '<li>La Fecha Inicio debe ser menor a Fecha fin</li>'
                            . '<li>La fecha Inicio debe ser mayor o igual a Fecha actual</li>'); ?><?php  
                    return $this->redirect(Yii::$app->request->referrer); 
                }         
            
        } else {
            return $this->render('createrec', [
                'model' => $model,
            ]);
        }
    }
    
    
    public function actionDetalles()
    {
        $model = new Envio;
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
        $radio = $r['radio'];        //print_r($radio); die();
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
            'model' => $model,
        ]);
    }
    
    public function actionCancelacion()
    {
        $id = Yii::$app->request->get('id'); 
        Envio::updateAll(['estado_envio_id' => 4], 'id = '. "'".$id."'" );
        ?><?= Yii::$app->session->setFlash('warning', '<h4>ENVIO CANCELADO</h4> Se ha cancelado su envío');  ?><?php  
        return $this->redirect(['index']);  
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
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Datos de Envío Origen actualizados correctamente');  ?><?php  
            return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(['index']);      
             
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
           public function actionUpdateprog($id)
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
            ?><?= Yii::$app->session->setFlash('success', '<h4>BIEN HECHO</h4> Datos de Envío Origen actualizados correctamente');  ?><?php  
            return $this->redirect(['view', 'id' => $model->id]);
//            return $this->redirect(['index']);      
             
        } else {
            return $this->render('createprog', [
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
