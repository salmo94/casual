<?php

namespace common\models\search;

use common\models\Attribute;
use yii\data\ActiveDataProvider;

class SearchAttribute extends Attribute
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['title', 'string'],
            ['type_id', 'safe'],
            [['id', 'status', 'is_deleted', 'category_id',], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Attribute::find();
        $query->where(['is_deleted' => false]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10
                ]
            ]
        );
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['category_id' => $this->category_id]);
        $query->andFilterWhere(['type_id' => $this->type_id]);

        $this->dateFilter($query,'created_at');

        return $dataProvider;
    }
}
