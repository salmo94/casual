<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read ItemChild $itemChild
 */
class Role extends BaseModel
{
    public  const TYPE_ROLE = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "auth.item";
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'description'], 'string'],
            ['type', 'default', 'value' => self::TYPE_ROLE],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Роль',
            'description' => 'Опис',
            'created_at' => 'Дата створення',
        ];
    }

    /**
     * @return string[]
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getItemChild(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ItemChild::class,['parent'  => 'name']);

    }
}
