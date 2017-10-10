<?php

namespace app\controllers;

use Yii;
use app\models\Descuento;
use app\models\DescuentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DescuentoController implements the CRUD actions for Descuento model.
 */
class DescuentoController extends Controller
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
     * Lists all Descuento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DescuentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Descuento model.
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
     * Creates a new Descuento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Descuento();
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
        $model = new Descuento();                
        if ($model->load(Yii::$app->request->post())) {
           $post=Yii::$app->request->post();           
           $fecha_inicio =$post['fecha_inicio'];
           $fecha_fin =$post['fecha_fin'];
           $model->fecha_inicio = $fecha_inicio;
           $model->fecha_fin= $fecha_fin;
            
          $image = UploadedFile::getInstance($model, 'archivo_promocion');
           if (!is_null($image)) {
            $model->archivo_promocion = $image->name;
            $tmp = explode('.', $image->name);
            $ext = end($tmp);
			 			 
              // generate a unique file name to prevent duplicate filenames
              $model->archivo_promocion = Yii::$app->security->generateRandomString().".{$ext}";
              // the path to save file, you can set an uploadPath
              // in Yii::$app->params (as used in example below)                       
              Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/images/promociones/';
              $path = Yii::$app->params['uploadPath'] . $model->archivo_promocion;
               $image->saveAs($path);
            }
            if ($model->save()) {             
                return $this->redirect(['view', 'id' => $model->id]);   
//                return $this->redirect(Yii::$app->request->referrer); 
            }  else {
                var_dump ($model->getErrors()); die();
             }
              }
              return $this->render('create', [
                  'model' => $model,
              ]);     
    } 

    /**
     * Updates an existing Descuento model.
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
     * Deletes an existing Descuento model.
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
     * Finds the Descuento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Descuento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Descuento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
