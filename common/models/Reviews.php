<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property float|null $stars
 * @property string|null $createdate
 * @property int $game_id
 * @property int $profile_id
 *
 * @property Games $game
 * @property HelpfulReviews[] $helpfulReviews
 * @property Profiles $profile
 * @property UnhelpfulReviews[] $unhelpfulReviews
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'profile_id', 'stars', 'title'], 'required'],
            [['description'], 'string'],
            [['stars'], 'integer', 'min' => 1, 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'stars' => 'Stars',
            'createdate' => 'Createdate',
            'game_id' => 'Game ID',
            'profile_id' => 'Profile ID',
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
     * Gets query for [[HelpfulReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelpfulReviews()
    {
        return $this->hasMany(HelpfulReviews::class, ['review_id' => 'id']);
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

    /**
     * Gets query for [[UnhelpfulReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnhelpfulReviews()
    {
        return $this->hasMany(UnhelpfulReviews::class, ['review_id' => 'id']);
    }

    public function getHelpfulCount()
    {
        return HelpfulReviews::find()->where(['review_id' => $this->id])->count();
    }

    public function getUnhelpfulCount()
    {
        return UnhelpfulReviews::find()->where(['review_id' => $this->id])->count();
    }
}
