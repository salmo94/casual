<?php
/**
 * @var Category $category
 * @var ActiveDataProvider $dataProvider
 * @var SearchCategory $categorySearch
 * @var Pagination $pagination
 */

use common\models\Category;
use common\models\search\SearchCategory;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<?php $this->title = 'Список категорій';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']]; ?>

<div class="mb-3">
    <?php echo Html::a('Створити нову категорію', 'create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>

<?php
echo GridView::widget(
    [
    'dataProvider' => $dataProvider,
    'filterModel' => $categorySearch,

    'pager' => [
        'class' => LinkPager::class,],
    'columns' => [
        'id',
        [
            'attribute' => 'title',
        ],
        [
            'attribute' => 'status',
            'content' => function (Category $category): string {
                return Category::STATUS_TITLES[$category->status] ?? '';
            },
            'filter' => [
                1 => 'Активний',
                2 => 'Прихований',
            ]
        ],
        [
            'attribute' => 'parent_id',
            'content' => function (Category $category) {
                return $category->getParentName();
            },
            'filter' => $category,
        ],
        [
            'attribute' => 'created_at',
        ],
        ['class' => \yii\grid\ActionColumn::class]
    ]
    ]
);
?>
