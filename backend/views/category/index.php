<?php
/**
 * @var array $categories
 * @var ActiveDataProvider $dataProvider
 * @var SearchCategory $categorySearch
 */

use common\models\Category;
use common\models\search\SearchCategory;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;
?>

<?php $this->title = 'Список категорій';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']]; ?>

<div class="mb-3">
    <?php echo Html::a('Створити нову категорію', '/category/create', ['class' => 'mb-2 btn btn-primary']); ?>
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
                'filter' => Category::STATUS_TITLES
            ],
            [
                'attribute' => 'parent_id',
                'content' => function (Category $category) {
                    return $category->parent->title ?? '';
                },
                'filter' => Select2::widget([
                    'model' => $categorySearch,
                    'attribute' => 'parent_id',
                    'initValueText' => false,
                    'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'ajax' => [
                            'url' => Url::to(['autocomplete']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ],
                ])
            ],
            [
                'attribute' => 'created_at',
            ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {delete}'
            ]
        ]
    ]
);
?>
