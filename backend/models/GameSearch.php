<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Games;

/**
 * GameSearch represents the model behind the search form of `common\models\Games`.
 */
class GameSearch extends Games
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'cover_name', 'cover_data', 'description', 'developer_name', 'publisher_name', 'releasedate'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Games::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'releasedate' => $this->releasedate,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cover_name', $this->cover_name])
            ->andFilterWhere(['like', 'cover_data', $this->cover_data])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'developer_name', $this->developer_name])
            ->andFilterWhere(['like', 'publisher_name', $this->publisher_name]);

        return $dataProvider;
    }
}
