<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property boolean $is_available
 * @property integer $is_deleted
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class Category extends ActiveRecord
{

    /**
     * @return string
     */

    public static function tableName(): string
    {
        return 'categories';
    }

    /**
     * @return array
     */

    public function rules(): array
    {
        return [
            [['id', 'title'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            ['is_available', 'boolean'],
            [['created_at', 'updated_at'], 'date']
        ];
    }
}