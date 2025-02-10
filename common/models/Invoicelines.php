<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoicelines".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $game_id
 * @property int $quantity
 * @property float $unitaryprice
 * @property float $subtotal
 *
 * @property Games $game
 * @property Invoices $invoice
 */
class Invoicelines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoicelines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'game_id', 'quantity', 'unitaryprice', 'subtotal'], 'required'],
            [['invoice_id', 'game_id', 'quantity'], 'integer'],
            [['unitaryprice', 'subtotal'], 'number'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::class, 'targetAttribute' => ['game_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoices::class, 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'game_id' => 'Game ID',
            'quantity' => 'Quantity',
            'unitaryprice' => 'Unitaryprice',
            'subtotal' => 'Subtotal',
        ];
    }

    /**
     * Gets query for [[Game]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::class, ['id' => 'game_id']);
    }

    /**
     * Gets query for [[Invoice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoices::class, ['id' => 'invoice_id']);
    }
}
