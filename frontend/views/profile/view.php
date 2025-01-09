<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Profiles $model */
/** @var bool $isOwner */

/*$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);*/
?>
<div class="profiles-view">

    <div class="sidebar">
        <h3>Profile Details</h3>
        <div class="profile-picture">
            <?php if ($model->picture_data): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($model->picture_data) ?>" alt="<?= Html::encode($model->name) ?>" style="width: 100px; height: 100px; border-radius: 50%;">
            <?php else: ?>
                <img src="../../Users/hneve/Downloads/Default_pfp.svg.png" alt="Default Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">
            <?php endif; ?>
        </div>
        <h2><?= Html::encode($model->name) ?> (@<?= Html::encode($model->user->username) ?>)</h2>

        <p><?= Html::encode($model->bio) ?></p>

        <?php if ($isOwner): ?>
            <p>Balance: €<?= Yii::$app->formatter->asCurrency($model->balance) ?></p>
            <p>
            <?= Html::a('Update Profile', ['/profile/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete Account', ['/profile/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete your account?',
                'method' => 'post',
            ],
        ]) ?>
            </p>
            <h3>Email and Password</h3>
            <div class="email-password">
                <div class="email">
                    <label>Email:
                        <input type="text" value="<?= Html::encode($model->user->email) ?>" readonly class="form-control">
                    </label>
                    <?= Html::a('<i class="fas fa-pencil-alt" style="font-size:24px;color:blue"></i>', ['site/update-email'], ['class' => 'btn btn-link']) ?>
                </div>
                <div class="password">
                    <label>Password:
                        <input type="password" value="********" readonly class="form-control">
                    </label>
                    <?= Html::a('<i class="fas fa-pencil-alt" style="font-size:24px;color:blue"></i>', ['site/update-password'], ['class' => 'btn btn-link']) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
