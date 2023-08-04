<?php
/* @var $content string */

use kartik\alert\Alert;
use yii\bootstrap4\Breadcrumbs;


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <?php echo Alert::widget([
                'type' => Alert::TYPE_SUCCESS,
                'icon' => 'fas fa-check-circle',
                'body' => Yii::$app->session->getFlash('success'),
                'showSeparator' => true,
                'delay' => 2000
            ]);?>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>

                </div><!-- /.col -->
                <div class="col-sm-6">

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
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
