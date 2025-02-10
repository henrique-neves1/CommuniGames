<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\Profiles;
use common\models\Genres;
use common\models\Platforms;
use yii\widgets\ActiveForm;
use Bluerhinos\phpMQTT;
use yii\bootstrap5\BootstrapAsset;

$user = Yii::$app->user->identity;
$profile = $user ? Profiles::findOne(['user_id' => $user->id]) : null;
$genres = Genres::find()->select(['id', 'name'])->orderBy('name')->all();
$platforms = Platforms::find()->select(['id', 'name'])->orderBy('name')->all();

$categoriesMenu = [
    'label' => 'Categories',
    'items' => [
        '<div class="dropdown-header">Genres</div>',
    ],
];

foreach ($genres as $genre) {
    $categoriesMenu['items'][] = [
        'label' => Html::encode($genre->name),
        'url' => Url::to(['game/by-genre', 'id' => $genre->id])
    ];
}

$categoriesMenu['items'][] = '<div class="dropdown-divider"></div>';
$categoriesMenu['items'][] = '<div class="dropdown-header">Platforms</div>';

foreach ($platforms as $platform) {
    $categoriesMenu['items'][] = [
        'label' => Html::encode($platform->name),
        'url' => Url::to(['game/by-platform', 'id' => $platform->id])
    ];
}

AppAsset::register($this);
BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<style>
    .navbar-nav .dropdown-menu {
        min-width: 200px;
        text-align: left;
    }

    .navbar-nav .dropdown-header {
        font-weight: bold;
    }

    .navbar-nav .dropdown-header span {
        font-size: 0.85rem;
    }

    .navbar-brand img {
        height: 30px;
        margin-right: 10px;
    }
</style>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::a(
            Html::img('@web/images/logo_horizontal_white2.png', ['alt' => 'App Logo', 'class' => 'd-inline-block align-top']),
            Yii::$app->homeUrl,
            ['class' => 'navbar-brand']
        ),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        $categoriesMenu,
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        if ($profile === null) {
            // User without a profile
            $menuItems[] = ['label' => 'Create Profile', 'url' => ['/profile/create']];
            $menuItems[] = ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];

        } else {
            // User with a profile
            $menuItems[] = ['label' => 'Cart', 'url' => ['cart/index']];
            $menuItems[] = [
                'label' => Html::img('data:image/png;base64,' . base64_encode($profile->picture_data ?? ''), [
                    'class' => 'rounded-circle',
                    'style' => 'width: 30px; height: 30px; object-fit: cover;',
                    'alt' => 'Profile Picture',
                ]),
                'items' => [
                    '<div class="dropdown-header text-center">',
                    Html::tag('strong', Html::encode($profile->name)) .
                    Html::tag('span', ' (@' . Html::encode($user->username) . ')', ['class' => 'text-muted']),
                    '</div>',
                    '<div class="dropdown-divider"></div>',
                    ['label' => 'Account', 'url' => ['/profile/view', 'id' => $profile->id]],
                    ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                ],
            ];
        }
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);

    echo '<form class="d-flex" method="get" action="' . Url::to(['game/search']) . '">';
    echo '<input class="form-control me-2" type="search" name="query" placeholder="Search for a game..." aria-label="Search">';
    echo '<button class="btn btn-outline-success" type="submit">Search</button>';
    echo '</form>';

    ?>
    <ul class="navbar-nav ms-auto">
    <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span id="notification-count" class="badge bg-danger rounded-circle" style="display: none;">0</span>
        </a>
        <ul id="notification-list" class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
            <li class="dropdown-header">Notifications</li>
            <li><hr class="dropdown-divider"></li>
        </ul>
    </li>
    </ul>

    <script>
        $(document).ready(function() {
            let notifications = [];
            let username = "<?= Yii::$app->user->identity->username ?? '' ?>";

            if (username) {
                const client = new Paho.MQTT.Client("127.0.0.1", 9001, username);

                client.onMessageArrived = function(message) {
                    let payload = message.payloadString;
                    notifications.push(payload);

                    $("#notification-list").append(`<li class="dropdown-item">${payload}</li>`);
                    $("#notification-count").text(notifications.length).show();
                };

                client.connect({
                    onSuccess: function() {
                        client.subscribe(username);
                    }
                });

                $("#notificationDropdown").on("click", function() {
                    notifications = [];
                    $("#notification-count").hide().text("0");
                });
            }
        });
    </script>
    <?php
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-start">&copy; <?= date('Y') ?> <?= Html::encode(Yii::$app->name) ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
