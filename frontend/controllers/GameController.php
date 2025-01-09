<?php

namespace frontend\controllers;

use common\models\Games;
use app\models\GameSearch;
use common\models\Genres;
use common\models\HelpfulReviews;
use common\models\Reviews;
use common\models\UnhelpfulReviews;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class GameController extends Controller
{
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['update-review', 'delete-review'],
                    'roles' => ['@'], // Only authenticated users
                ],
            ],
        ];
        return $behaviors;
    }*/
    public function actionView($id)
    {
        $model = Games::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The game does not exist.');
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionCover($id)
    {
        $model = $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        return $model->cover_data;
    }

    public function actionAddToCart($id)
    {
        $profileId = Yii::$app->user->identity->profile->id; // Adjust as necessary
        $cartItem = Yii::$app->db->createCommand("SELECT * FROM cart WHERE profile_id = :profileId AND game_id = :gameId")
            ->bindValue(':profileId', $profileId)
            ->bindValue(':gameId', $id)
            ->queryOne();

        if ($cartItem) {
            Yii::$app->db->createCommand()
                ->update('cart', ['quantity' => $cartItem['quantity'] + 1], ['id' => $cartItem['id']])
                ->execute();
        } else {
            Yii::$app->db->createCommand()
                ->insert('cart', ['profile_id' => $profileId, 'game_id' => $id, 'quantity' => 1])
                ->execute();
        }

        Yii::$app->session->setFlash('success', 'Game added to cart!');
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionAddReview($id)
    {
        $profileId = Yii::$app->user->identity->profile->id;

        // Prevent duplicate reviews
        $existingReview = Reviews::findOne(['game_id' => $id, 'profile_id' => $profileId]);
        if ($existingReview) {
            Yii::$app->session->setFlash('error', 'You have already reviewed this game.');
            return $this->redirect(['view', 'id' => $id]);
        }
        if (Yii::$app->request->isPost) {
            $review = new Reviews();
            $review->game_id = $id;
            $review->profile_id = $profileId;
            $review->createdate = new \yii\db\Expression('NOW()');

            if ($review->load(Yii::$app->request->post())) {
                if (empty($review->stars)) {
                    Yii::$app->session->setFlash('error', 'Please provide a star rating.');
                    return $this->redirect(['game/view', 'id' => $id]);
                }
                if ($review->save()) {
                    Yii::$app->session->setFlash('success', 'Your review has been added!');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to add review. ' . implode(', ', $review->getFirstErrors()));
                }
            } else {
                Yii::$app->session->setFlash('error', 'Failed to load review data.');
            }
        }
        return $this->redirect(['game/view', 'id' => $id]);
    }

    public function actionUpdateReview($id)
    {
        $review = Reviews::findOne(['id' => $id, 'profile_id' => Yii::$app->user->identity->profile->id]);

        if (!$review) {
            throw new NotFoundHttpException("Review not found or you don't have permission to edit this review.");
        }

        if (Yii::$app->request->isPost) {
            $review->stars = Yii::$app->request->post('rating');
            $review->title = Yii::$app->request->post('title');
            $review->description = Yii::$app->request->post('description');

            if ($review->load(Yii::$app->request->post()) && $review->save()) {
                Yii::$app->session->setFlash('success', 'Review updated successfully.');
                return $this->redirect(['game/view', 'id' => $review->game_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update the review.');
            }
        }

        return $this->render('update-review', [
            'review' => $review,
        ]);
    }

    public function actionDeleteReview($id)
    {
        $review = Reviews::findOne(['id' => $id, 'profile_id' => Yii::$app->user->identity->profile->id]);

        if (!$review) {
            throw new NotFoundHttpException("Review not found or you don't have permission to delete this review.");
        }

        if ($review->delete()) {
            Yii::$app->session->setFlash('success', 'Review deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete the review.');
        }

        return $this->redirect(['game/view', 'id' => $review->game_id]);
    }

    public function actionHelpful($id)
    {
        $profileId = Yii::$app->user->identity->profile->id;
        if (!HelpfulReviews::findOne(['review_id' => $id, 'profile_id' => $profileId])) {
            $helpful = new HelpfulReviews();
            $helpful->review_id = $id;
            $helpful->profile_id = $profileId;
            $helpful->save();
        }
        return $this->redirect(['game/view', 'id' => Reviews::findOne($id)->game_id]);
    }

    public function actionUnhelpful($id)
    {
        $profileId = Yii::$app->user->identity->profile->id;
        if (!UnhelpfulReviews::findOne(['review_id' => $id, 'profile_id' => $profileId])) {
            $unhelpful = new UnhelpfulReviews();
            $unhelpful->review_id = $id;
            $unhelpful->profile_id = $profileId;
            $unhelpful->save();
        }
        return $this->redirect(['game/view', 'id' => Reviews::findOne($id)->game_id]);
    }

    public function actionSearch($query = null)
    {
        Yii::debug('Search action called');
        $query = Yii::$app->request->get('query');

        if (!$query) {
            Yii::debug('No query provided, redirecting to index');
            return $this->render('index');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Games::find()->where(['like', 'name', $query]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'query' => $query,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Games::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
