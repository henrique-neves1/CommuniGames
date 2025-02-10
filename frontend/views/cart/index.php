<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Games[] $games */

$this->title = 'Cart';
?>
<div class="cart-index">

    <h1>Cart</h1>

    <?= Html::a('Checkout', ['cart/checkout'], [
            'class' => 'btn btn-success' . ($isCartEmpty ? ' disabled' : ''),
            'style' => 'pointer-events: ' . ($isCartEmpty ? 'none' : 'auto') . ';',
    ]) ?>

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

                    <?=
                    Html::a(
                    Html::img(
                        $game['cover_path'],
                        ['alt' => $game['name'], 'style' => 'width: 100px; height: auto; border-radius: 7px']
                    ),
                    ['game/view', 'id' => $game['id']]
                    )
                    ?>
                </td>
                <td><?=
                    Html::a(Html::encode($game['name']),['game/view', 'id' => $game['id']]) ?></td>
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
