<?php
/**
 * @var array $goods
 *
 */

use common\models\Goods;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Перегляд';
$this->params['breadcrumbs'][] = ['label' => 'Список товарів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo DetailView::widget(
    [
        'model' => $goods,
        'attributes' => [
            'id',
            'title',
            'price',
            'article',
            [
                'attribute' => 'status',
                'value' => function (Goods $goods) {
                    return Goods::STATUS_TITLES[$goods->status] ?? '';
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function (Goods $goods): string {
                    return $goods->category->title ?? '';
                }
            ],
            [
                'attribute' => 'available',
                'value' => function (Goods $goods): string {
                    return Goods::AVAILABILITY_TITLES[$goods->available] ?? '';
                }
            ],
            'description',

            [
                'label' => 'Images',
                'format' => ['raw'],
                'value' => function (Goods $goods) {
                    $output = '';
                    foreach ($goods->goodsImages as $image) {
                        $output .= Html::img( '@web/'. $image->image_path, ['alt' => 'Image','width' => '100px', 'height' => '100px']);
                    }
                    return $output;
                },
            ],
            'created_at',
        ]
    ]
);
?>
<div class="mt-3">
    <?php echo Html::a('Назад', 'index', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
