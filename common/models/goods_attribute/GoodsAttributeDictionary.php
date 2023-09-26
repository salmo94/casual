<?php

namespace common\models\goods_attribute;

use common\models\Attribute;
use common\models\BaseModel;

/**
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property integer $value_id
 * @property-read Attribute $attr
 */
class GoodsAttributeDictionary extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_attributes_dictionary';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id', 'value_id'], 'integer'],
            [['goods_id', 'attribute_id', 'value_id'], 'required'],
        ];
    }

    /**
     * @param int $goodsId
     * @param int $attributeId
     * @param int $valueId
     * @return void
     */
    public static function setAttributesDict(int $goodsId,int $attributeId,int $valueId):void
    {
        $goodsAttrsDict = new GoodsAttributeDictionary();
        $goodsAttrsDict->goods_id = $goodsId;
        $goodsAttrsDict->attribute_id = $attributeId;
        $goodsAttrsDict->value_id = $valueId;
        $goodsAttrsDict->save();
    }


    public function getAttr()
    {
        return $this->hasOne(Attribute::class,['id' => 'attribute_id']);
    }
}
