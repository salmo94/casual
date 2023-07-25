<?php
/**
 * @var Category $category
 */

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Перегляд';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo DetailView::widget(
    [
    'model' => $category,
    'attributes' => [
        'id',
        [
            'attribute' => 'title',
        ],
        [
            'attribute' => 'status',
            'value' => function (Category $category) {
                return Category::STATUS_TITLES[$category->status] ?? '';
            }
        ],
        [
            'attribute' => 'parent_id',
            'value' => function (Category $category) {
                return $category->getParentName();
            }
        ],
        [
            'attribute' => 'created_at',
        ],
    ]
    ]
);
?>
<div class="mt-3">
    <?php echo Html::a('Назад', 'index', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
