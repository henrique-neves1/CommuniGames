<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

class GameController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\Games';

    public function actionIndex()
    {
        return ['status' => 'working'];
    }
}
