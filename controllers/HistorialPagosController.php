<?php

namespace app\controllers;

use Yii;
use app\models\HistorialPagos;
use app\models\HistorialPagosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * HistorialPagosController implements the CRUD actions for HistorialPagos model.
 */
class HistorialPagosController extends Controller
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
     * Lists all HistorialPagos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistorialPagosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionIndexsemanal()
    {
        $searchModel = new HistorialPagosSearch();
        $dataProvider = $searchModel->searchsemanal(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
//            print_r(Yii::$app->request->post()); die(); 
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['HistorialPagos']);
            $post['HistorialPagos'] = $posted;

            // Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false                 
                $model->save();
                
                if (isset($posted['referencia'])) {
                    $output = $model->referencia;
                }
                
                if (isset($posted['estado'])) {
                    $output = $model->estado;
                    \app\models\HistorialPagos::updateAll(['estado' =>4], 'mensajero_id = '. "'".$model->mensajero_id."'" );  
                /******************* COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                     $model->actualizaIdPagos($model->mensajero_id);                    
               /******************* FIN COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                }

                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // Return AJAX JSON encoded response and exit
            echo $out;
            return $this->redirect(['indexsemanal']);
        }

        return $this->render('indexsemanal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionIndexquincenal()
    {
        $searchModel = new HistorialPagosSearch();
        $dataProvider = $searchModel->searchquincenal(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
//            print_r(Yii::$app->request->post()); die(); 
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['HistorialPagos']);
            $post['HistorialPagos'] = $posted;

            // Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false                 
                $model->save();
                
                if (isset($posted['referencia'])) {
                    $output = $model->referencia;
                }
                
                if (isset($posted['estado'])) {
                    $output = $model->estado;
                    \app\models\HistorialPagos::updateAll(['estado' =>4], 'mensajero_id = '. "'".$model->mensajero_id."'" );                     
                    /******************* COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                     $model->actualizaIdPagos($model->mensajero_id);                    
                    /******************* FIN COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // Return AJAX JSON encoded response and exit
            echo $out;
            return $this->redirect(['indexquincenal']);
        }

        return $this->render('indexquincenal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionIndexmensual()
    {
        $searchModel = new HistorialPagosSearch();
        $dataProvider = $searchModel->searchmensual(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
//            print_r(Yii::$app->request->post()); die(); 
            $_id = $_POST['editableKey'];
            $model = $this->findModel($_id);

            $post = [];
            $posted = current($_POST['HistorialPagos']);
            $post['HistorialPagos'] = $posted;

            // Load model like any single model validation
            if ($model->load($post)) {
                // When doing $result = $model->save(); I get a return value of false                 
                $model->save();
                                
                if (isset($posted['referencia'])) {
                    $output = $model->referencia;
                }
                
                if (isset($posted['estado'])) {
                    $output = $model->estado;
                    \app\models\HistorialPagos::updateAll(['estado' =>4], 'mensajero_id = '. "'".$model->mensajero_id."'" );                                           
                    /******************* COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                     $model->actualizaIdPagos($model->mensajero_id);                    
                    /******************* FIN COLOCO ID DE HISTORIAL EN DETALLE PAGO ********************************/
                }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // Return AJAX JSON encoded response and exit
            echo $out;
            return $this->redirect(['indexmensual']);
        }

        return $this->render('indexmensual', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    

    /**
     * Displays a single HistorialPagos model.
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
     * Creates a new HistorialPagos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HistorialPagos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HistorialPagos model.
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
     * Deletes an existing HistorialPagos model.
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
     * Finds the HistorialPagos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HistorialPagos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HistorialPagos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
