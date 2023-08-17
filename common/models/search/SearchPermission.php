<?php

namespace common\models\search;

use common\models\Permission;
use yii\data\ActiveDataProvider;

class SearchPermission extends Permission
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name','description'],'string'],
            ['type','integer']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Permission::find();
        $query->where(['type' => Permission::TYPE_PERMISSION]);
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
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        $this->dateFilter($query,'created_at');

        return $dataProvider;
    }
}
