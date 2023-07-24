<?php

namespace common\models\search;


use \common\models\Category;
use yii\data\ActiveDataProvider;

class SearchCategory extends Category
{
    /**
     * @return array
     */

    public function rules(): array
    {
        return [
            [['title','parent_id'], 'string'],
            [['id', 'status', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */

    public function search(array $params): ActiveDataProvider
    {
        $query = Category::find();    // призначаємо query наш запит з моделі
        $query->where(['is_deleted' => false]);
        // створюємо провайдер.сетимо запит і пагінацію
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15
            ]
        ]);

        //перевіряємо на валідність данні які прийшси в параметрах строки запиту
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        //прописуємо які атрибути мають фільтруватись
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere([ 'status' => $this->status]);
        $query->andFilterWhere(['like','parent_id',$this->parent_id]);
        $query->andFilterWhere(['like','created_at', $this->created_at]);

        return $dataProvider;
    }

}