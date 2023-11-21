<?php

namespace backend\controllers\api;

use common\models\Attribute;
use common\models\AttributeValue;
use common\models\Goods;
use common\models\search\SearchGoods;
use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\Response;


class GoodsController extends Controller
{

    public function actionGetGoodsItem($id): Response
    {
        $goodsItem = Goods::find()
            ->select(['goods.id as id', 'title', 'description', 'price', 'article', 'available', 'status'])
            ->with(['images'])
            ->where(['goods.id' => $id, 'goods.is_deleted' => false])
            ->asArray()
            ->one();

        return $this->asJson(['goodsItem' => $goodsItem]);
    }


    /**
     * @param int $id
     * @return Response
     */
    public function actionGetGoodsAttributes(int $id): Response
    {
        $goods = Goods::findOne($id);
        $attributeValues = AttributeValue::find()
            ->select('title')
            ->where(['is_deleted' => false])
            ->indexBy('id')
            ->column();

        $attributeTitles = Attribute::find()
            ->select(['title'])
            ->where(['is_deleted' => false, 'category_id' => $goods->category_id])
            ->indexBy('id')
            ->column();

        return $this->asJson([
            'goods' => $goods,
            'attrBool' => $goods->boolAttributes,
            'attrDict' => $goods->dictAttributes,
            'attrFloat' => $goods->floatAttributes,
            'attrInt' => $goods->intAttributes,
            'attrText' => $goods->textAttributes,
            'attributeTitles' => $attributeTitles,
            'attributeValues' => $attributeValues,
        ]);

    }


    /**
     * @return Response
     */
    public function actionGetGoods(): Response
    {
        $goodsSearch = new SearchGoods();
        $dataProvider = $goodsSearch->searchApi(Yii::$app->request->get());

        return $this->asJson(['goodsData' => [
            'data' => $dataProvider->getModels(),
            'totalCount' => $dataProvider->getTotalCount()
        ]]);
    }

    /**
     * @param $categoryId
     * @return Response
     */
    public function actionGetAttributeTitles($categoryId): Response
    {
       $producersList = AttributeValue::getAttributeValueTitles('Бренд',$categoryId);
       $countryList = AttributeValue::getAttributeValueTitles('Країна-виробник',$categoryId);

        return $this->asJson(['producersList' => $producersList,'countryList' => $countryList]);
    }

    public function actionGetRandomGoods(): Response
    {
        $randomGoods = Goods::find()
            ->select(['id','title','price'])
            ->limit(12)
            ->with(['images' => function (ActiveQuery $q) {
                $q->select(['image_path', 'goods_id']);
            }])
            ->asArray()
            ->all();

        return $this->asJson(['randomGoods' => $randomGoods]);

    }

    /**
     * @return Response
     */
    public function actionGetSalesLeaders(): Response
    {
        $salesLeaders = Goods::find()
            ->select(['id','title','price'])
            ->with(['images' => function (ActiveQuery $q) {
                $q->select(['image_path', 'goods_id']);
            }])
            ->limit(2)
            ->asArray()
            ->all();

        return $this->asJson(['salesLeaders' => $salesLeaders]);
    }


    /**
     * @param int $categoryId
     * @return Response
     */
    public function actionGetPriceRange(int $categoryId): Response
    {
        $lowestPrice  = Goods::find()->where(['category_id' => $categoryId])->min('price');
        $highestPrice = Goods::find()->where(['category_id' => $categoryId])->max('price');

        return $this->asJson(['lowestPrice' => $lowestPrice,'highestPrice' => $highestPrice]);
    }
}
