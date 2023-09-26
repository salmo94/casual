<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchGoods $goodsSearch
 */

use backend\helpers\WidgetsHelper;
use common\models\Goods;
use common\models\search\SearchGoods;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
?>

<?php $this->title = 'Товари';
$this->params['breadcrumbs'][] = ['label' => 'Товари', 'url' => ['index']]; ?>
<div class="mb-3">
    <?php echo Html::a('Новий товар', '/goods/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $goodsSearch,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'title',
            'price',
            'article',
            [
                'attribute' => 'available',
                'content' => function (Goods $goods): string {
                    return Goods::AVAILABILITY_TITLES[$goods->available] ?? '';
                },
                'filter' => Goods::AVAILABILITY_TITLES,
            ],

            [
                'attribute' => 'category_id',
                'content' => function (Goods $goods): string {
                    return $goods->category->title ?? '';
                },
                'filter' => WidgetsHelper::getSelect2(
                    $goodsSearch,
                    'category_id',
                    $goodsSearch->category->title ?? '',
                    'category/autocomplete'
                )
            ],
            [
                'attribute' => 'status',
                'content' => function (Goods $goods): string {
                    return Goods::STATUS_TITLES[$goods->status] ?? '';
                },
                'contentOptions' => function (Goods $goods) {
                    return ['style' => 'background-color:'
                        . ($goods->status === Goods::STATUS_HIDDEN ? 'red' : 'green')];
                },
                'filter' => Goods::STATUS_TITLES,
            ],
            [
                'attribute' => 'created_at',
                'filter' => WidgetsHelper::getDateRangePicker($goodsSearch, 'created_at')
            ],
            ['class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {update} {delete} ',

            ],
        ],
    ]
);
?>
