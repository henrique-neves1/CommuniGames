<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property int $client_id
 * @property float $total
 * @property string $date
 *
 * @property Client $client
 * @property Invoicelines[] $invoicelines
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'total'], 'required'],
            [['client_id'], 'integer'],
            [['total'], 'number'],
            [['date'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'total' => 'Total',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Invoicelines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoicelines()
    {
        return $this->hasMany(Invoicelines::class, ['invoice_id' => 'id']);
    }
}
