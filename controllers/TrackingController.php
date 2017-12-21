<?php

namespace app\controllers;

use Yii;
use app\models\Tracking;
use app\models\TrackingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrackingController implements the CRUD actions for Tracking model.
 */
class TrackingController extends Controller
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
     * Lists all Tracking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrackingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tracking model.
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
     * Creates a new Tracking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Tracking();
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
        $model = new Tracking();
        $connection = \Yii::$app->db;
        $model->fecha = date("Y-m-d H:i");
        if ($model->load(Yii::$app->request->post())) {            
            try{
            $transaction = $connection->beginTransaction(); 
                $post=Yii::$app->request->post();                    
                $latitud = $post['Tracking']['latitude'];	
                $longitud = $post['Tracking']['longitude'];
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
     * Updates an existing Tracking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 
        $connection = \Yii::$app->db;
        $model->fecha = date("Y-m-d H:i");
        if ($model->load(Yii::$app->request->post())) {            
            try{
            $transaction = $connection->beginTransaction(); 
                $post=Yii::$app->request->post();                    
                $latitud = $post['Tracking']['latitude'];	
                $longitud = $post['Tracking']['longitude'];
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }        
    }

    /**
     * Deletes an existing Tracking model.
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
     * Finds the Tracking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tracking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tracking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /********************************************************************************/
    
    public function actionUbicacion()
    {
        //$mensajeros = Tracking::find()->asArray()->all();      
        $mensajeros = (new \yii\db\Query())
        ->select(['*'])
        ->from('tracking tbl')
        ->where('fecha = (select Max(fecha) from tracking where user_id = tbl.user_id)')
        ->all();
        
        //Tiempo de refresco:
        $time = \app\models\Opciones::find()->select(['tiempo_refresco'])->asArray()->one();
        $tiempo_refresco = $time['tiempo_refresco']; 
                
        return $this->render('ubicacion', [
            'mensajeros' => $mensajeros,
            'tiempo_refresco' => $tiempo_refresco,
        ]);
    }

    
    public function actionBusquedamensajero()
    {
        //$mensajeros = Tracking::find()->asArray()->all();  
        $model = new Tracking();
        if ($model->load(Yii::$app->request->get())) {            
            $get = Yii::$app->request->get();            
            $user_id = $get['Tracking']['user_id'];
            
            $query = Tracking::find()->where(['user_id'=>$user_id])->orderBy('fecha  desc')->limit(1)->asArray()->one();
            $latitud = $query['latitud'];
            $longitud = $query['longitud'];
            $fecha = $query['fecha'];
            
            //Tiempo de refresco:
            $time = \app\models\Opciones::find()->select(['tiempo_refresco'])->asArray()->one();
            $tiempo_refresco = $time['tiempo_refresco'];
            
            $query_profile = \app\models\Profile::find()->where(['user_id'=>$user_id])->asArray()->one();
            $full_name = $query_profile['full_name'];
            $foto = $query_profile['foto'];
            
            if (empty($foto)) {
                $foto = Yii::$app->request->BaseUrl . '/images/fotos/default.jpg';
            } else {
                $foto = Yii::$app->request->BaseUrl . '/images/fotos/'.$foto;
            }

            return $this->render('busquedamensajero', [ 
                'latitud' => $latitud,
                'longitud' => $longitud,
                'fecha' => $fecha,
                'full_name' => $full_name,
                'foto' => $foto,
                'user_id' => $user_id,
                'tiempo_refresco' => $tiempo_refresco,
            ]);
        } else {
//            print_r("noenvio datos"); die();
            //Tiempo de refresco:
            $time = \app\models\Opciones::find()->select(['tiempo_refresco'])->asArray()->one();
            $tiempo_refresco = $time['tiempo_refresco'];
            $mensaje = "Por favor seleccione un mensajero";
            return $this->render('busquedamensajero', [
                'model' => $model,
                'mensaje' => $mensaje,
                'tiempo_refresco' => $tiempo_refresco,
            ]);
        }
    }

    
}
