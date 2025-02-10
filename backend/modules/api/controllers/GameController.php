<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

class GameController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\Games';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return ['status' => 'working'];
    }

    public function actionNames() {
        $gamesmodel = new $this->modelClass;
        $recs = $gamesmodel::find()->select(['name'])->all();
        return $recs;
    }

    public function actionCount() {
        $gamesmodel = new $this->modelClass;
        $recs = $gamesmodel::find()->all();
        return ['Game count' => count($recs)];
    }

    public function actionPrices(){
        $gamesmodel = new $this->modelClass;
        $recs = $gamesmodel::find()->select(['price'])->all();
        return $recs;
    }

    public function actionNamebyid($id) {
        $gamesmodel = new $this->modelClass;
        $recs = $gamesmodel::find()->select(['name'])->where(['id' => $id])->one();
        return $recs;
    }

    public function actionPricebyid($id){
        $gamesmodel = new $this->modelClass;
        $recs = $gamesmodel::find()->select(['price'])->where(['id' => $id])->one();
        return $recs;
    }
}
