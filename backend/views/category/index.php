<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchCategory $categorySearch
 */

use common\models\Category;
use common\models\search\SearchCategory;
use kartik\daterange\DateRangePicker;
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
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'attribute' => 'title',
            [
                'attribute' => 'parent_id',
                'content' => function (Category $category) {
                    return $category->parent->title ?? '';
                },
                'filter' => Select2::widget([
                    'model' => $categorySearch,
                    'attribute' => 'parent_id',
                    'initValueText' => $categorySearch->parent->title ?? '',
                    'language' => 'uk-UK',
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
                'filter' => DateRangePicker::widget([
                    'language' => 'uk-UK',
                    'model' => $categorySearch,
                    'attribute' => 'created_at',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'showDropdowns' => true,
                        'timePicker' => true,
                        'timePicker24Hour' => true,
                        'timePickerIncrement' => 1,
                        'locale' => [
                            'format' => 'Y-m-d H:i:00',
                            'separator' => '--',
                            'applyLabel' => 'Підтвердити',
                            'cancelLabel' => 'Відміна',
                        ],
                        'opens' => 'right',
                    ]
                ]),
            ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {delete}'
            ]
        ]
    ]
);
?>
