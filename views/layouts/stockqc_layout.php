<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backoffice\assets\StockqcAsset;

StockqcAsset::register($this);
$this->title = Yii::t('app', 'QC Panel');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="WM Page description" name="description" />
        <meta content="" name="author" />
        <link rel="icon" href="/images/fav/favicon.ico">

        <title><?= Html::encode($this->title) ?></title>
        <!-- start: GOOGLE FONTS -->
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <!-- end: GOOGLE FONTS -->
        <?php $this->head() ?>
        <script>
            var GPATH_BASE_REL = 'http://beta.inspection.gaadi.com/';
            var GPATH_DIR_PATH = '/home/deployer/inspection/dev/releases/20161228073851/';
            var GPATH_COMMON_API_BASE_URL = 'http://beta.evaluation.gaadi.com/evaluation/evaluation_app/';
            var GPATH_ASSETS_IMAGES_REL = 'http://beta.inspection.gaadi.com/assets/images/';
            var APPSIDEBARSTATUS = '';
        </script>	<!-- start: CLIP-TWO CSS -->
        <style>
            .select2-container { width: 100% !important }
            .clip-check { color: #545454 !important }
            .clip-check label { white-space: normal !important;  }
            .app-navbar-fixed { padding-top: 0px !important;;}
        </style>

        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $content ?>
        <!-- start: FOOTER -->
        <footer>
            <div class="footer-inner">
                <div class="pull-left">
                    &copy; <span class="current-year"></span><span class="text-bold text-uppercase"> Gaadi</span>. <span>All rights reserved</span>
                </div>
                <div class="pull-right">
                    <span class="go-top"><i class="ti-angle-up"></i></span>
                </div>
            </div>
        </footer>
        <!-- Overlay Div Starts Here-->
        <div id="loadwrapoverlay" class="pageoverlay">
            <div class="loadimage"></div>
        </div>
        <?php $this->endBody(); ?>
        <script>
            jQuery(document).ready(function () {
                Main.init();
                UINotifications.init();
                Common.init();

            });
        </script>
        <!-- end: JavaScript Event Handlers for this page -->
        <!-- end: CLIP-TWO JAVASCRIPTS -->
        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">QC</h4>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <script>
            var dateDefaultFormat = 'dd-mm-yyyy'
            $(document).ready(function () {
                dealerQCDatatable.initiate();
                dealerQCDatatable.qcPanelSlider();
                $('#odometer_reading_7').number(true);
                $.fn.cropper();
            });

        </script>
    </div></body></html> 
<?php $this->endPage(); ?>
