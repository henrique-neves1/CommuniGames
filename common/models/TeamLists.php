<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "team_lists".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property GameTeamLists[] $gameTeamLists
 * @property Games[] $games
 */
class TeamLists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_lists';
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
     * Gets query for [[GameTeamLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameTeamLists()
    {
        return $this->hasMany(GameTeamLists::class, ['team_lists_id' => 'id']);
    }

    /**
     * Gets query for [[Games]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Games::class, ['id' => 'games_id'])->viaTable('game_team_lists', ['team_lists_id' => 'id']);
    }

    public function linkAllGames($gameIds)
    {
        $this->unlinkAll('games', true); // Remove existing links
        foreach ($gameIds as $gameId) {
            $game = Games::findOne($gameId);
            if ($game) {
                $this->link('games', $game);
            }
        }
    }
}
