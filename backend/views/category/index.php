<?php

/**
 * @var Category $category
 * @var ActiveDataProvider $dataProvider
 * @var SearchCategory $categorySearch
 * @var Pagination $pagination
 */


use backend\assets\AppAsset;
use common\models\Category;
use common\models\search\SearchCategory;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="mb-3">
    <?php  echo Html::a('Створити нову категорію','create',['class' => 'mb-2 btn btn-primary']);?>
</div>

<?php

echo  GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $categorySearch,
    'pager' => [
        'class' => LinkPager::class,],

    'columns' => [

        'id',
        [
            'attribute' => 'title',
            'label' => 'Назва категорії',
        ],
        [
            'attribute' =>    'status',
            'label' => 'Статус',
            'content' => function(Category $category): string
            {
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
            },
            'filter' => [
                    1 => 'Активний',
                    2 => 'Прихований',
                    3 => 'Тимчасово прихований',
            ]
        ],
        [
            'attribute' =>    'parent_id',
            'label' => 'Батьківська категоорія',
            'content'=>function(Category $category) {
               return $category->getParentName();
            },
            'filter' =>  $category,

            ],
        [
            'attribute' =>    'created_at',
            'label' => 'Дата створення',
        ],
        ['class' => \yii\grid\ActionColumn::class]

    ]
]);
?>

