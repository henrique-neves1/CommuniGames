<?php

namespace frontend\controllers;

use common\models\Client;
use common\models\Games;
use common\models\Invoicelines;
use common\models\Invoices;
use Exception;
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

        $isCartEmpty = empty($games);

        return $this->render('index', [
            'games' => $games,
            'isCartEmpty' => $isCartEmpty,
        ]);
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

            $referrer = Yii::$app->request->referrer;

            // If the referrer contains 'game/view', stay on game page
            if (strpos($referrer, 'game/view') !== false) {
                return $this->redirect($referrer);
            }

            // Otherwise, go back to the cart page
            return $this->redirect(['cart/index']);

        }

        return $this->redirect(['index']);
    }

    public function actionCheckout()
    {
        $model = new Client(); // Client model for the form

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['cart/process-purchase', 'clientData' => $model->attributes]);
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }

    public function actionProcessPurchase()
    {
        $request = Yii::$app->request;
        $clientData = $request->get('clientData');

        if (!$clientData) {
            return $this->redirect(['cart/index']);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Check if client already exists
            $client = Client::findOne(['taxnumber' => $clientData['taxnumber']]);

            if (!$client) {
                // Create a new client
                $client = new Client();
                $client->attributes = $clientData;
                $client->registrydate = date('Y-m-d H:i:s');
                if (!$client->save()) {
                    throw new Exception('Failed to save client');
                }
            }

            // Create the invoice
            $invoice = new Invoices();
            $invoice->client_id = $client->id;
            $invoice->total = 0; // Will be calculated
            $invoice->date = date('Y-m-d H:i:s');

            if (!$invoice->save()) {
                throw new Exception('Failed to save invoice');
            }

            // Get games from cart
            $cartItems = Yii::$app->db->createCommand("
            SELECT g.id, g.price, c.quantity
            FROM cart c
            JOIN games g ON c.game_id = g.id
            WHERE c.profile_id = :profile_id
        ")->bindValue(':profile_id', Yii::$app->user->identity->profile->id)
                ->queryAll();

            $total = 0;

            foreach ($cartItems as $item) {
                $invoiceLine = new Invoicelines();
                $invoiceLine->invoice_id = $invoice->id;
                $invoiceLine->game_id = $item['id'];
                $invoiceLine->quantity = $item['quantity']; // Assuming 1 per item in cart
                $invoiceLine->unitaryprice = $item['price'];
                $invoiceLine->subtotal = $item['price'] * $item['quantity'];

                if (!$invoiceLine->save()) {
                    throw new Exception('Failed to save invoice line');
                }

                $total += $invoiceLine->subtotal;
            }

            // Update total in invoice
            $invoice->total = $total;
            if (!$invoice->save()) {
                throw new Exception('Failed to update invoice total');
            }

            // Clear cart
            Yii::$app->db->createCommand()
                ->delete('cart', ['profile_id' => Yii::$app->user->identity->profile->id])
                ->execute();

            $transaction->commit();

            return $this->redirect(['cart/success', 'invoice_id' => $invoice->id]);
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while processing your purchase.');
            return $this->redirect(['cart/index']);
        }
    }

    public function actionSuccess($invoice_id)
    {
        $invoice = Invoices::findOne($invoice_id);
        if (!$invoice) {
            throw new NotFoundHttpException('Invoice not found.');
        }

        $invoiceLines = Invoicelines::find()->where(['invoice_id' => $invoice_id])->all();

        return $this->render('success', [
            'invoice' => $invoice,
            'invoiceLines' => $invoiceLines,
        ]);
    }
}
