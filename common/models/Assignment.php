<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 */
class Assignment extends BaseModel
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return "auth.assignment";
    }

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            ['item_name','string'],
            ['user_id','integer'],
            ['created_at','safe']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserId(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }
}
