<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $game_id
 * @property int $profile_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $quantity
 *
 * @property Games $game
 * @property Profiles $profile
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'profile_id'], 'required'],
            [['game_id', 'profile_id', 'quantity'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::class, 'targetAttribute' => ['game_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'profile_id' => 'Profile ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'quantity' => 'Quantity',
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
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['id' => 'profile_id']);
    }
}
