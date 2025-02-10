<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class UserController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\User';

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

    public function actionUsernames() {
        $usermodel = new $this->modelClass;
        $recs = $usermodel::find()->select(['username'])->all();
        return $recs;
    }

    public function actionCount() {
        $usermodel = new $this->modelClass;
        $recs = $usermodel::find()->all();
        return ['User count' => count($recs)];
    }
}