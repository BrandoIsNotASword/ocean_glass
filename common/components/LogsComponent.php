<?php 
namespace common\components;
use yii\base\Component;
use common\models\Log;
class LogsComponent extends Component{
	public static function save($env,$data)
	{
		$l = new Log;
		$l->env = $env;
		$l->data=json_encode($data);
		$l->save();
	}
}