<?php

namespace common\models;

/**
 * @property string $parent
 * @property string $child
 *
 */
class ItemChild extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return "auth.item_child";
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['parent','child'],'string'],
        ];
    }
}
