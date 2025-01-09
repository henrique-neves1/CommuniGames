<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Games[] $games */

$this->title = 'Your Cart';
?>
<div class="cart-index">

    <h1>Your Cart</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Cover</th>
            <th>Game Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($games as $game): ?>
            <tr>
                <td>
                    <?= Html::img(
                        Url::to(['game/cover', 'id' => $game['id']]),
                        ['alt' => $game['name'], 'style' => 'width: 100px; height: auto;']
                    ) ?>
                </td>
                <td><?= Html::encode($game['name']) ?></td>
                <td>€<?= Html::encode($game['price']) ?></td>
                <td>
                    <?= Html::beginForm(['cart/update-quantity'], 'post') ?>
                    <?= Html::hiddenInput('cartId', $game['cart_id']) ?>
                    <input type="number" name="quantity" value="<?= $game['quantity'] ?>" min="1" style="width: 60px;">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-link']) ?>
                    <?= Html::endForm() ?>
                </td>
                <td>€<?= Html::encode($game['price'] * $game['quantity']) ?></td>
                <td>
                    <?= Html::beginForm(['cart/remove'], 'post') ?>
                    <?= Html::hiddenInput('cartId', $game['cart_id']) ?>
                    <?= Html::submitButton('Remove', ['class' => 'btn btn-danger']) ?>
                    <?= Html::endForm() ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
