<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property boolean $is_available
 * @property integer $is_deleted
 * @property integer $parent_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read Category $parent
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
            [ 'title', 'required'],
            [['status', 'parent_id'], 'integer'],
            ['is_deleted','boolean'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }



    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Category::class,['id' => 'parent_id']);
    }

    /**
     * @return string
     */

    public function getParentName(): string
    {
        $parent = $this->parent;

        return $parent ? $parent->title : '';
    }

}