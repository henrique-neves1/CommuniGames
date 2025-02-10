<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Carousel;

/** @var yii\web\View $this */
/** @var common\models\TeamLists[] $teamLists */

$this->title = 'CommuniGames';
?>
<div class="site-index">
    <div class="app-header text-left" style="margin-bottom: 30px;">
        <!-- Replace 'path/to/logo.png' with the actual path to your logo -->
        <!-- Html::img('@web/images/logo1.png', [
            'alt' => 'CommuniGames Logo',
            'style' => 'width: 200px; height: auto;'
        ]) -->
        <h1 style="margin-top: 10px; font-size: 1.8em; color: #333;">Your place to buy games</h1>
    </div>

    <style>
        .rounded1{
            border-radius: 20px;
        }
    </style>

    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded1">
            <div class="carousel-item active">
                <?= Html::img('@web/images/slide1.jpeg', [
                    'class' => 'd-block w-100',
                    'alt' => 'Slide 1',
                ]) ?>
            </div>
            <div class="carousel-item">
                <?= Html::img('@web/images/slide2.jpeg', [
                    'class' => 'd-block w-100',
                    'alt' => 'Slide 1',
                ]) ?>
            </div>
            <div class="carousel-item">
                <?= Html::img('@web/images/slide3.jpeg', [
                    'class' => 'd-block w-100',
                    'alt' => 'Slide 1',
                ]) ?>
            </div>
            <div class="carousel-item">
                <?= Html::img('@web/images/slide4.jpeg', [
                    'class' => 'd-block w-100',
                    'alt' => 'Slide 1',
                ]) ?>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <p></p>
    <?php foreach ($teamLists as $teamList): ?>
        <div class="team-list">
            <h2><?= Html::encode($teamList->name) ?></h2>
            <p></p>
            <p></p>
            <div class="games-row" style="display: flex; gap: 20px; overflow-x: auto; margin-left: -23px">
                <?php foreach ($teamList->games as $game): ?>
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
        </div>
        <hr>
    <?php endforeach; ?>

</div>
