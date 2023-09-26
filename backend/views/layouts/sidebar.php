<?php

use common\models\User;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo 'Casual:' . User::getCurrentUsername() ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Пошук" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Товари', 'url' => ['goods/index']],
                    ['label' => 'Категорії', 'url' => ['category/index']],
                    [
                        'label' => 'Атрибути',
                        'iconStyle' => 'far',
                        'items' => [
                            ['label' => 'Список', 'url' => ['attribute/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],//'visible' => Yii::$app->user->can('viewAttributes')],
                            ['label' => 'Значення', 'Список', 'url' => ['attribute-value/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],
                    [
                        'label' => 'Контроль доступу',
                        'iconStyle' => 'far',
                        'items' => [
                            ['label' => 'Користувачі', 'url' => ['user/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],//'visible' => Yii::$app->user->can('viewAttributes')],
                            ['label' => 'Ролі', 'url' => ['role/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                            ['label' => 'Права доступу', 'url' => ['permission/index'], 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                        ]
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
