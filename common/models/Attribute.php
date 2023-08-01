<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
 */
class Attribute extends BaseModel
{
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
            ['title', 'required'],
            ['title', 'unique', 'message' => 'Такий атрибут вже існує'],
            ['type_id','safe'],
            [['status',  'category_id'], 'integer'],
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
    public function getType(): ActiveQuery
    {
        return $this->hasOne(AttributeType::class, ['id' => 'type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
