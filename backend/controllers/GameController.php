<?php

namespace backend\controllers;

use common\models\Games;
use app\models\GameSearch;
use common\models\Genres;
use common\models\Platforms;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GameController implements the CRUD actions for Games model.
 */
class GameController extends Controller
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
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['addGame']
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['updateGame']
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteGame']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@','*']
                    ],
                    /*[
                        'actions' => ['cover'],
                        'allow' => true,
                        'roles' => ['@','*']
                    ],*/
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@','*']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Games models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Games model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /*public function actionCover($id)
    {
        $model = $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        return $model->cover_data;
    }*/

    /**
     * Creates a new Games model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('addGame')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }
        $model = new Games();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $uploadedFile = UploadedFile::getInstance($model, 'coverFile');

                if (!$uploadedFile) {
                    Yii::$app->session->setFlash('error', 'Upload an image first.');
                    return $this->render('create', ['model' => $model]);
                }

                $uploadPath = Yii::getAlias('@webroot') . '/uploads/games/';

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true); // Create the directory if it doesn't exist
                }

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadPath . $fileName;
                if ($uploadedFile) {
                    if ($uploadedFile->saveAs($filePath)) {
                        $model->cover_path = Yii::$app->request->hostInfo . Yii::getAlias('@web') . '/uploads/games/' . $fileName;
                    } else {
                        Yii::$app->session->setFlash('error', 'File upload failed.');
                        return $this->render('create', ['model' => $model]);
                    }
                }
                if ($model->save()) {
                    $model->linkGenres(Yii::$app->request->post('Games')['genreIds']);
                    $model->linkPlatforms(Yii::$app->request->post('Games')['platformIds']);
                    Yii::$app->session->setFlash('success', 'Game created successfully!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Games model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('updateGame')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }
        $model = $this->findModel($id);
        $model->genreIds = array_map(fn($genre) => $genre->id, $model->genres);
        $model->platformIds = array_map(fn($platform) => $platform->id, $model->platforms);

        $existingCoverPath = $model->cover_path;

        if ($model->load(Yii::$app->request->post())) {
            $uploadedFile = UploadedFile::getInstance($model, 'coverFile');
            if ($uploadedFile) {
                $uploadPath = Yii::getAlias('@webroot') . '/uploads/games/';
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true); // Create the directory if it doesn't exist
                }

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadPath . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $model->cover_path = Yii::$app->request->hostInfo . Yii::getAlias('@web') . '/uploads/games/' . $fileName;
                } else {
                    Yii::$app->session->setFlash('error', 'File upload failed.');
                    return $this->render('update', ['model' => $model]);
                }
            } else {
                $model->cover_path = $existingCoverPath;
            }
            if ($model->save()) {
                $model->linkGenres(Yii::$app->request->post('Games')['genreIds']);
                $model->linkPlatforms(Yii::$app->request->post('Games')['platformIds']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Games model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteGame')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = $this->findModel($id);
        $db = Yii::$app->db;

        $tables = ['game_genre', 'game_platform', 'game_franchise', 'game_list'];
        $teamlists = ['game_team_lists'];

        foreach ($tables as $table) {
            $exists = (new \yii\db\Query())
                ->from($table)
                ->where(['game_id' => $id])
                ->exists();

            if ($exists) {
                $db->createCommand()
                    ->delete($table, ['game_id' => $id])
                    ->execute();
            }
        }

        foreach ($teamlists as $teamlist) {
            $exists = (new \yii\db\Query())
                ->from($teamlist)
                ->where(['games_id' => $id])
                ->exists();

            if ($exists) {
                $db->createCommand()
                    ->delete($teamlist, ['games_id' => $id])
                    ->execute();
            }
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Games model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Games the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Games::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
