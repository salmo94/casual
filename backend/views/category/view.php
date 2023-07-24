<?php

/**
 * @var Category $category
 */


use common\models\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;


echo DetailView::widget([
    'model' => $category,
    'attributes' => [
        'id',
        [
            'attribute' =>  'title',
            'label' => 'Категорія'
        ],
        [
                'attribute' => 'status',
                'label' =>  'Статус',
            'value' => function(Category $category) {
                switch ($category->status)
                {
                    case 1:
                        return 'Активний';
                    case 2:
                        return 'Прихований';
                    case 3:
                        return 'Тимчасово прихований';
                }
                return '';
            }
        ],
        [
                'attribute' => 'parent_id',
                'label' => 'Батьківська категорія',
                'value'=>function(Category $category) {
                return $category->getParentName();
            }
        ],
        [
            'attribute' =>  'created_at',
            'label' => 'Створено'
        ],
    ]
]);
?>

<div class="mt-3">
  <?php  echo Html::a('Назад','index',['class' => 'mb-2 btn btn-primary']);?>
</div>
