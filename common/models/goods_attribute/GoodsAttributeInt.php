<?php

namespace common\models\goods_attribute;

use common\models\BaseModel;
use common\models\Goods;

/**
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property integer $value
 */
class GoodsAttributeInt extends BaseModel
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_attributes_int';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id', 'value'], 'integer'],
            [['goods_id', 'attribute_id', 'value'], 'required'],
        ];
    }


    /**
     * @param int $goodsId
     * @param int $attributeId
     * @param int $value
     * @return void
     */
    public static function setAttributesInt(int $goodsId, int $attributeId, int $value): void
    {
        $goodsAttrsInt = new GoodsAttributeInt();
        $goodsAttrsInt->goods_id = $goodsId;
        $goodsAttrsInt->attribute_id = $attributeId;
        $goodsAttrsInt->value = $value;
        $goodsAttrsInt->save();

    }
}
