<?php

namespace frontend\controllers;

use common\models\Profiles;
use frontend\models\ProfileSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for Profiles model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only logged-in users
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Profiles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPicture($id)
    {
        $model = $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        return $model->picture_data;
    }

    /**
     * Displays a single Profiles model.
     * @param int $id ID
     * @param int $user_id User ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Profiles::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested profile does not exist.');
        }

        $isOwner = ($model->user_id === Yii::$app->user->id);

        return $this->render('view', [
            'model' => $model,
            'isOwner' => $isOwner,
        ]);
    }

    /**
     * Creates a new Profiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Profiles();
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->picture_file = UploadedFile::getInstance($model, 'picture_file');

            if ($model->validate()) {
                $model->savePicture();
                if ($model->save(false)) { // Skip validation since it's already validated
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = $model->user;

        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to update this profile.');
        }

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $user->load($this->request->post());

            $model->picture_file = UploadedFile::getInstance($model, 'picture_file');

            if ($model->validate() && $user->validate()) {
                $model->savePicture();
                $model->save(false); // Save profile
                if (!$user->save(false)) { // Save User model
                    Yii::error("Failed to save User: " . json_encode($user->getErrors()));
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $user_id User ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $user_id)
    {
        $this->findModel($id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $user_id User ID
     * @return array|\yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Profiles::find()->with('user')->where(['id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException('The requested profile does not exist.');
        }

        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to access this profile.');
        }

        return $model;
    }
}
