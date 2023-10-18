<?php

namespace common\models;

use yii\db\ActiveQuery;


/**
 * Category model
 * @property      integer $id
 * @property      string $title
 * @property      integer $status
 * @property      integer $is_deleted
 * @property      integer $parent_id
 * @property      integer $created_at
 * @property      integer $updated_at
 * @property-read Category $parent
 */
class Category extends BaseModel
{

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


    public static function getCategoriesTree(?int $parentId = null): array
    {
        $currentCategories = Category::find()
            ->select(['id','title'])
            ->where(['parent_id' => $parentId])
            ->asArray()
            ->all();

        foreach ($currentCategories as &$currentCategory) {
            $currentCategory['child'] = self::getCategoriesTree($currentCategory['id']);
        }

        return $currentCategories;

    }

    ///альтернативний варіант методу getCategoriesTree
//    public static function getChildCategory(int $parentId): array
//    {
//
//        $result = [];
//        $children = Category::find()
//            ->where(['parent_id' => $parentId])
//            ->all();
//        /**
//         * @var $children Category[]
//         */
//        foreach ($children as $child) {
//            $childData = [
//                'id' => $child->id,
//                'title' => $child->title,
//                'child' => self::getChildCategory($child->id),
//            ];
//            $result[] = $childData;
//        }
//        return $result;
//    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAttr(): ActiveQuery
    {
        return $this->hasMany(Attribute::class,['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGoods(): ActiveQuery
    {
        return $this->hasMany(Goods::class,['category_id' => 'id']);
    }
}
