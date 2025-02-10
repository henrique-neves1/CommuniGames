<?php

namespace common\models;

use Bluerhinos\phpMQTT;

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

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        $id=$this->id;
        $game_id=$this->game_id;
        $profile_id=$this->profile_id;
        $quantity=$this->quantity;

        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->game_id=$game_id;
        $myObj->profile_id=$profile_id;
        $myObj->quantity=$quantity;
        $myJSON = json_encode($myObj);

        if($insert){
            $this->PublishToMosquitto("cart", "Produto adicionado ao carrinho " . $myJSON);
        }else {
            $this->PublishToMosquitto("cart", "Quantidade atualizada " . $myJSON);
        }
    }

    public function afterDelete(){
        parent::afterDelete();

        $prod_id = $this->id;
        $myObj = new \stdClass();
        $myObj->id=$prod_id;
        $myJSON = json_encode($myObj);
        $this->PublishToMosquitto("cart", "Produto removido " . $myJSON);
    }

    public function PublishToMosquitto($topic, $msg){
        $server = "127.0.0.1";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = "phpMQTT-publisher";
        $mqtt = new phpMQTT($server, $port, $client_id);
        if($mqtt->connect(true, NULL, $username, $password)){
            $mqtt->publish($topic, $msg, 0);
            $mqtt->close();
        }
        else {
            file_put_contents("debug.output","Time out!");
        }
    }
}
