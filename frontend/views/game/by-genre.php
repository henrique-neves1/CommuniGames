<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($genre->name) . " games";
?>

<h1><?= Html::encode($genre->name) ?> games</h1>
<p></p>
<div class="games-row" style="display: flex; gap: 20px; overflow-x: auto; margin-left: -23px">
    <?php foreach ($games as $game): ?>
        <div class="game-item" style="text-align: center; min-width: 150px;">
            <div class="game-cover">
                <?= Html::a(
                    Html::img(
                        $game->cover_path,
                        ['alt' => $game->name, 'style' => 'width: 100px; height: auto; border-radius: 7px']
                    ),
                    ['game/view', 'id' => $game->id]
                ) ?>
            </div>
            <div class="game-title" style="margin-top: 5px; font-weight: bold;">
                <?= Html::a(Html::encode($game->name),['game/view', 'id' => $game->id]) ?>
            </div>
            <div class="game-price" style="font-size: 0.9em; color: #555;">
                €<?= Html::encode($game->price) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
