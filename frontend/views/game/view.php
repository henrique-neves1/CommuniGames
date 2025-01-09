<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Games $model */

$this->title = $model->name;

$profileId = Yii::$app->user->identity->profile->id;
$isInCart = Yii::$app->db->createCommand("SELECT COUNT(*) FROM cart WHERE profile_id = :profileId AND game_id = :gameId")
    ->bindValue(':profileId', $profileId)
    ->bindValue(':gameId', $model->id)
    ->queryScalar();
$userReview = Yii::$app->db->createCommand("
    SELECT * FROM reviews WHERE game_id = :gameId AND profile_id = :profileId
")->bindValue(':gameId', $model->id)
    ->bindValue(':profileId', Yii::$app->user->identity->profile->id)
    ->queryOne();

?>
<style>
    .container1 {
        display: flex;
        align-items: flex-start;
        margin-left: -6px;
    }

    .image {
        max-width: 20%;
        height: auto;
        margin-right: 20px;
    }

    .text-container {
        max-width: 600px;
    }

    .star {
        font-size: 24px;
        cursor: pointer;
        color: gray;
    }

    .star.highlight,
    .star.selected {
        color: gold;
    }

    #review-stars {
        position: relative;
        z-index: 10;
    }

</style>

<script>
    $(document).ready(function() {
        console.log("Script is working!");
        $('#review-stars .star').on({
            mouseover: function() {
                console.log("Hovered over a star");
                $(this).prevAll().addBack().addClass('highlight');
            },
            mouseout: function() {
                console.log("Mouse out of a star");
                $(this).prevAll().addBack().removeClass('highlight');
            },
            click: function() {
                console.log("Clicked on a star");
                $(this).prevAll().addBack().addClass('selected');
                $(this).nextAll().removeClass('selected');
                $('#review-stars-input').val($(this).index() + 1);
            }
        });
    });
</script>
<div class="games-view">

    <div class="container1">
        <img src="<?= Yii::$app->urlManager->createUrl(['game/cover', 'id' => $model->id]) ?>" alt="Cover Image" class="image">
        <div class="text-container">
            <h3>Description:</h3> <?= Html::encode($model->description) ?>
        </div>
    </div>
    <h4><b>€<?= Html::encode($model->price) ?></b></h4>
    <p>
        <strong>Genre(s):</strong>
        <?= implode(', ', array_map(fn($genre) => Html::encode($genre->name), $model->genres)) ?>
    </p>
    <p><strong>Developer:</strong> <?= Html::encode($model->developer_name) ?></p>
    <p><strong>Publisher:</strong> <?= Html::encode($model->publisher_name) ?></p>
    <p><strong>Release Date:</strong> <?= Html::encode($model->releasedate) ?></p>
    <!--<h3>Genres</h3>
    <ul>
        <php foreach ($model->genres as $genre): >
            <li><= Html::encode($genre->name) ></li>
        <php endforeach; >
    </ul>-->

    <?php if ($isInCart): ?>
        <?= Html::button('Already in Cart', ['class' => 'btn btn-secondary', 'disabled' => true]) ?>
    <?php else: ?>
        <?= Html::a('Add to Cart', ['add-to-cart', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>

    <div class="reviews-section">
        <h3>Add a Review</h3>
        <?php if (!$userReview): ?>
            <div class="review-form">
                <?= Html::beginForm(['game/add-review', 'id' => $model->id], 'post') ?>
                <label for="review-stars">Rating:</label>
                <div id="review-stars">
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                </div>
                <input type="hidden" id="review-stars-input" name="Reviews[stars]" value="">
                <div>
                    <?= Html::input('text', 'Reviews[title]', '', ['class' => 'form-control', 'placeholder' => 'Review Title', 'required' => true]) ?>
                </div>
                <div>
                    <?= Html::textarea('Reviews[description]', '', ['class' => 'form-control', 'placeholder' => 'Review Description']) ?>
                </div>
                <?= Html::submitButton('Post', ['class' => 'btn btn-primary', 'id' => 'post-review']) ?>
                <?= Html::endForm() ?>
            </div>
        <?php else : ?>
            <p>You have already reviewed this game.</p>
        <?php endif; ?>
    </div>

    <div class="reviews-list">
        <h3>Reviews</h3>
        <?php foreach ($model->reviews as $review) : ?>
            <div class="review-item">
                <div class="review-header">
                    <img src="<?= Yii::$app->urlManager->createUrl(['profile/picture', 'id' => $review->profile_id]) ?>" alt="Profile Picture" class="profile-pic rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                    <span><?= Html::encode($review->profile->name) ?></span>
                    <span>•</span>
                    <span><?= Yii::$app->formatter->asRelativeTime($review->createdate) ?></span>
                    <div class="stars">
                        <?= isset($review->stars) ? str_repeat('★', floor($review->stars)) . str_repeat('☆', 5 - floor($review->stars)) : str_repeat('☆', 5) ?>
                    </div>
                </div>
                <h4><?= Html::encode($review->title) ?></h4>
                <p><?= Html::encode($review->description) ?></p>
                <div class="review-footer">
                    <span>Was this review helpful?</span>
                    <?= Html::a('👍', ['review/helpful', 'id' => $review->id], ['class' => 'helpful-btn']) ?>
                    <?= $review->getHelpfulCount() ?>
                    <?= Html::a('👎', ['review/unhelpful', 'id' => $review->id], ['class' => 'unhelpful-btn']) ?>
                    <?= $review->getUnhelpfulCount() ?>
                </div>
                <?php if ($review->profile_id === Yii::$app->user->identity->profile->id): ?>
                    <div class="review-actions">
                        <?= Html::a('Edit', ['update-review', 'id' => $review->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete-review', 'id' => $review->id], [
                            'class' => 'btn btn-danger',
                            'data-confirm' => 'Are you sure you want to delete this review?',
                            'data-method' => 'post',
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
