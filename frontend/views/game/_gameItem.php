<?php

/** @var common\models\Games $model */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="games-row" style="display: flex; gap: 20px; overflow-x: auto;">
    <div class="game-item" style="text-align: center; min-width: 150px;">
        <div class="game-cover">
            <?= Html::a(
                Html::img($model->cover_path, ['alt' => $model->name, 'style' => 'width: 100px; height: auto; border-radius: 7px']),
                ['game/view', 'id' => $model->id]
            ) ?>
        </div>
        <div class="game-title" style="margin-top: 5px; font-weight: bold;">
            <?= Html::a(Html::encode($model->name),['game/view', 'id' => $model->id]) ?>
        </div>
        <div class="game-price" style="font-size: 0.9em; color: #555;">
            €<?= Html::encode($model->price) ?>
        </div>
    </div>
</div>
