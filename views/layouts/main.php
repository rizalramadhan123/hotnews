<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100 bg-light">
<?php $this->beginBody() ?>

<!-- HEADER -->
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '<strong>' . Yii::$app->name . '</strong>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top'],
        'innerContainerOptions' => ['class' => 'container-fluid'], // ubah jadi container-fluid
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto me-3'],
    ]);
    NavBar::end();
    ?>
</header>


<!-- MAIN -->
<main id="main" class="flex-shrink-0 mt-4 pt-3">
    <div class="container-fluid">
        <div class="row">
            <!-- Optional Sidebar -->
            <?php if(!empty($this->params['sidebar'])): ?>
            <aside class="col-md-3 col-lg-2 bg-white shadow-sm p-3 mb-4 rounded">
                <?= $this->params['sidebar'] ?>
            </aside>
            <?php endif; ?>

            <!-- Content -->
            <section class="<?= !empty($this->params['sidebar']) ? 'col-md-9 col-lg-10' : 'col-12' ?> p-4 bg-white shadow-sm rounded mb-4">
                <?php if (!empty($this->params['breadcrumbs'])): ?>
                    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'], 'options' => ['class' => 'breadcrumb bg-light p-2 rounded']]) ?>
                <?php endif ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </section>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer id="footer" class="mt-auto py-3 bg-dark text-white">
    <div class="container">
       
    </div>
</footer>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


