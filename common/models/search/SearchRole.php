<?php

namespace common\models\search;

use common\models\ItemChild;
use common\models\Role;
use yii\data\ActiveDataProvider;

class SearchRole extends Role
{
    public $permission;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'description', 'permission'], 'string'],
            ['type', 'integer']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Role::find();
        $query->where(['type' => Role::TYPE_ROLE]);
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

        $this->dateFilter($query, 'created_at');

        if (!empty($this->permission)) {
            $subQuery = ItemChild::find()
                ->select('parent')
                ->where(['child' => $this->permission]);
            $query->andWhere(['name' => $subQuery]);
        }
        return $dataProvider;
    }
}
