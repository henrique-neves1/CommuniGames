<?php
use yii\helpers\Html;

/** @var $invoice \common\models\Invoices */
/** @var $invoiceLines \common\models\Invoicelines[] */

$this->title = 'Purchase Successful';
?>

<h2>Purchase Successful!</h2>
<p>Thank you for your purchase. Here is your invoice:</p>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Game</th>
        <th>Quantity</th>
        <th>Unit Price (€)</th>
        <th>Subtotal (€)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($invoiceLines as $line): ?>
        <tr>
            <td><?= Html::encode($line->game->name) ?></td>
            <td><?= Html::encode($line->quantity) ?></td>
            <td><?= number_format($line->unitaryprice, 2) ?></td>
            <td><?= number_format($line->subtotal, 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Total Price at the bottom right -->
<div style="text-align: right; margin-top: 10px;">
    <strong>Total: €<?= number_format($invoice->total, 2) ?></strong>
</div>

<p><?= Html::a('Return to Homepage', ['site/index'], ['class' => 'btn btn-primary']) ?></p>