<?php

namespace backend\controllers;

use app\models\GameSearch;
use common\models\Games;
use common\models\TeamLists;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TeamListController implements the CRUD actions for TeamLists model.
 */
class TeamListController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TeamLists models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TeamLists::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamLists model.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model->getGames(),
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddGames($id)
    {
        $model = $this->findModel($id);

        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $alreadyAddedGames = $model->getGames()->select('id')->column();

        if (Yii::$app->request->isPost) {
            $selectedGames = Yii::$app->request->post('selection', []); // IDs of selected games
            foreach ($selectedGames as $gameId) {
                $game = Games::findOne($gameId);
                if ($game) {
                    $model->link('games', $game);
                }
            }
            Yii::$app->session->setFlash('success', 'Games added successfully.');
            return $this->redirect(['view', 'id' => $id]);
        }


        return $this->render('add-games', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'alreadyAddedGames' => $alreadyAddedGames,
        ]);
    }

    public function actionRemoveGame($teamListId, $gameId)
    {
        $teamList = $this->findModel($teamListId);
        $game = Games::findOne($gameId);

        if ($game) {
            $teamList->unlink('games', $game, true);
            Yii::$app->session->setFlash('success', 'Game removed successfully.');
        }

        return $this->redirect(['view', 'id' => $teamListId]);
    }

    /**
     * Creates a new TeamLists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TeamLists();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TeamLists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TeamLists model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TeamLists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TeamLists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TeamLists::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
