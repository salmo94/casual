<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchAttribute $attributeSearch
 */

use common\models\Attribute;
use common\models\search\SearchAttribute;
use kartik\daterange\DateRangePicker;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\select2\Select2;

?>

<?php $this->title = 'Список атрибутів';
$this->params['breadcrumbs'][] = ['label' => 'Список атрибутів', 'url' => ['index']]; ?>

<div class="mb-3">
    <?php echo Html::a('Створити новий атрибут', '/attribute/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
<?php

echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $attributeSearch,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'attribute' => 'title',
            [
                'attribute' => 'category_id',
                'content' => function (Attribute $attribute) {
                    return $attribute->category->title ?? '';
                },
                'filter' => Select2::widget([
                    'model' => $attributeSearch,
                    'attribute' => 'category_id',
                    'initValueText' => $attributeSearch->category->title ?? '',
                    'language' => 'uk-UK',
                    'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'ajax' => [
                            'url' => Url::to(['category/autocomplete']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ],
                ])
            ],
            ['attribute' => 'type_id',
                'content' => function (Attribute $attribute): string {
                    return Attribute::TYPE_TITLES[$attribute->type_id] ?? '';
                },
                'filter' => Select2::widget([
                    'model' => $attributeSearch,
                    'attribute' => 'type_id',
                    'language' => 'uk-UK',
                    'data' => Attribute::TYPE_TITLES,
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Виберіть тип ...', 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ])
            ],
            [
                'attribute' => 'status',
                'content' => function (Attribute $attribute): string {
                    return Attribute::STATUS_TITLES[$attribute->status] ?? '';
                },
                'contentOptions' => function (Attribute $attribute) {
                    return ['style' => 'background-color:'
                        . ($attribute->status === Attribute::STATUS_HIDDEN ? 'red' : 'green')];
                },
                'filter' => Attribute::STATUS_TITLES
            ],
            [
                'attribute' => 'created_at',
                'filter' => DateRangePicker::widget([
                    'language' => 'uk-UK',
                    'model' => $attributeSearch,
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
