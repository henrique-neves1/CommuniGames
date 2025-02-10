<?php

namespace backend\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;

class CartController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\Cart';

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

    public function actionDatabyid($id)
    {
        $cartModel= new $this->modelClass;
        $recs = $cartModel::find()->where(['id' => $id])->one();
        return $recs;
    }

    public function actionDatabyprofile($profile_id){
        $cartModel = new $this->modelClass;

        // Fetch records matching the profile_id
        $records = $cartModel::find()
            ->where(['profile_id' => $profile_id])
            ->asArray()
            ->all();

        // Handle cases where no records are found
        if (empty($records)) {
            return 'No cart values found for the provided profile ID.';
        }

        // Success response
        return $records;
    }

    public function actionAdd($game_id, $profile_id) {
        $existingItem = $this->modelClass::findOne(['profile_id' => $profile_id, 'game_id' => $game_id]);
        if ($existingItem) {
            return [
                'status' => 'error',
                'message' => 'This item is already in the cart.',
            ];
        }
        $cartmodel = new $this->modelClass;
        $cartmodel->game_id=$game_id;
        $cartmodel->profile_id=$profile_id;
        if ($cartmodel->save()) {
            return [
                'status' => 'success',
                'message' => 'Cart item added successfully.',
                'data' => $cartmodel,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to add item.',
                'errors' => $cartmodel->errors,
            ];
        }
    }

    public function actionUpdatequantity($id, $quantity) {
        $cartmodel = $this->modelClass::findOne($id);

        if (!$cartmodel) {
            return "Cart item $id not found.";
        }

        $cartmodel->quantity = $quantity;

        if ($cartmodel->save()) {
            return [
                'data' => [
                    'id' => $cartmodel->id,
                    'quantity' => $cartmodel->quantity,
                ],
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to update quantity.',
                'errors' => $cartmodel->errors,
            ];
        }
    }

    public function actionRemoveitem($id){
        $cartItem = $this->modelClass::findOne($id);

        if (!$cartItem) {
            return [
                'status' => 'error',
                'message' => "Cart item $id not found.",
            ];
        }

        if ($cartItem->delete()) {
            return [
                'status' => 'success',
                'message' => "Cart item $id removed successfully.",
            ];
        } else {
            return [
                'status' => 'error',
                'message' => "Failed to remove cart item $id.",
            ];
        }
    }
}
