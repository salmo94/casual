<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property      integer $id
 * @property      string $title
 */
class AttributeType extends BaseModel
{
    public const TYPE_TEXT = 1;
    public const TYPE_INTEGER = 2;
    public const TYPE_FLOAT = 3;
    public const TYPE_BOOL = 4;
    public const TYPE_INFORM = 5;
    public const TYPE_TITLES = [
        self::TYPE_TEXT => 'Текстовий',
        self::TYPE_INTEGER => 'Цілочисельний',
        self::TYPE_FLOAT => 'Дробовий',
        self::TYPE_BOOL => 'Булевий',
        self::TYPE_INFORM => 'Довідниковий',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'attribute_types';
    }

    /**
     * @return ActiveQuery
     */
    public function getAttr(): ActiveQuery
    {
        return $this->hasMany(Attribute::class,['type_id' => 'id']);
    }
}
