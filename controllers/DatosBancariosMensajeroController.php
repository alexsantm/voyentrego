<?php

namespace app\controllers;

use Yii;
use app\models\DatosBancariosMensajero;
use app\models\DatosBancariosMensajeroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DatosBancariosMensajeroController implements the CRUD actions for DatosBancariosMensajero model.
 */
class DatosBancariosMensajeroController extends Controller
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
     * Lists all DatosBancariosMensajero models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DatosBancariosMensajeroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DatosBancariosMensajero model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
////        print_r($id); die();
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//        
//        $user_id = Yii::$app->request->get('id');  
//        print_r($this->findModel(0)); die();
//        return $this->render('view', [
//            'model' => $this->findModel($user_id),
//            'id' => $user_id,
//        ]);
        
        $model = new DatosBancariosMensajero();
        return $this->render('view', [
                'model' => $model,
            ]);

    }

    /**
     * Creates a new DatosBancariosMensajero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DatosBancariosMensajero();
        $model->fecha = date("Y-m-d H:i"); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer); 
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
        public function actionCreatecheque()
    {
        $model = new DatosBancariosMensajero();
        $model->fecha = date("Y-m-d H:i"); 

        if ($model->load(Yii::$app->request->post())) {
             $errores = $model->getErrors();
                    var_dump($model->errors);
//            print_r("datos enviados"); die();
            $model->save();
            if($model->save()){
                return $this->redirect(Yii::$app->request->referrer); 
            }
            else{
                    $errores = $model->getErrors();
                    var_dump($model->errors);
                    die();
            }
        } else {
            return $this->render('createcheque', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DatosBancariosMensajero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->fecha = date("Y-m-d H:i"); 
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatecheque($id)
    {
        $model = $this->findModel($id);
        $model->fecha = date("Y-m-d H:i"); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
            return $this->render('updatecheque', [
                'model' => $model,
            ]);
        }
    }
    
        public function actionActualizarcheque()
    {
        //$model = $this->findModel($id);
        //$model->fecha = date("Y-m-d H:i"); 
            $model = new DatosBancariosMensajero;            

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $id = $post['DatosBancariosMensajero']['id'];
            $user_id = $post['DatosBancariosMensajero']['user_id'];
            
            \app\models\DatosBancariosMensajero::updateAll([
                'user_id' => $user_id,
                'tipo_transferencia' => 'CHEQUE',
                'numero_cuenta' => '',
                'nombre_banco' => '',
                'nombre_completo' => '',
                'identificacion' => '',
                'email' => '',
                'fecha'=>date("Y-m-d H:i"), 
                ], 'id = '. "'".$id."'" );
             //$model->save();
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
            return $this->render('updatecheque', [
                'model' => $model,
            ]);
        }
    }

    

    /**
     * Deletes an existing DatosBancariosMensajero model.
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
     * Finds the DatosBancariosMensajero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DatosBancariosMensajero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DatosBancariosMensajero::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
