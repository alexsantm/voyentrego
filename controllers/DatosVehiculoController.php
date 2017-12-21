<?php

namespace app\controllers;

use Yii;
use app\models\DatosVehiculo;
use app\models\DatosVehiculoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DatosVehiculoController implements the CRUD actions for DatosVehiculo model.
 */
class DatosVehiculoController extends Controller
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
     * Lists all DatosVehiculo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new DatosVehiculoSearch();
        $searchModel->user_id = $user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionIndexadminflota()
    {
        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new DatosVehiculoSearch();
        $searchModel->responsable_user_id = $user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexadminflota', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionIndexsuperadmin()
    {
//        $user_id = Yii::$app->user->identity['id'];
        $searchModel = new DatosVehiculoSearch();
        //$searchModel->responsable_user_id = $user_id;
        $dataProvider = $searchModel->searchsuperadmin(Yii::$app->request->queryParams);

        return $this->render('indexsuperadmin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DatosVehiculo model.
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
     * Creates a new DatosVehiculo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DatosVehiculo();
        $model->fecha= date("Y-m-d H:i");
        $model->responsable_user_id= Yii::$app->user->identity['id'];
        $model->estado_id= 5;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
        public function actionCreateadminflota()
    {
        $model = new DatosVehiculo();
        $model->fecha= date("Y-m-d H:i");
        $model->responsable_user_id= Yii::$app->user->identity['id'];
        $model->estado_id= 5;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('createadminflota', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DatosVehiculo model.
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
    
     public function actionUpdateadminflota($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('updateadminflota', [
                'model' => $model,
            ]);
        }
    }
    
      public function actionUpdatesuperadmin($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
            return $this->renderAjax('updatesuperadmin', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DatosVehiculo model.
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
     * Finds the DatosVehiculo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DatosVehiculo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DatosVehiculo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
