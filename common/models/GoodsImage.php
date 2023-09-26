<?php

namespace common\models;

/**
 * @property integer $goods_id
 * @property string $image_path
 */
class GoodsImage extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods_images';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'image_path'], 'required'],
            ['goods_id', 'integer'],
        ];
    }
}
