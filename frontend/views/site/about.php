<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Este é um projeto universitário desenvolvido por um único membro, que simula uma loja online de videojogos, com carrinho de compras, faturas, reviews, etc.
    <br/>Ainda se encontra na fase de desenvolvimento e tem muito a melhorar.</p>

    <p>This is a universitary project developed by a single member, that simulates an online video game store, with a purchase cart, invoices, reviews, etc.
    <br/>It's still in development phase and it has a lot to improve.</p>

    <code><?= __FILE__ ?></code>
</div>
