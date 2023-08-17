<?php

namespace common\models\search;

use common\models\Assignment;
use common\models\User;
use yii\data\ActiveDataProvider;

class SearchUser extends User
{
    public $role;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'email', 'role'],'string'],
            ['is_deleted','boolean'],
            ['status','integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find();
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
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['created_at' => $this->created_at]);

        if (!empty($this->role)) {
            $subQuery = Assignment::find()->select('user_id')->where(['item_name' => $this->role]);
            $query->andWhere(['username' => $subQuery]);
        }
        return $dataProvider;
    }
}
