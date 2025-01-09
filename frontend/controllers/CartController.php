<?php

namespace frontend\controllers;

use common\models\Games;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    public function actionIndex()
    {
        $profileId = Yii::$app->user->identity->profile->id; // Adjust as necessary
        $games = (new \yii\db\Query())
            ->select(['g.*', 'c.quantity', 'c.id AS cart_id'])
            ->from('games g')
            ->innerJoin('cart c', 'c.game_id = g.id')
            ->where(['c.profile_id' => $profileId])
            ->all();

        return $this->render('index', ['games' => $games]);
    }

    public function actionUpdateQuantity()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $cartId = $request->post('cartId');
            $quantity = $request->post('quantity');

            if ($cartId && $quantity > 0) {
                $rowsAffected = Yii::$app->db->createCommand()
                    ->update('cart', ['quantity' => $quantity], ['id' => $cartId])
                    ->execute();

                if ($rowsAffected > 0) {
                    Yii::info("Updated cart quantity successfully for cartId: $cartId", 'cart-debug');
                } else {
                    Yii::error("Failed to update cart quantity for cartId: $cartId", 'cart-debug');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Invalid cart ID or quantity.');
            }
        }

        return $this->redirect(['index']);
    }

    public function actionRemove()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $cartId = $request->post('cartId');

            if ($cartId) {
                $rowsDeleted = Yii::$app->db->createCommand()
                    ->delete('cart', ['id' => $cartId])
                    ->execute();

                if ($rowsDeleted > 0) {
                    Yii::info("Deleted cart item successfully for cartId: $cartId", 'cart-debug');
                } else {
                    Yii::error("Failed to delete cart item for cartId: $cartId", 'cart-debug');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Invalid cart ID.');
            }
        }

        return $this->redirect(['index']);
    }
}
