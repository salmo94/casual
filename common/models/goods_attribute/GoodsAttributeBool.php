<?php

namespace common\models\goods_attribute;

use common\models\BaseModel;
use common\models\Goods;
use yii\db\ActiveQuery;

/**
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property-read Goods $goods
 */
class GoodsAttributeBool extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_attributes_bool';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id'], 'integer'],
            [['goods_id', 'attribute_id'], 'required']
        ];
    }

    /**
     * @param int $goodsId
     * @param $attributeId
     * @return void
     */
    public static function setAttributeBool(int $goodsId, $attributeId): void
    {
        $goodsAttrsBool = new GoodsAttributeBool();
        $goodsAttrsBool->goods_id = $goodsId;
        $goodsAttrsBool->attribute_id = $attributeId;
        $goodsAttrsBool->save();
    }

    /**
     * @return ActiveQuery
     */
    public function getGoods(): ActiveQuery
    {
        return $this->hasOne(Goods::class,['id' => 'goods_id']);
    }
}
