<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $taxnumber
 * @property string $residence
 * @property string $zipcode
 * @property string $registrydate
 *
 * @property Invoices[] $invoices
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'taxnumber', 'residence', 'zipcode'], 'required'],
            [['registrydate'], 'safe'],
            [['name', 'email'], 'string', 'max' => 150],
            [['taxnumber'], 'string', 'max' => 9],
            [['residence'], 'string', 'max' => 100],
            [['zipcode'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'taxnumber' => 'Tax Number',
            'residence' => 'Residence',
            'zipcode' => 'Zip Code',
            'registrydate' => 'Registry Date',
        ];
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoices::class, ['client_id' => 'id']);
    }
}
