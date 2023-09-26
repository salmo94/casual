<?php

namespace common\models\search;

use common\models\Goods;
use yii\data\ActiveDataProvider;

class SearchGoods extends Goods
{

    public function rules(): array
    {
        return [
            [['id','price','status','category_id'],'integer'],
            [['title','description','article','available'],'string'],
        ];
    }


    public function search(array $params): ActiveDataProvider
    {
        // призначаємо query наш запит з моделі
        $query = Goods::find();
        $query->where(['is_deleted' => false]);
        // створюємо провайдер.сетимо запит і пагінацію
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 15
                ]
            ]
        );
        //перевіряємо на валідність данні які прийшси в параметрах строки запиту
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        //прописуємо які атрибути мають фільтруватись
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere([ 'price' => $this->price]);
        $query->andFilterWhere(['like', 'article', $this->article]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['available' => $this->available]);
        $query->andFilterWhere(['category_id' => $this->category_id]);

        $this->dateFilter($query, 'created_at');

        return $dataProvider;
    }

}