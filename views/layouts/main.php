<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app','My Company'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app','Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app','About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']],
            !Yii::$app->user->isGuest ? 
                ['label' => Yii::t('app','Profile'), 'url' => ['/user/settings/profile']]
            : '',
            Yii::$app->user->isGuest ? 
                ['label' => Yii::t('app','Login'), 'url' => ['/user/login']]
            :
                [
                  'label' => Yii::t('app', 'Logout').' (' . Yii::$app->user->identity->username . ')', 
                  'url' => ['/site/logout'],
                  'linkOptions' => ['data-method' => 'post']
                ]
            ,
            Yii::$app->user->isGuest ? 
                ['label' => Yii::t('app','Sign Up'), 'url' => ['/user/register']]
            : '',
            [
                'label' => strtoupper(Yii::$app->language),
                'items' => [
                    ['label' => 'RU', 'url' => Url::current(['language' => 'ru'])],
                    ['label' => 'EN', 'url' => Url::current(['language' => 'en'])],
                ],
            ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('app', 'My Company') . ' ' . date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
