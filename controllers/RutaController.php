<?php

namespace app\controllers;

use Yii;
use app\models\Ruta;
use app\models\RutaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use app\base\Model;

/**
 * RutaController implements the CRUD actions for Ruta model.
 */
class RutaController extends Controller
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
     * Lists all Ruta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RutaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ruta model.
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
     * Creates a new Ruta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ruta();
        $model->fecha = date("Y-m-d H:i"); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
    
//        public function actionCreate()
//    {
//        $model = new Ruta();
//        $model->fecha = date("Y-m-d H:i"); 
//
//        if ($model->load(Yii::$app->request->post())) {
//            
//             print_r(Yii::$app->request->post()); die();
//            
//            
////            $model->save();
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
    
    /**
     * Email validation.
     *
     * @param $attribute
     */
    
//    public function actionCreate($attribute)
//    {
//        $items = $this->$attribute;
//
//        if (!is_array($items)) {
//            $items = [];
//        }
//                else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//        foreach ($items as $index => $item) {
//            $validator = new Ruta();
//            $error = null;
//            $validator->validate($item, $error);
//            if (!empty($error)) {
//                $key = $attribute . '[' . $index . ']';
//                $this->addError($key, $error);
//            }
//            else{
//                $model->save();
//            }
//        }
//
//    }

    /**
     * Updates an existing Ruta model.
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
     * Deletes an existing Ruta model.
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
     * Finds the Ruta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ruta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ruta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
