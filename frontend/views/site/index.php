<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\TeamLists[] $teamLists */

$this->title = 'CommuniGames';
?>
<div class="site-index">
    <?php foreach ($teamLists as $teamList): ?>
        <div class="team-list">
            <h2><?= Html::encode($teamList->name) ?></h2>
            <div class="games-row" style="display: flex; gap: 20px; overflow-x: auto;">
                <?php foreach ($teamList->games as $game): ?>
                    <div class="game-item" style="text-align: center; min-width: 150px;">
                        <div class="game-cover">
                            <?= Html::a(
                                Html::img(
                                    Url::to(['game/cover', 'id' => $game->id]),
                                    ['alt' => $game->name, 'style' => 'width: 100px; height: auto;']
                                ),
                                ['game/view', 'id' => $game->id]
                            ) ?>
                        </div>
                        <div class="game-title" style="margin-top: 5px; font-weight: bold;">
                            <?= Html::encode($game->name) ?>
                        </div>
                        <div class="game-price" style="font-size: 0.9em; color: #555;">
                            €<?= Html::encode($game->price) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>

</div>
