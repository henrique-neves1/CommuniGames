<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "genres".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property GameGenre[] $gameGenres
 * @property Games[] $games
 */
class Genres extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genres';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * Gets query for [[GameGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameGenres()
    {
        return $this->hasMany(GameGenre::class, ['genre_id' => 'id']);
    }

    /**
     * Gets query for [[Games]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Games::class, ['id' => 'game_id'])->viaTable('game_genre', ['genre_id' => 'id']);
    }
}
