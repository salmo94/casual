<?php

namespace common\models\search;

use common\models\Attribute;
use common\models\AttributeValue;
use yii\data\ActiveDataProvider;

class SearchAttributeValue extends AttributeValue
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'attribute_id'], 'string'],
            [['id', 'status', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = AttributeValue::find();
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
        $query->andFilterWhere(['attribute_id' => $this->attribute_id]);

        $this->dateFilter($query,'created_at');

        return $dataProvider;
    }
}
