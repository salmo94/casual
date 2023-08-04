<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchAttributeValue $searchAttributeValue
 */

use backend\helpers\WidgetsHelper;
use common\models\AttributeValue;
use common\models\search\SearchAttributeValue;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<?php $this->title = 'Значення атрибутів';
$this->params['breadcrumbs'][] = ['label' => 'Значення атрибутів', 'url' => ['index']]; ?>

<div class="mb-3">
    <?php echo Html::a('Додати', '/attribute-value/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
<?php

echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchAttributeValue,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'attribute_id',
                'content' => function (AttributeValue $attributeValue) {
                    return $attributeValue->attr->title ?? '';
                },
                'filter' => WidgetsHelper::getSelect2(
                    $searchAttributeValue,
                    'attribute_id',
                    $searchAttributeValue->attr->title ?? '',
                    'attribute/autocomplete'
                )
            ],
            [
                'attribute' => 'status',
                'content' => function (AttributeValue $attributeValue): string {
                    return AttributeValue::STATUS_TITLES[$attributeValue->status] ?? '';
                },
                'contentOptions' => function (AttributeValue $attributeValue) {
                    return ['style' => 'background-color:'
                        . ($attributeValue->status === AttributeValue::STATUS_HIDDEN ? 'red' : 'green')];
                },
                'filter' => AttributeValue::STATUS_TITLES
            ],
            [
                'attribute' => 'created_at',
                'filter' => WidgetsHelper::getDateRangePicker($searchAttributeValue, 'created_at')
            ],
            ['class' => ActionColumn::class,
                'template' => '{update} {delete}'
            ]
        ]
    ]
);
?>
