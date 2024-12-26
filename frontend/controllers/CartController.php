<?php

namespace app\controllers;

use common\models\Cart;
use app\models\CartSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $profileId = Yii::$app->user->identity->profile->id;
        $cartItems = Cart::find()->where(['profile_id' => $profileId])->all();

        return $this->render('index', ['cartItems' => $cartItems]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @param int $game_id Game ID
     * @param int $profile_id Profile ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $game_id, $profile_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $game_id, $profile_id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionAdd($gameId)
    {
        $profileId = Yii::$app->user->identity->profile->id;
        $cartItem = Cart::findOne(['profile_id' => $profileId, 'game_id' => $gameId]);

        if ($cartItem) {
            Yii::$app->session->setFlash('info', 'This game is already in your cart.');
        } else {
            $cartItem = new Cart();
            $cartItem->profile_id = $profileId;
            $cartItem->game_id = $gameId;

            if ($cartItem->save()) {
                Yii::$app->session->setFlash('success', 'Game added to your cart.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add the game to your cart.');
            }
        }

        return $this->redirect(['cart/index']);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $game_id Game ID
     * @param int $profile_id Profile ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $quantity)
    {
        $cartItem = Cart::findOne($id);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            if ($cartItem->save()) {
                Yii::$app->session->setFlash('success', 'Cart updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update the cart.');
            }
        }

        return $this->redirect(['cart/index']);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $game_id Game ID
     * @param int $profile_id Profile ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id)
    {
        $cartItem = Cart::findOne($id);

        if ($cartItem && $cartItem->delete()) {
            Yii::$app->session->setFlash('success', 'Game removed from your cart.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to remove the game.');
        }

        return $this->redirect(['cart/index']);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $game_id Game ID
     * @param int $profile_id Profile ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $game_id, $profile_id)
    {
        if (($model = Cart::findOne(['id' => $id, 'game_id' => $game_id, 'profile_id' => $profile_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
