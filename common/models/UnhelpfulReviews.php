<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unhelpful_reviews".
 *
 * @property int $id
 * @property int $review_id
 * @property int $profile_id
 *
 * @property Profiles $profile
 * @property Reviews $review
 */
class UnhelpfulReviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unhelpful_reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_id', 'profile_id'], 'required'],
            [['review_id', 'profile_id'], 'integer'],
            [['review_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reviews::class, 'targetAttribute' => ['review_id' => 'id']],
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
            'review_id' => 'Review ID',
            'profile_id' => 'Profile ID',
        ];
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
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Reviews::class, ['id' => 'review_id']);
    }
}
