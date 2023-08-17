<?php

namespace common\models;

/**
 * @property string $name
 * @property string $description
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */

class Permission extends BaseModel
{
    public const TYPE_PERMISSION = 2;

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
            ['type', 'default', 'value' => self::TYPE_PERMISSION],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Право доступу',
            'description' => 'Опис',
            'created_at' => 'Дата створення',
        ];
    }
}
