<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * @property      integer $id
 * @property      string $title
 * @property      integer $status
 * @property      integer $attribute_id
 * @property      boolean $is_deleted
 * @property      integer $created_at
 * @property      integer $updated_at
 * @property-read Attribute $attr
 *
 */
class AttributeValue extends BaseModel
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'attributes_value';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'],'string'],
            [['title', 'attribute_id'], 'required'],
            [['status','attribute_id'], 'integer'],
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
            'title' => 'Значення',
            'status' => 'Статус',
            'attribute_id' => 'Атрибут',
            'created_at' => 'Дата створення',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAttr(): ActiveQuery
    {
        return $this->hasOne(Attribute::class, ['id' => 'attribute_id']);
    }
}
