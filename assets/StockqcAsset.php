<?php
namespace backoffice\assets;
use yii\web\AssetBundle;

class StockqcAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/themify-icons.min.css',
        'css/animate.min.css',
        'css/perfect-scrollbar.min.css',
        'css/switchery.min.css',
        'css/sweet-alert.css',
        'css/ie9.css',
        'css/toastr.min.css',
        'css/DT_bootstrap.css',
        'css/styles.css',
        'css/custom-styles.css',
        'css/plugins.css',
        'css/theme-6.css',
        'css/common.css',
        'css/jquery.bxslider.css',
        'css/cropper.min.css',
        'css/select2.min.css',
        'css/bootstrap-datepicker3.standalone.min.css'
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/modernizr.js',
        'js/jquery.cookie.js',
        'js/perfect-scrollbar.min.js',
        'js/switchery.min.js',
        'js/sweet-alert.min.js',
        'js/toastr.min.js',
        'js/jquery.dataTables.min.js',
        'js/main.js',
        'js/ui-notifications.js',
        'js/table-data.js',
        'js/common.js',
        'js/jquery.bxslider.min.js',
        'js/jquery.maskedinput.min.js',
        'js/jquery.bootstrap-touchspin.min.js',
        'js/autosize.min.js',
        'js/classie.js',
        'js/selectFx.js',
        'js/select2.min.js',
        'js/bootstrap-datepicker.min.js',
        'js/jquery.mousewheel.min.js',
        'js/jquery.number.min.js',
        'js/form-elements.js',
        'js/cropper.min.js',
        'js/wm_dealer_qc.js'
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\FontAwesomeAsset',
    ];

}