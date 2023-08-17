<?php
/**
 * @var ActiveDataProvider $dataProvider
 * @var SearchUser $userSearch
 * @var array $roles
 */

use common\models\search\SearchUser;
use common\models\User;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<?php $this->title = 'Список користувачів';
$this->params['breadcrumbs'][] = ['label' => 'Список користувачів', 'url' => ['index']]; ?>
<div class="mb-3">
    <?php echo Html::a('Додати користувача', '/user/create', ['class' => 'mb-2 btn btn-primary']); ?>
</div>
<?php
echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $userSearch,
        'pager' => [
            'class' => LinkPager::class,
        ],
        'columns' => [
            'id',
            'username',
            'email',
            [
                'attribute' => 'role',
                'label' => 'Ролі',
                'format' => 'raw',
                'value' => function (User $user): string {
                    $role = [];
                    foreach ($user->assignment as $assignment) {
                        $role[] = $assignment['item_name'];
                    }
                    return implode(',', $role) ?? '';
                },
                'filter' => $roles
            ],
            [
                'attribute' => 'status',
                'content' => function (User $user): string {
                    return User::USER_STATUSES[$user->status] ?? '';
                },
                'contentOptions' => function (User $user) {
                    return ['style' => 'background-color:'
                        . ($user->status === User::STATUS_INACTIVE ? 'red' : 'green')];
                },
                'filter' => User::USER_STATUSES
            ],
            'created_at',
            ['class' => ActionColumn::class,
                'template' => '{update} {delete}'
            ],
        ]
    ]
);
?>
