<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchAttribute $attributeSearch
 */

use backend\helpers\WidgetsHelper;
use common\models\Attribute;
use common\models\search\SearchAttribute;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;

?>
<?php $this->title = 'Список атрибутів';
$this->params['breadcrumbs'][] = ['label' => 'Список атрибутів', 'url' => ['index']]; ?>

<div class="mb-3">
    <?php echo Html::a('Новий атрибут', '/attribute/create', ['class' => 'mb-2 btn btn-primary']); ?>
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
            'title',
            [
                'attribute' => 'category_id',
                'content' => function (Attribute $attribute) {
                    return $attribute->category->title ?? '';
                },
                'filter' => WidgetsHelper::getSelect2(
                    $attributeSearch,
                    'category_id',
                    $attributeSearch->category->title ?? '',
                    'category/autocomplete'
                )
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
                'filter' => WidgetsHelper::getDateRangePicker($attributeSearch, 'created_at')
            ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{addValues} {update} {delete} ',
                'buttons' => [
                    'addValues' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-plus-circle"></i>',
                            Url::to(['attribute/add-values', 'id' => $model->id]), [
                                'title' => 'Додати значення',
                            ]);
                    },
                ],
            ],
        ]
    ]
);
?>
