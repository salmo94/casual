<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchRole $searchRole
 * @var array $permissions
 */

use backend\helpers\WidgetsHelper;
use common\models\Role;
use common\models\search\SearchRole;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<?php $this->title = 'Ролі';
$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']]; ?>
<div class="mb-3">
    <?php echo Html::a('Додати', '/role/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
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
                'attribute' => 'permission',
                'label' => 'Права доступу',
                'format' => 'raw',
                'value' => function (Role $role): string {
                    $permissions = [];
                    foreach ($role->itemChild as $permission) {
                        $permissions[] = $permission['child'];
                    }
                    return implode(',', $permissions) ?? '';
                },
                'filter' => $permissions,
            ],
            [
                'attribute' => 'created_at',
                'filter' => WidgetsHelper::getDateRangePicker($searchRole, 'created_at')
            ],
            ['class' => ActionColumn::class,
                'template' => '{update} {delete}'
            ]
        ]
    ]
);
?>
