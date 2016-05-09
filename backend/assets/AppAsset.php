<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?v=1',
        'css/dashboard.css',
        'css/trumbowyg.css',
        // 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/plugins/alertifyjs/alertify.min.js',
        'js/plugins/validate/jquery.validate.min.js',
        'js/plugins/form/jquery.form.min.js',
        'js/plugins/datatables/jquery.dataTables.js?v=1',
        'js/plugins/datatables/datatables-bs3.js',
        'js/plugins/bootstrap-manager/bootstrap-modal.js',
        'js/plugins/bootstrap-manager/bootstrap-modalmanager.js',
        'js/plugins/jquery.number.min.js',
        'js/jquery-ui.min.js',
        'js/jquery.elevateZoom-3.0.8.min.js',
        'js/trumbowyg.js',
        'js/plugins/trumbowyg.base64.js',
        'js/langs/es.min.js',
        'js/cloudapps.js?v=3',
        'js/main.js?v=4',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
