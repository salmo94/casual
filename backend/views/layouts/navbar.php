
<?php
use yii\helpers\Html;
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Головна</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <li><?= Html::a('Вихід', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?></li>
        </li>

    </ul>
</nav>