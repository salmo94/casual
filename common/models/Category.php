<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @property      integer $id
 * @property      string $title
 * @property      integer $status
 * @property      boolean $is_available
 * @property      integer $is_deleted
 * @property      integer $parent_id
 * @property      integer $created_at
 * @property      integer $updated_at
 * @property-read Category $parent
 */
class Category extends ActiveRecord
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_HIDDEN = 2;
    public const STATUS_TITLES = [
        self::STATUS_ACTIVE => 'Активний',
        self::STATUS_HIDDEN => 'Прихований'
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'categories';
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Назва категорії',
            'status' => 'Статус',
            'parent_id' => 'Батьківська категоорія',
            'created_at' => 'Дата створення',
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'unique', 'message' => 'Така категорія вже існує'],
            [['status', 'parent_id'], 'integer'],
            ['is_deleted', 'boolean'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }
}
