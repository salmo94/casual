<?php
/* @var $content string */

use kartik\alert\Alert;
use yii\bootstrap4\Breadcrumbs;

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row">
            <div class="col-lg-3">
                <?=
                Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Головна сторінка'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => $this->params['breadcrumbs'] ?? [],
                    'options' => [
                        'class' => 'breadcrumb float-sm-right'
                    ]
                ])
                ?>
            </div>
        </div>
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <?php echo Alert::widget([
                'type' => Alert::TYPE_SUCCESS,
                'icon' => 'fas fa-check-circle',
                'body' => Yii::$app->session->getFlash('success'),
                'showSeparator' => true,
                'delay' => 2000
            ]); ?>
        <?php endif; ?> <?php if (Yii::$app->session->hasFlash('error')): ?>
            <?php echo Alert::widget([
                'type' => Alert::TYPE_DANGER,
                'icon' => 'fas fa-check-circle',
                'body' => Yii::$app->session->getFlash('error'),
                'showSeparator' => true,
                'delay' => false
            ]); ?>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('warning')): ?>
            <?php echo Alert::widget([
                'type' => Alert::TYPE_WARNING,
                'icon' => 'fas fa-check-circle',
                'body' => Yii::$app->session->getFlash('warning'),
                'showSeparator' => true,
                'delay' => 4000
            ]); ?>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="mt-5">
                        <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
