<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "games".
 *
 * @property int $id
 * @property string|null $name
 //* @property string|null $cover_name
 //* @property resource|null $cover_data
 * @property string|null $cover_path
 * @property string|null $description
 * @property string|null $developer_name
 * @property string|null $publisher_name
 * @property string|null $releasedate
 * @property float|null $price
 *
 * //* @property Acquisitions[] $acquisitions
 * @property Cart[] $carts
 * //* @property Favorites[] $favorites
 * //* @property Franchises[] $franchises
 * //* @property GameFranchise[] $gameFranchises
 * //* @property GameGenre[] $gameGenres
 * //* @property GameList[] $gameLists
 * //* @property GamePlatform[] $gamePlatforms
 * //* @property GameTeamLists[] $gameTeamLists
 * @property Genres[] $genres
 * //* @property Lists[] $lists
 * //* @property MediaAlbum[] $mediaAlbums
 * @property Platforms[] $platforms
 * //* @property Posts[] $posts
 * @property Reviews[] $reviews
 * @property TeamLists[] $teamLists
 * //* @property Wishlist[] $wishlists
 */
class Games extends \yii\db\ActiveRecord
{

    public $coverFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['name', 'description', 'developer_name', 'publisher_name', 'releasedate', 'price'], 'safe'],
            [['coverFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'skipOnEmpty' => true],
            [['genreIds'], 'safe'],
            [['platformIds'],'safe']
        ];
    }

    public function uploadCover()
    {
        if ($this->validate() && $this->coverFile && file_exists($this->coverFile->tempName)) {
            $directory = Yii::getAlias('@backend/web/uploads/games/');
            if (!is_dir($directory)) {
                mkdir($directory, 0775, true); // Create the directory if it doesn't exist
            }

            // Define the file path relative to the backend/web/uploads/games/ folder
            $filePath = 'uploads/games/' . uniqid() . '.' . $this->coverFile->extension;

            // Save the file to backend/web/uploads
            if ($this->coverFile->saveAs(Yii::getAlias('@backend/web') . '/' . $filePath)) {
                return $filePath; // Return the relative file path
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cover_path' => 'Cover Path',
            'description' => 'Description',
            'developer_name' => 'Developer Name',
            'publisher_name' => 'Publisher Name',
            'releasedate' => 'Releasedate',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Acquisitions]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getAcquisitions()
    {
        return $this->hasMany(Acquisitions::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['game_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getFavorites()
    {
        return $this->hasMany(Favorites::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[Franchises]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getFranchises()
    {
        return $this->hasMany(Franchises::class, ['id' => 'franchise_id'])->viaTable('game_franchise', ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[GameFranchises]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getGameFranchises()
    {
        return $this->hasMany(GameFranchise::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[GameGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getGameGenres()
    {
        return $this->hasMany(GameGenre::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[GameLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getGameLists()
    {
        return $this->hasMany(GameList::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[GamePlatforms]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getGamePlatforms()
    {
        return $this->hasMany(GamePlatform::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[GameTeamLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getGameTeamLists()
    {
        return $this->hasMany(GameTeamLists::class, ['games_id' => 'id']);
    }*/

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genres::class, ['id' => 'genre_id'])->viaTable('game_genre', ['game_id' => 'id']);
    }

    public $genreIds;

    /**
     * Gets query for [[Lists]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getLists()
    {
        return $this->hasMany(Lists::class, ['id' => 'list_id'])->viaTable('game_list', ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[MediaAlbums]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getMediaAlbums()
    {
        return $this->hasMany(MediaAlbum::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[Platforms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatforms()
    {
        return $this->hasMany(Platforms::class, ['id' => 'platform_id'])->viaTable('game_platform', ['game_id' => 'id']);
    }

    public $platformIds;

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getPosts()
    {
        return $this->hasMany(Posts::class, ['game_id' => 'id']);
    }*/

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['game_id' => 'id']);
    }

    /**
     * Gets query for [[TeamLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeamLists()
    {
        return $this->hasMany(TeamLists::class, ['id' => 'team_lists_id'])->viaTable('game_team_lists', ['games_id' => 'id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['game_id' => 'id']);
    }*/

    public function linkGenres($genreIds)
    {
        // Clear existing genres
        $this->unlinkAll('genres', true);

        // Link new genres
        if (!empty($genreIds)) {
            foreach ($genreIds as $genreId) {
                $genre = Genres::findOne($genreId);
                if ($genre) {
                    $this->link('genres', $genre);
                }
            }
        }
    }

    public function linkPlatforms($platformIds)
    {
        // Clear existing platforms
        $this->unlinkAll('platforms', true);

        // Link new platforms
        if (!empty($platformIds)) {
            foreach ($platformIds as $platformId) {
                $platform = Platforms::findOne($platformId);
                if ($platform) {
                    $this->link('platforms', $platform);
                }
            }
        }
    }

    /*public function getCoverBase64()
    {
        return $this->cover_data ? base64_encode($this->cover_data) : null;
    }*/

    /*public function fields()
    {
        $fields = parent::fields();

        // Remove the 'cover_data' field
        unset($fields['cover_data']);

        // Add a base64-encoded version of cover_data
        $fields['cover_base64'] = 'coverBase64';

        return $fields;
    }*/
}
