<?php

namespace app\models;

class GameController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
