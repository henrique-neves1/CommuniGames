<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $picture_name
 * @property resource|null $picture_data
 * @property string|null $bio
 * @property float|null $balance
 * @property int $user_id
 *
 * @property Acquisitions[] $acquisitions
 * @property BlockedUsers[] $blockedUsers
 * @property BlockedUsers[] $blockedUsers0
 * @property Cart[] $carts
 * @property Comments[] $comments
 * @property Favorites[] $favorites
 * @property HelpfulReviews[] $helpfulReviews
 * @property LikedComments[] $likedComments
 * @property LikedPosts[] $likedPosts
 * @property LikedReplies[] $likedReplies
 * @property Lists[] $lists
 * @property MediaAlbum[] $mediaAlbums
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Posts[] $posts
 * @property Replies[] $replies
 * @property Reposts[] $reposts
 * @property Reviews[] $reviews
 * @property UnhelpfulReviews[] $unhelpfulReviews
 * @property User $user
 * @property Wishlist[] $wishlists
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['picture_data', 'bio'], 'string'],
            [['balance'], 'number'],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['picture_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'picture_name' => 'Picture Name',
            'picture_data' => 'Picture Data',
            'bio' => 'Bio',
            'balance' => 'Balance',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Acquisitions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcquisitions()
    {
        return $this->hasMany(Acquisitions::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[BlockedUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlockedUsers()
    {
        return $this->hasMany(BlockedUsers::class, ['blocking_user_id' => 'id']);
    }

    /**
     * Gets query for [[BlockedUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlockedUsers0()
    {
        return $this->hasMany(BlockedUsers::class, ['blocked_user_id' => 'id']);
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[HelpfulReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelpfulReviews()
    {
        return $this->hasMany(HelpfulReviews::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[LikedComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikedComments()
    {
        return $this->hasMany(LikedComments::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[LikedPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikedPosts()
    {
        return $this->hasMany(LikedPosts::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[LikedReplies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikedReplies()
    {
        return $this->hasMany(LikedReplies::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Lists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(Lists::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[MediaAlbums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMediaAlbums()
    {
        return $this->hasMany(MediaAlbum::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::class, ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Reposts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReposts()
    {
        return $this->hasMany(Reposts::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[UnhelpfulReviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnhelpfulReviews()
    {
        return $this->hasMany(UnhelpfulReviews::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['profile_id' => 'id']);
    }
}
