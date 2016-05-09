<?php
if(getenv('APPLICATION_ENV')!=null && getenv('APPLICATION_ENV')!='production'){
	defined('YII_DEBUG') or define('YII_DEBUG', true);
	defined('YII_ENV') or define('YII_ENV', 'dev');
}
require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config_name = getenv('APPLICATION_ENV')!=null?'main-local.php':'production.php';
$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . "/../../common/config/main.php"),
    require(__DIR__ . "/../../common/config/".$config_name),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . "/../config/".$config_name)
);

$application = new yii\web\Application($config);
$application->run();
