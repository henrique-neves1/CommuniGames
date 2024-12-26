<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<?php foreach ($cartItems as $item): ?>
    <div>
        <h3><?= $item->game->name ?></h3>
        <p>Price: <?= $item->game->price ?></p>
        <a href="<?= Yii::$app->urlManager->createUrl(['cart/remove', 'id' => $item->id]) ?>">Remove</a>
    </div>
<?php endforeach; ?>
<p>Total: <?= array_sum(array_map(fn($item) => $item->game->price, $cartItems)) ?></p>


</div>
