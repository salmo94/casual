<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * @property      integer $id
 * @property      string $title
 * @property      integer $status
 * @property      integer $type_id
 * @property      integer $category_id
 * @property      boolean $is_deleted
 * @property      integer $created_at
 * @property      integer $updated_at
 * @property-read Category $category
 *
 *
 */
class Attribute extends BaseModel
{
    public const TYPE_TEXT = 1;
    public const TYPE_INTEGER = 2;
    public const TYPE_FLOAT = 3;
    public const TYPE_BOOL = 4;
    public const TYPE_DICTIONARY = 5;
    public const TYPE_TITLES = [
        self::TYPE_TEXT => 'Текстовий',
        self::TYPE_INTEGER => 'Цілочисельний',
        self::TYPE_FLOAT => 'Дробовий',
        self::TYPE_BOOL => 'Булевий',
        self::TYPE_DICTIONARY => 'Довідниковий',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'attributes';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title','type_id','category_id'], 'required'],
            ['type_id', 'in', 'range' => array_keys(self::TYPE_TITLES), 'message' => 'Невірний тип атрибута'],
            ['title', 'unique', 'message' => 'Такий атрибут вже існує'],
            [['status',  'category_id','type_id'], 'integer'],
            ['is_deleted', 'boolean'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Назва атрибуту',
            'status' => 'Статус',
            'category_id' => 'Категорія',
            'type_id' => 'Тип категорії',
            'created_at' => 'Дата створення',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAttrValue(): ActiveQuery
    {
        return $this->hasMany(AttributeValue::class,['attribute_id' => 'id']);
    }
}
