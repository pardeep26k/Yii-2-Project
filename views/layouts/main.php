<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/fav/favicon.ico">

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Bootstrap core CSS -->
    <link href="/backend/web/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/backend/web/css/dashboard.css" rel="stylesheet">

    <!-- Common styles for this template -->
    <link href="/backend/web/css/common.css" rel="stylesheet">

    <!-- Common styles for this template -->
    <link href="/backend/web/css/font-awesome.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="js/assets/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/backend/web/js/assets/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php //$this->head()  ?>
</head>

<body>
<?php $this->beginBody() ?>
<header>
    <div class="container-fluid">
        <div class="wrap">
            <?php
            NavBar::begin([
                //~ 'brandLabel' => 'My Company',
                //~ 'brandUrl' => Yii::$app->homeUrl,
                //~ 'options' => [
                //~ 'class' => 'navbar-inverse navbar-fixed-top',
                //~ ],
            ]);
            ?>
            <nav role="navigation" class="navbar mrg-B0">
                <div class="navbar-header top-navigation float-L">
                    <a class="navbar-brand pad-all-0  pad-T10" href="#">
                        <img src="/backend/web/images/dealer-central.png" alt="Dealer Central" title="Cealer Central"
                             class="img-responsive cd-logo"/>
                    </a>
                    <a class="navbar-brand pad-all-0 pad-L10 pad-T20 gaadi-cardekho" href="#">
                        <img src="/backend/web/images/gaadi-cardekho.png" alt="Dealer Central" title="Cealer Central"
                             class="img-responsive" width="230px"/>
                    </a>
                </div>
                <div id="login-btn-mob">
                    <ul class="nav navbar-nav navbar-right mob-login-hide">
                        <li class="pad-T10 pad-R15">Expiry Date:
                            <div class="highlight-color">04 Jan 2014</div>
                        </li>
                        <li class="pad-T10 pad-R15">
                            <?= \common\widgets\LanguageSwitcher::Widget() ?>
                        </li>
                        <li class="dropdown login-btn-mob border-R border-L">
                            <a aria-expanded="false" role="button" data-toggle="dropdown"
                               class="dropdown-toggle border-none wel-dealer" href="#">
                                <img src="/backend/web/images/support.png" alt="Dealer" title="Dealer">
                                Support <span class="caret"></span>
                            </a>
                            <ul role="menu" class="dropdown-menu welcome-dropdown">
                                <li class="text-center">
                                    <div class="support-detail"><h4>DEALER HELPLINE</h4>
                                        <div class="support-dashed"></div>
                                        <span class="support-no"><img src="/backend/web/images/call.png"
                                                                      style="vertical-align:bottom;"><strong>18004192277</strong></span><br>
                                        <span class="support-small-txt">(10:00AM - 7:00PM)</span><br>
                                        <span class="support-small-txt"><a
                                                href="mailto:dealersupport@gaadi.com?Subject=Dealer Central Feedback"
                                                target="_top">dealersupport@gaadi.com</a></span>
                                        <br>
                                        <button type="button" class="btn btn-primary mrg-T10" data-target="#feedBack"
                                                data-toggle="modal">Feedback
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php
                            if (!Yii::$app->user->isGuest)
                                echo Nav::widget([
                                    'items' => [

                                        [
                                            '<span class=""><img src="/images/user.png" alt="Dealer" title="Dealer"> 
                          Welcome </span>',
                                            'label' => Yii::$app->user->identity->username,
                                            'items' => [
                                                [
                                                    'label' => 'Home',
                                                    'url' => ['/admin'],
                                                ],
                                                '<li class="divider"></li>',
                                                [
                                                    'label' => 'Dealer-Home',
                                                    'url' => ['/dealer'],
                                                    //'visible'=>(Yii::$app->user->can('dealer') || Yii::$app->user->can('view')) ,
                                                ],
                                                '<li class="divider"></li>',
                                                [
                                                    'label' => 'Inventory-Home',
                                                    'url' => ['/inventory'],
                                                    //'visible'=>(Yii::$app->user->can('inventory') ||  Yii::$app->user->can('view')),
                                                ],
                                                '<li class="divider"></li>',
                                                [
                                                    'label' => 'Reset-Password',
                                                    'url' => ['/auth/resetpassword'],
                                                ],
                                                '<li class="divider"></li>',
                                                [
                                                    'label' => 'Logout',
                                                    'url' => ['/auth/logout'],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'options' => ['class' => 'navbar-nav navbar-right'],
                                ]);
                            NavBar::end();
                            ?>

                    </ul>

                </div><!--/.nav-collapse -->
            </nav><!--/Top Header -->
        </div>
</header>
<!--/Top Header -->


<!--/Main Menu End -->
<div class="container">
    <?=
    Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
</div>
<?= $content ?>
<footer>
    <div class="container-fluid mrg-T0 pad-all-20 pad-B15 bg-gray footer-container">
        <p class="pad-T20 pad-B0">© Copyright www.gaadi.com. All Rights Reserved.
                    <span class="float-R mrg-L30">
                        <button type="button" class="btn btn-lg btn-primary btn-" data-target="#feedBack"
                                data-toggle="modal">Feedback
                        </button>
                    </span>
                    <span class="float-R">
                        <i class="fa fa-phone font-20 dark-gray" data-unicode="f095"></i><strong
                            class="font-20 dark-gray">18004192277</strong> <br>
                        <i class="fa fa-envelope"></i> <a
                            href="mailto:dealersupport@gaadi.com?Subject=Dealer Central Feedback" target="_top"
                            style="background: transparent;">dealersupport@gaadi.com</a>
                    </span>
        </p>
    </div>
</footer>

<!-- Feedback modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     aria-hidden="true" id="feedBack">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Feedback</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div class="form-group text-left">
                        <label class="control-label search-form-label" for="inputSuccess2">Please Enter Your
                            Feedback:</label>
                        <textarea class="form-control search-form-select-box feedBack"
                                  placeholder="Type Here..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div><!-- /.modal-comment -->
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/backend/web/js/bootstrap.min.js"></script>
<script src="/backend/web/js/my.js"></script>
<!--[if IE]>
<script src="js/excanvas.js"></script><![endif]-->
<script src="/backend/web/js/html5-canvas-bar-graph.js"></script>
<script src="/backend/web/js/assets/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/backend/web/js/assets/ie10-viewport-bug-workaround.js"></script>
<script>(function () {
        if (document.getElementById('graphDiv1')) {
            function createCanvas(divName) {

                var div = document.getElementById(divName);
                var canvas = document.createElement('canvas');
                div.appendChild(canvas);
                if (typeof G_vmlCanvasManager != 'undefined') {
                    canvas = G_vmlCanvasManager.initElement(canvas);
                }
                var ctx = canvas.getContext("2d");
                return ctx;
            }

            var ctx = createCanvas("graphDiv1");

            var graph = new BarGraph(ctx);
            graph.maxValue = 100;
            graph.margin = 20;
            graph.colors = ["#e66437", "#e66437", "#e66437", "#e66437", "#e66437"];
            graph.xAxisLabelArr = ["0-5 Days", "5-10 Days", "10-20 Days", "20-30 Days", "Above 30 Days"];
            setInterval(function () {
                graph.update([Math.random() * 40, Math.random() * 50, Math.random() * 60, Math.random() * 90, Math.random() * 95]);
            }, 1000);


        } else {
            console.log('Avoided Error Message');
        }
    }());</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
