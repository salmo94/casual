<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchPermission $searchRole
 */

use backend\helpers\WidgetsHelper;
use common\models\search\SearchPermission;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
?>

<?php $this->title = 'Права доступу';
$this->params['breadcrumbs'][] = ['label' => 'Права доступу', 'url' => ['index']]; ?>
<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchRole,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'name',
            'description',
            [
                'attribute' => 'created_at',
                'filter' => WidgetsHelper::getDateRangePicker($searchRole, 'created_at')
            ],
            ['class' => ActionColumn::class,
                'template' => false
            ]
        ]
    ]
);
?>
