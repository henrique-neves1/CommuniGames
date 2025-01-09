<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\web\View $this */
/** @var common\models\Games[] $games */
/** @var string $query */

use yii\widgets\ListView;

$this->title = 'Search Results for: ' . $query;
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= $this->title ?></h1>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_gameItem', // Create this partial view to format individual game items
    'summary' => '',
    'emptyText' => 'No games found for your search.',
]) ?>