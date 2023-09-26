<?php

namespace common\models\goods_attribute;

use common\models\Attribute;
use common\models\BaseModel;
use Yii;

/**
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property integer $value
 */
class GoodsAttributeFloat extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_attributes_float';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id'], 'integer'],
            ['value','number'],
            [['goods_id', 'attribute_id', 'value'], 'required'],
        ];
    }

    /**
     * @param int $goodsId
     * @param int $attributeId
     * @param float $value
     * @return void
     */
    public static function setAttributesFloat(int $goodsId,int $attributeId,float $value):void
    {
        $errorAttr = Attribute::find()->select('title')->where(['id' => $attributeId ])->asArray()->one();
        $goodsAttrsFloat = new GoodsAttributeFloat();
        $goodsAttrsFloat->goods_id = $goodsId;
        $goodsAttrsFloat->attribute_id = $attributeId;
        $goodsAttrsFloat->value = $value;
        if (!$goodsAttrsFloat->save()) {
            $errorValue[] =   "Атрибут :". $errorAttr['title'] . " :не було додано" . print_r($goodsAttrsFloat->errors, true);
            Yii::$app->session->setFlash('error', implode("<br>", $errorValue));
        }
    }
}
