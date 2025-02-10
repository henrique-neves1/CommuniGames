<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Reviews $review */

$this->title = 'Update review';
?>
<div class="update-review">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <label for="review-stars">Rating:</label>
    <input type="hidden" id="review-stars-input" name="rating" value="<?= Html::encode($review->stars) ?>">
    <div id="review-stars"  style="margin-top: 5px">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="fas fa-star star <?= $i <= $review->stars ? 'selected' : '' ?>"></i>
        <?php endfor; ?>
    </div>
    <p></p>
    <?= $form->field($review, 'title')->textInput(['maxlength' => true, 'name' => 'Reviews[title]',]) ?>
    <p></p>
    <?= $form->field($review, 'description')->textarea(['rows' => 4, 'name' => 'Reviews[description]']) ?>
    <p></p>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

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

<style>
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