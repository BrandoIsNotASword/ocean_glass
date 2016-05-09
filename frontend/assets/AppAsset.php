<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

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
        'css/main.css?v=7',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/plugins/validate/jquery.validate.min.js',
        'js/plugins/form/jquery.form.min.js',
        'js/jquery.elevateZoom-3.0.8.min.js',
        'js/main.js?v=7'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
