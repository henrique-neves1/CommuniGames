<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "platforms".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $logo_path
 *
 * @property GamePlatform[] $gamePlatforms
 * @property Games[] $games
 */
class Platforms extends \yii\db\ActiveRecord
{
    public $logoFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'platforms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logo_name', 'logo_data'],'safe'],
            [['logoFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function uploadLogo()
    {
        if ($this->validate() && $this->logoFile !== null) {
            $this->logo_name = $this->logoFile->name;
            $this->logo_data = file_get_contents($this->logoFile->tempName);
            return true;
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
            'logo_name' => 'Logo Name',
            'logo_data' => 'Logo Data'
        ];
    }

    /**
     * Gets query for [[GamePlatforms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGamePlatforms()
    {
        return $this->hasMany(GamePlatform::class, ['platform_id' => 'id']);
    }

    /**
     * Gets query for [[Games]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Games::class, ['id' => 'game_id'])->viaTable('game_platform', ['platform_id' => 'id']);
    }
}
