<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchCategory $categorySearch
 */

use backend\helpers\WidgetsHelper;
use common\models\Category;
use common\models\search\SearchCategory;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $this->title = 'Категорії';
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['index']]; ?>
<div class="mb-3">
    <?php echo Html::a('Нова категорія', '/category/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $categorySearch,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'parent_id',
                'content' => function (Category $category) {
                    return $category->parent->title ?? '';
                },
                'filter' => WidgetsHelper::getSelect2(
                    $categorySearch,
                    'parent_id',
                    $categorySearch->parent->title ?? '',
                    'category/autocomplete'
                )
            ],
            [
                'attribute' => 'status',
                'content' => function (Category $category): string {
                    return Category::STATUS_TITLES[$category->status] ?? '';
                },
                'contentOptions' => function (Category $category) {
                    return ['style' => 'background-color:'
                        . ($category->status === Category::STATUS_HIDDEN ? 'red' : 'green')];
                },
                'filter' => Category::STATUS_TITLES
            ],
            [
                'attribute' => 'created_at',
                'filter' => WidgetsHelper::getDateRangePicker($categorySearch, 'created_at')
            ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{addAttributes} {update} {delete} ',
                'buttons' => [
                    'addAttributes' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-plus-circle"></i>',
                            Url::to(['category/add-attributes', 'id' => $model->id]), [
                                'title' => 'Додати атрибути',
                            ]);
                    },
                ],
            ],
        ]
    ]
);
?>
