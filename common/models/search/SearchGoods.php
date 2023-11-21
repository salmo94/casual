<?php

namespace common\models\search;

use common\models\AttributeValue;
use common\models\Goods;
use common\models\goods_attribute\GoodsAttributeDictionary;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;

class SearchGoods extends Goods
{


    public function rules(): array
    {
        return [
            [['id', 'price', 'status', 'category_id'], 'integer'],
            [['title', 'description', 'article', 'available'], 'string'],
        ];
    }


    public function search(array $params): ActiveDataProvider
    {
        // призначаємо query наш запит з моделі
        $query = Goods::find();
        $query->where(['is_deleted' => false]);
//        SELECT * FROM "categories" WHERE "id" IN (18, 23)
        $query->with(['images', 'category' => function (ActiveQuery $q) {
            $q->select(['id', 'title']);
        }]);
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
        $query->andFilterWhere(['price' => $this->price]);
        $query->andFilterWhere(['like', 'article', $this->article]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['available' => $this->available]);
        $query->andFilterWhere(['category_id' => $this->category_id]);

        $this->dateFilter($query, 'created_at');

        return $dataProvider;
    }


    public function searchApi(array $params): ActiveDataProvider
    {
        $query = Goods::find()
            ->select(['goods.id as id', 'title', 'description', 'price'])
            ->with(['images' => function (ActiveQuery $q) {
                $q->select(['image_path', 'goods_id']);
            }])
            ->where([
                'category_id' => $params['categoryId'],
                'is_deleted' => false,
            ]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 12
                ]
            ]
        );
        $producerId = $this->getGoodsIdByAttributeTitle($params['producer']);
        $countryId = $this->getGoodsIdByAttributeTitle($params['country']);

        $query->andFilterWhere(['between', 'price', $params['minPrice'], $params['maxPrice']]);
        $query->andFilterWhere(['goods.id' => $producerId]);
        $query->andFilterWhere(['goods.id' => $countryId]);
        if ($params['sort'] === 'cheap') {
            $query->orderBy(['price' => SORT_ASC]);
        }elseif ($params['sort'] === 'expensive') {
            $query->orderBy(['price' => SORT_DESC]);
        }

        return $dataProvider;
    }



    public function getGoodsIdByAttributeTitle(?array $title): ?array
    {
      $valueId = AttributeValue::find()
            ->select(['id'])
            ->where(['title' => $title])
            ->column();
        $valueId = $valueId ?: null;
        $result = GoodsAttributeDictionary::find()
            ->select('goods_id')
            ->where(['value_id' => $valueId])
            ->column();

        return $result ?: null;
    }
}
