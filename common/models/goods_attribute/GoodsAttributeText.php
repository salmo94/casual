<?php

namespace common\models\goods_attribute;

use common\models\BaseModel;
use common\models\Goods;

/**
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property string $value
 * @property-read Goods $goods
 */
class GoodsAttributeText extends BaseModel
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_attributes_text';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id'], 'integer'],
            [['goods_id', 'attribute_id', 'value'], 'required'],
            ['value', 'string'],
        ];
    }


    /**
     * @param int $goodsId
     * @param int $attributeId
     * @param string $value
     * @return void
     */
    public static function setAttributeText(int $goodsId, int $attributeId, string $value): void
    {

        $goodsAttrsText = new GoodsAttributeText();
        $goodsAttrsText->goods_id = $goodsId;
        $goodsAttrsText->attribute_id = $attributeId;
        $goodsAttrsText->value = $value;
        $goodsAttrsText->save();

    }

   public function getGoods()
   {
       return $this->hasOne(Goods::class,['id' => 'goods_id']);
   }

}
